<?php
namespace App\Controlador;

class ChatControlador {
    
    public function index() {
        require_once __DIR__ . '/../../includes/auth.php';
        require_once __DIR__ . '/../../includes/db.php';
        
        if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['usuario_rol'], ['alumno', 'docente'])) {
            header('Location: ' . BASE_URL . 'login?error=Acceso denegado');
            exit;
        }

        $usuario_id = $_SESSION['usuario_id'];
        $rol = $_SESSION['usuario_rol'];

        // Obtenemos los contactos basados en los que estan en los grupos
        if ($rol === 'docente') {
            $sql = "
                SELECT DISTINCT u.id_usuario, u.nombre, u.apellidos
                FROM inscripcion i
                JOIN grupo g ON i.id_grupo = g.id_grupo
                JOIN usuario u ON i.id_alumno = u.id_usuario
                WHERE g.id_docente = ?
                ORDER BY u.nombre
            ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$usuario_id]);
            $contactos = $stmt->fetchAll();
            $titulo_contactos = "Mis alumnos inscritos";
        } else {
            // El alumno ve a los docentes de los grupos a los que está inscrito
            $sql = "
                SELECT DISTINCT u.id_usuario, u.nombre, u.apellidos
                FROM inscripcion i
                JOIN grupo g ON i.id_grupo = g.id_grupo
                JOIN usuario u ON g.id_docente = u.id_usuario
                WHERE i.id_alumno = ?
                ORDER BY u.nombre
            ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$usuario_id]);
            $contactos = $stmt->fetchAll();
            $titulo_contactos = "Mis docentes";
        }

        $datos = [
            'titulo' => 'Mis Chats - DreamClass',
            'rol' => $rol,
            'contactos' => $contactos,
            'titulo_contactos' => $titulo_contactos,
            'error' => $_GET['error'] ?? null
        ];

        require_once __DIR__ . '/../View/chat/index.php';
    }

    public function ver($contacto_id) {
        require_once __DIR__ . '/../../includes/auth.php';
        require_once __DIR__ . '/../../includes/db.php';

        if (empty($contacto_id)) {
            $contacto_id = $_GET['id'] ?? '';
        }

        if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['usuario_rol'], ['alumno', 'docente'])) {
            header('Location: ' . BASE_URL . 'login?error=Acceso denegado');
            exit;
        }

        $usuario_id = $_SESSION['usuario_id'];
        $rol = $_SESSION['usuario_rol'];

        if ($rol === 'docente') {
            $contacto_rol = 'alumno';
            // Aqui buscamos que si el alumno esta inscrito en algunos de los grupos
            $sql_verificacion = "
                SELECT COUNT(*) FROM inscripcion i 
                JOIN grupo g ON i.id_grupo = g.id_grupo 
                WHERE i.id_alumno = ? AND g.id_docente = ?
            ";
            $params = [$contacto_id, $usuario_id];
        } else {
            $contacto_rol = 'docente';
            // Aqui comprobamos si el docente esta impartiendome clases a mi
            // es decir, si el docente imparte clases en algunas de las que estoy inscrito
            $sql_verificacion = "
                SELECT COUNT(*) FROM inscripcion i 
                JOIN grupo g ON i.id_grupo = g.id_grupo 
                WHERE i.id_alumno = ? AND g.id_docente = ?
            ";
            $params = [$usuario_id, $contacto_id];
        }

        $stmt = $pdo->prepare($sql_verificacion);
        $stmt->execute($params);
        
        if (!$stmt->fetchColumn()) {
            header('Location: ' . BASE_URL . 'mensajes?error=No tienes relación académica con este usuario.');
            exit;
        }

        $stmt = $pdo->prepare("SELECT nombre FROM usuario WHERE id_usuario = ? AND rol = ?");
        $stmt->execute([$contacto_id, $contacto_rol]);
        $contacto = $stmt->fetch();
        
        if (!$contacto) {
            header('Location: ' . BASE_URL . 'mensajes?error=Usuario no válido.');
            exit;
        }

        $pdo->prepare("UPDATE mensaje SET leido = 1 WHERE id_remitente = ? AND id_destinatario = ?")
             ->execute([$contacto_id, $usuario_id]);

             // Buscamos los mensajes de los dos ordenado por fecha de mas antigua a mas nueva
        $stmt = $pdo->prepare("
            SELECT m.*, u.nombre AS remitente_nombre
            FROM mensaje m
            JOIN usuario u ON m.id_remitente = u.id_usuario
            WHERE (m.id_remitente = ? AND m.id_destinatario = ?)
               OR (m.id_remitente = ? AND m.id_destinatario = ?)
            ORDER BY m.fecha_hora ASC
        ");
        $stmt->execute([$usuario_id, $contacto_id, $contacto_id, $usuario_id]);
        $mensajes = $stmt->fetchAll();

        $datos = [
            'titulo' => 'Chat con ' . htmlspecialchars($contacto['nombre']) . ' - DreamClass',
            'rol' => $rol,
            'contacto_nombre' => $contacto['nombre'],
            'contacto_id' => $contacto_id,
            'mensajes' => $mensajes
        ];

        require_once __DIR__ . '/../View/chat/ver.php';
    }

    public function enviar() {
        require_once __DIR__ . '/../../includes/auth.php';
        require_once __DIR__ . '/../../includes/db.php';
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'mensajes');
            exit;
        }

        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . BASE_URL . 'login?error=Acceso denegado');
            exit;
        }

        $destinatario = $_POST['destinatario'] ?? '';
        $mensaje = trim($_POST['mensaje'] ?? '');

        if (empty($destinatario) || empty($mensaje)) {
            header('Location: ' . BASE_URL . 'mensajes/ver?id=' . $destinatario . '&error=Mensaje vacío');
            exit;
        }

        $rol = $_SESSION['usuario_rol'];
        
        // Vuelve a ejecutar la misma consulta SQL que antes para ver si hay relacion entre el alumno y el docente
        if ($rol === 'docente') {
            $sql = "SELECT COUNT(*) FROM inscripcion i JOIN grupo g ON i.id_grupo = g.id_grupo WHERE g.id_docente = ? AND i.id_alumno = ?";
            $params = [$_SESSION['usuario_id'], $destinatario];
        } else {
            $sql = "SELECT COUNT(*) FROM inscripcion i JOIN grupo g ON i.id_grupo = g.id_grupo WHERE i.id_alumno = ? AND g.id_docente = ?";
            $params = [$_SESSION['usuario_id'], $destinatario];
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        if (!$stmt->fetchColumn()) {
            header('Location: ' . BASE_URL . 'mensajes?error=No puedes chatear con este usuario');
            exit;
        }
        
        // Guardamos el mensaje en la base de datos
        $stmt = $pdo->prepare("INSERT INTO mensaje (id_remitente, id_destinatario, contenido) VALUES (?, ?, ?)");
        try {
            $stmt->execute([$_SESSION['usuario_id'], $destinatario, $mensaje]);

            require_once __DIR__ . '/../../includes/email.php';

            // Recoge el nombre y el email del destinatario
            $stmtUser = $pdo->prepare("SELECT nombre, email FROM usuario WHERE id_usuario = ?");
            $stmtUser->execute([$destinatario]);
            $datosDestinatario = $stmtUser->fetch();

            if ($datosDestinatario) {
                
                $remitente_nombre = $_SESSION['usuario_nombre']; 
                $asunto = "Tienes un nuevo mensaje de $remitente_nombre";

                $htmlChat = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 25px; border: 1px solid #e2e8f0; border-radius: 12px; background-color: #f8fafc;'>
                    <div style='background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); text-align: center;'>
                        <div style='width: 60px; height: 60px; background-color: #2563eb; color: white; border-radius: 50%; line-height: 60px; font-size: 24px; margin: 0 auto 20px; font-weight: bold;'>
                            " . strtoupper(substr($remitente_nombre, 0, 1)) . "
                        </div>
                        
                        <h2 style='color: #1e293b; margin-bottom: 10px;'>¡Hola, " . $datosDestinatario['nombre'] . "!</h2>
                        <p style='color: #475569; font-size: 16px; margin-bottom: 25px;'><strong>$remitente_nombre</strong> te ha enviado un nuevo mensaje a través del chat de DreamClass.</p>
                        
                        <a href='" . BASE_URL . "mensajes/ver?id=" . $_SESSION['usuario_id'] . "' 
                           style='background-color: #2563eb; color: #ffffff; padding: 12px 25px; text-decoration: none; border-radius: 8px; font-weight: bold; display: inline-block;'>
                           Leer mensaje
                        </a>
                        
                        <p style='color: #94a3b8; font-size: 13px; margin-top: 25px;'>
                            Por motivos de privacidad, no incluimos el contenido del mensaje en este correo.
                        </p>
                    </div>
                </div>";

                enviarEmailBrevo($datosDestinatario['email'], $datosDestinatario['nombre'], $asunto, $htmlChat);
            }

            header('Location: ' . BASE_URL . 'mensajes/ver?id=' . $destinatario);
            exit;
        } catch (\Exception $e) {
            error_log("Error al enviar mensaje: " . $e->getMessage());
            header('Location: ' . BASE_URL . 'mensajes/ver?id=' . $destinatario . '&error=Error al enviar mensaje');
            exit;
        }
    }
}
?>