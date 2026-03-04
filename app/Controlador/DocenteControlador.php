<?php
namespace App\Controlador;

class DocenteControlador {
    
    public function dashboard() {
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        
        require_once __DIR__ . '/../../includes/db.php';
        require_once __DIR__ . '/../Modelo/Docente.php';
        require_once __DIR__ . '/../Modelo/Feedback.php'; 

        $id_docente = $_SESSION['usuario_id'];

        // Aqui lo que controlamos el si ya ha validado el docente o no
        // si no le asignamos pendiente
        $modeloDocente = new \App\Modelo\Docente($pdo);
        $docenteData = $modeloDocente->obtenerPorId($id_docente);
        $estadoValidacion = $docenteData['estado_validacion'] ?? 'pendiente';

        $stats = $modeloDocente->obtenerEstadisticas($id_docente);

        $modeloFeedback = new \App\Modelo\Feedback($pdo);
        $feedbackData = $modeloFeedback->obtenerResumenDocente($id_docente);

        $datos = [
            'titulo' => 'Panel Docente',
            'estado_validacion' => $estadoValidacion,
            'stats' => $stats, 
            'feedback' => $feedbackData 
        ];

        require_once __DIR__ . '/../View/docente/dashboard.php';
    }

    public function estadisticas() {
        require_once __DIR__ . '/../../includes/auth.php';
        require_once __DIR__ . '/../../includes/db.php';

        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'docente') {
            header('Location: ' . BASE_URL . 'login?error=Acceso denegado');
            exit;
        }

        $docente_id = $_SESSION['usuario_id'];

        // Estadisticas por nivel 
        $stmt = $pdo->prepare("
            SELECT nivel, COUNT(*) as total
            FROM grupo
            WHERE id_docente = ?
            GROUP BY nivel
        ");
        $stmt->execute([$docente_id]);
        $estadisticas = $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);

        $total = array_sum($estadisticas);

        // Aqui miramos cuantos alumnos por ultimo hay inscrito
        $stmt = $pdo->prepare("
            SELECT g.nivel as estado, g.mes_anio as fecha, u.nombre AS alumno_nombre
            FROM inscripcion i
            JOIN grupo g ON i.id_grupo = g.id_grupo
            JOIN usuario u ON i.id_alumno = u.id_usuario
            WHERE g.id_docente = ?
            ORDER BY i.fecha_inscripcion DESC
            LIMIT 5
        ");
        $stmt->execute([$docente_id]);
        $clases = $stmt->fetchAll();

        $datos = [
            'titulo' => 'Mis Estadísticas - DreamClass',
            'total' => $total,
            'pendientes' => $estadisticas['Primaria'] ?? 0,
            'realizadas' => $estadisticas['Secundaria'] ?? 0,
            'canceladas' => $estadisticas['Bachillerato'] ?? 0,
            'clases' => $clases
        ];

        require_once __DIR__ . '/../View/docente/estadisticas.php';
    }

    public function feedback() {
        require_once __DIR__ . '/../../includes/auth.php';
        require_once __DIR__ . '/../../includes/db.php';

        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'docente') {
            header('Location: ' . BASE_URL . 'login?error=Acceso denegado');
            exit;
        }

        $docente_id = $_SESSION['usuario_id'];

        // Consulta extrae los feedbacks uniéndolos a grupo
        $sql = "
            SELECT f.*, u.nombre AS alumno_nombre, g.mes_anio as fecha
            FROM feedback f
            JOIN grupo g ON f.id_grupo = g.id_grupo
            JOIN usuario u ON f.id_alumno = u.id_usuario
            WHERE g.id_docente = ?
            ORDER BY f.fecha DESC
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$docente_id]);
        $feedbacks = $stmt->fetchAll();

        $datos = [
            'titulo' => 'Mis Feedbacks - DreamClass',
            'feedbacks' => $feedbacks
        ];

        require_once __DIR__ . '/../View/docente/feedback.php';
    }


    public function validacion() {
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        } 
        $id_docente = $_SESSION['usuario_id'];
        
        require_once __DIR__ . '/../../includes/db.php';
        require_once __DIR__ . '/../Modelo/Docente.php';

        $modelo = new \App\Modelo\Docente($pdo);
        $docente = $modelo->obtenerPorId($id_docente);

        require_once __DIR__ . '/../View/docente/validacion.php';
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

                enviarEmailBrevo($email, $nombre, $asunto, $mensajeHTML);
            }

            $mensaje = ($accion === 'verificado') ? 'Docente aprobado y notificado.' : 'Docente rechazado y notificado.';
            header('Location: ' . BASE_URL . 'admin/validacion?success=' . urlencode($mensaje));
            exit;
        } catch (\Exception $e) {
            header('Location: ' . BASE_URL . 'admin/validacion?error=Error al actualizar el estado.');
            exit;
        }
    }
}
?>