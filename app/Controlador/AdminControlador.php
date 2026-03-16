<?php
namespace App\Controlador;

class AdminControlador {
    
    public function dashboard() {
        require_once __DIR__ . '/../../includes/auth.php';
        require_once __DIR__ . '/../../includes/db.php';

        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
            header('Location: ' . BASE_URL . 'login?error=Acceso denegado. Solo administradores.');
            exit;
        }

        // Buscamos el total de alumnos que hay registrados en la web
        $stmtAlumnos = $pdo->query("SELECT COUNT(*) FROM usuario WHERE rol = 'alumno'");
        $total_alumnos = $stmtAlumnos->fetchColumn();
        
        // Aqui los docentes
        $stmtDocentes = $pdo->query("SELECT COUNT(*) FROM usuario WHERE rol = 'docente'");
        $total_docentes = $stmtDocentes->fetchColumn();

        // Aqui las clases
        $stmtClases = $pdo->query("SELECT COUNT(*) FROM grupo");
        $total_clases = $stmtClases->fetchColumn();

        $datos = [
            'titulo' => 'Dashboard Admin - DreamClass',
            'rol' => 'admin',
            'total_alumnos' => $total_alumnos,
            'total_docentes' => $total_docentes,
            'total_clases' => $total_clases,
            'error' => $_GET['error'] ?? null,
            'success' => $_GET['success'] ?? null
        ];

        require_once __DIR__ . '/../View/admin/dashboard.php';
    }

    public function gestionarUsuarios() {
        require_once __DIR__ . '/../../includes/auth.php';
        require_once __DIR__ . '/../../includes/db.php';

        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
            header('Location: ' . BASE_URL . 'login?error=Acceso denegado.');
            exit;
        }

        // Todos los usuarios de la base de datos ordenados por los más nuevos
        $stmt = $pdo->query("SELECT id_usuario, nombre, apellidos, email, rol, fecha_registro FROM usuario ORDER BY fecha_registro DESC");
        $usuarios = $stmt->fetchAll();

        $datos = [
            'titulo' => 'Gestión de Usuarios - DreamClass',
            'rol' => 'admin',
            'usuarios' => $usuarios,
            'error' => $_GET['error'] ?? null,
            'success' => $_GET['success'] ?? null
        ];

        require_once __DIR__ . '/../View/admin/usuarios.php';
    }

    public function validacion() {
        require_once __DIR__ . '/../../includes/auth.php';
        require_once __DIR__ . '/../../includes/db.php';

        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
            header('Location: ' . BASE_URL . 'login?error=Acceso denegado.');
            exit;
        }

        // Buscamos solo a los docentes que están pendientes de validación
        $stmt = $pdo->query("
            SELECT u.id_usuario, u.nombre, u.apellidos, u.email, d.archivo_titulo, d.estado_validacion, u.fecha_registro 
            FROM usuario u 
            JOIN docente d ON u.id_usuario = d.id_docente 
            WHERE d.estado_validacion = 'pendiente' 
            ORDER BY u.fecha_registro ASC
        ");
        $docentes_pendientes = $stmt->fetchAll();

        $datos = [
            'titulo' => 'Validar Docentes - DreamClass',
            'rol' => 'admin',
            'docentes' => $docentes_pendientes,
            'error' => $_GET['error'] ?? null,
            'success' => $_GET['success'] ?? null
        ];

        require_once __DIR__ . '/../View/admin/validacion.php';
    }

    public function procesarValidacion() {
        require_once __DIR__ . '/../../includes/auth.php';
        require_once __DIR__ . '/../../includes/db.php';
        require_once __DIR__ . '/../../includes/email.php';

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
            header('Location: ' . BASE_URL . 'admin');
            exit;
        }

        $id_docente = $_POST['id_docente'] ?? '';
        $accion = $_POST['accion'] ?? ''; 

        if (empty($id_docente) || !in_array($accion, ['verificado', 'rechazado'])) {
            header('Location: ' . BASE_URL . 'admin/validacion?error=Datos inválidos.');
            exit;
        }

        try {
            $stmtDocente = $pdo->prepare("SELECT nombre, email FROM usuario WHERE id_usuario = ?");
            $stmtDocente->execute([$id_docente]);
            $docente = $stmtDocente->fetch();

            $stmt = $pdo->prepare("UPDATE docente SET estado_validacion = ? WHERE id_docente = ?");
            $stmt->execute([$accion, $id_docente]);
            
            if ($docente) {
                $nombre = $docente['nombre'];
                $email = $docente['email'];
                
                if ($accion === 'verificado') {
                    $asunto = "¡Cuenta Verificada! - DreamClass";
                    $mensajeHTML = "
                        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;'>
                            <h2 style='color: #2563eb; text-align: center;'>¡Enhorabuena, $nombre!</h2>
                            <p style='color: #555; font-size: 16px; text-align: center;'>Tu título ha sido revisado y <strong>aprobado</strong> por nuestro equipo de administración.</p>
                            <div style='background-color: #eff6ff; padding: 15px; text-align: center; border-radius: 8px; margin: 20px 0;'>
                                <p style='color: #1e3a8a; font-size: 16px; margin: 0;'>Ya tienes tu insignia de <strong>Docente Verificado</strong> en tu perfil.</p>
                            </div>
                            <div style='text-align: center;'>
                                <a href='" . BASE_URL . "login' style='background-color: #2563eb; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;'>Entrar a DreamClass</a>
                            </div>
                        </div>";
                } else {
                    $asunto = "Actualización sobre tu verificación - DreamClass";
                    $mensajeHTML = "
                        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;'>
                            <h2 style='color: #dc2626; text-align: center;'>Hola, $nombre</h2>
                            <p style='color: #555; font-size: 16px; text-align: center;'>Lamentamos informarte que tu documento ha sido <strong>rechazado</strong>. Asegúrate de que la imagen sea legible y corresponda a un título válido.</p>
                            <p style='color: #555; font-size: 16px; text-align: center;'>Puedes volver a subir un documento nuevo desde la sección de 'Mi Perfil' o contactar con soporte.</p>
                        </div>";
                }

                try {
                    enviarEmailBrevo($email, $nombre, $asunto, $mensajeHTML);
                } catch (\Exception $e) {
                    error_log("Error al enviar el email de validación: " . $e->getMessage());
                }
            }
            
            $mensaje = ($accion === 'verificado') ? 'Docente aprobado correctamente y notificado.' : 'Docente rechazado y notificado.';
            header('Location: ' . BASE_URL . 'admin/validacion?success=' . urlencode($mensaje));
            exit;
        } catch (\Exception $e) {
            header('Location: ' . BASE_URL . 'admin/validacion?error=Error al actualizar el estado.');
            exit;
        }
    }

    public function eliminarUsuario() {
        require_once __DIR__ . '/../../includes/auth.php';
        require_once __DIR__ . '/../../includes/db.php';

        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
            header('Location: ' . BASE_URL . 'login?error=Acceso denegado.');
            exit;
        }

        $id_eliminar = $_GET['id'] ?? '';

        if (empty($id_eliminar)) {
            header('Location: ' . BASE_URL . 'admin/usuarios?error=ID de usuario no especificado.');
            exit;
        }

        try {
            // Borramos sus mensajes y tareas porque como son claves foraneas nos puede dar error
            $pdo->prepare("DELETE FROM mensaje WHERE id_remitente = ? OR id_destinatario = ?")->execute([$id_eliminar, $id_eliminar]);
            $pdo->prepare("DELETE FROM tarea WHERE id_docente = ? OR id_alumno = ?")->execute([$id_eliminar, $id_eliminar]);
            
            // Despues borramos al usuario
            $stmt = $pdo->prepare("DELETE FROM usuario WHERE id_usuario = ? AND rol != 'admin'");
            $stmt->execute([$id_eliminar]);

            header('Location: ' . BASE_URL . 'admin/usuarios?success=Usuario y todos sus datos han sido eliminados.');
            exit;
        } catch (\Exception $e) {
            header('Location: ' . BASE_URL . 'admin/usuarios?error=Error al eliminar el usuario.');
            exit;
        }
    }

    public function editarUsuario() {
        require_once __DIR__ . '/../../includes/auth.php';
        require_once __DIR__ . '/../../includes/db.php';

        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
            header('Location: ' . BASE_URL . 'login?error=Acceso denegado.');
            exit;
        }

        $id = $_GET['id'] ?? '';
        $stmt = $pdo->prepare("SELECT id_usuario, nombre, apellidos, email, rol FROM usuario WHERE id_usuario = ?");
        $stmt->execute([$id]);
        $usuario = $stmt->fetch();

        if (!$usuario) {
            header('Location: ' . BASE_URL . 'admin/usuarios?error=Usuario no encontrado.');
            exit;
        }

        $datos = [
            'titulo' => 'Editar Usuario - DreamClass',
            'rol' => 'admin',
            'usuario_editar' => $usuario,
            'error' => $_GET['error'] ?? null
        ];

        require_once __DIR__ . '/../View/admin/editar_usuario.php';
    }

    public function procesarEdicionUsuario() {
        require_once __DIR__ . '/../../includes/auth.php';
        require_once __DIR__ . '/../../includes/db.php';

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
            header('Location: ' . BASE_URL . 'admin');
            exit;
        }

        $id = $_POST['id_usuario'];
        $nombre = trim($_POST['nombre']);
        $apellidos = trim($_POST['apellidos']);
        $email = trim($_POST['email']);
        $rol = $_POST['rol'];

        if (empty($nombre) || empty($email)) {
            header('Location: ' . BASE_URL . 'admin/editar_usuario?id=' . $id . '&error=Faltan datos obligatorios');
            exit;
        }

        try {
            $stmt = $pdo->prepare("UPDATE usuario SET nombre = ?, apellidos = ?, email = ?, rol = ? WHERE id_usuario = ?");
            $stmt->execute([$nombre, $apellidos, $email, $rol, $id]);
            
            header('Location: ' . BASE_URL . 'admin/usuarios?success=Usuario actualizado correctamente.');
            exit;
        } catch (\Exception $e) {
            header('Location: ' . BASE_URL . 'admin/editar_usuario?id=' . $id . '&error=Error al guardar, quizás el email ya exista.');
            exit;
        }
    }
}
?>