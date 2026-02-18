<?php
namespace App\Controlador;

class FeedbackControlador {
    
    public function index() {
        require_once __DIR__ . '/../../includes/auth.php';
        require_once __DIR__ . '/../../includes/db.php';

        if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['usuario_rol'], ['alumno', 'docente'])) {
            header('Location: ' . BASE_URL . 'login?error=Acceso denegado');
            exit;
        }

        $usuario_id = $_SESSION['usuario_id'];
        $rol = $_SESSION['usuario_rol'];

        if ($rol === 'alumno') {
            // Ve los feedbacks que le han mandado al profesaor
            $sql = "
                SELECT f.*, u.nombre AS docente_nombre, g.mes_anio as fecha, g.nivel
                FROM feedback f
                JOIN grupo g ON f.id_grupo = g.id_grupo
                JOIN usuario u ON g.id_docente = u.id_usuario
                WHERE f.id_alumno = ?
                ORDER BY f.fecha DESC
            ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$usuario_id]);
            $feedbacks = $stmt->fetchAll();
            
        } else {
            // Muestra el feedback que ha sido enviado por los alumnos
            $sql = "
                SELECT f.*, u.nombre AS alumno_nombre, g.mes_anio as fecha, g.nivel
                FROM feedback f
                JOIN grupo g ON f.id_grupo = g.id_grupo
                JOIN usuario u ON f.id_alumno = u.id_usuario
                WHERE g.id_docente = ?
                ORDER BY f.fecha DESC
            ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$usuario_id]);
            $feedbacks = $stmt->fetchAll();
        }

        // Determinar qué grupos le faltan por valorar al alumno
        $clases_sin_feedback = [];
        if ($rol === 'alumno') {
            // Solo mostramos grupos cerrados o que ya han terminado el mes para ser valorados
            $sql = "
                SELECT g.id_grupo as id_clase, u.nombre AS docente_nombre, g.mes_anio as fecha, g.nivel
                FROM inscripcion i
                JOIN grupo g ON i.id_grupo = g.id_grupo
                JOIN usuario u ON g.id_docente = u.id_usuario
                LEFT JOIN feedback f ON g.id_grupo = f.id_grupo AND f.id_alumno = i.id_alumno
                WHERE i.id_alumno = ? AND g.estado = 'cerrado' AND f.id_feedback IS NULL
            ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$usuario_id]);
            $clases_sin_feedback = $stmt->fetchAll();
        }

        $datos = [
            'titulo' => 'Mi Feedback - DreamClass',
            'rol' => $rol,
            'feedbacks' => $feedbacks,
            'clases_sin_feedback' => $clases_sin_feedback,
            'error' => $_GET['error'] ?? null,
            'success' => $_GET['success'] ?? null
        ];

        require_once __DIR__ . '/../View/feedback/index.php';
    }

    public function crear() {
        require_once __DIR__ . '/../../includes/auth.php';
        require_once __DIR__ . '/../../includes/db.php';

        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'alumno') {
            header('Location: ' . BASE_URL . 'login?error=Acceso denegado');
            exit;
        }

        $alumno_id = $_SESSION['usuario_id'];
        
        // Lo mapeamos aquí para no romper el HTML
        $id_grupo = $_GET['clase'] ?? ''; 

        // Verificar que el grupo existe, el alumno está inscrito y el grupo está cerrado
        $stmt = $pdo->prepare("
            SELECT g.id_grupo, u.nombre AS docente_nombre, g.estado, g.nivel, g.mes_anio
            FROM inscripcion i
            JOIN grupo g ON i.id_grupo = g.id_grupo
            JOIN usuario u ON g.id_docente = u.id_usuario
            WHERE g.id_grupo = ? AND i.id_alumno = ? AND g.estado = 'cerrado'
        ");
        $stmt->execute([$id_grupo, $alumno_id]);
        $grupo = $stmt->fetch();

        if (!$grupo) {
            header('Location: ' . BASE_URL . 'feedback?error=No puedes dejar feedback para este grupo o aún no ha finalizado.');
            exit;
        }

        // Verificar si ya dejó feedback
        $stmt = $pdo->prepare("SELECT id_feedback FROM feedback WHERE id_grupo = ? AND id_alumno = ?");
        $stmt->execute([$id_grupo, $alumno_id]);
        if ($stmt->fetch()) {
            header('Location: ' . BASE_URL . 'feedback?error=Ya has valorado este grupo mensual.');
            exit;
        }

        $datos = [
            'titulo' => 'Dejar Feedback - DreamClass',
            // Añadimos el nivel y mes para que la vista 
            'docente_nombre' => $grupo['docente_nombre'] . " (" . $grupo['nivel'] . " - " . date('M Y', strtotime($grupo['mes_anio'])) . ")",
            'id_clase' => $id_grupo // Mantenemos el nombre id_clase para compatibilidad con la vista
        ];

        require_once __DIR__ . '/../View/feedback/crear.php';
    }

    public function procesar() {
        require_once __DIR__ . '/../../includes/auth.php';
        require_once __DIR__ . '/../../includes/db.php';

        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'alumno') {
            header('Location: ' . BASE_URL . 'login?error=Acceso denegado');
            exit;
        }

        $id_grupo = $_POST['id_clase'] ?? '';
        $calificacion = $_POST['calificacion'] ?? '';
        $comentario = $_POST['comentario'] ?? '';

        if (empty($id_grupo) || empty($calificacion)) {
            header('Location: ' . BASE_URL . 'feedback/crear?clase=' . $id_grupo . '&error=Faltan datos obligatorios');
            exit;
        }

        if (!in_array($calificacion, ['1','2','3','4','5'])) {
            header('Location: ' . BASE_URL . 'feedback/crear?clase=' . $id_grupo . '&error=Calificación no válida');
            exit;
        }

        // Verificar que el alumno está inscrito en ese grupo
        $stmt = $pdo->prepare("SELECT id_inscripcion FROM inscripcion WHERE id_grupo = ? AND id_alumno = ?");
        $stmt->execute([$id_grupo, $_SESSION['usuario_id']]);
        if (!$stmt->fetch()) {
            header('Location: ' . BASE_URL . 'feedback?error=Grupo no válido');
            exit;
        }

        // Insertamos el feedback asociándolo al grupo
        $stmt = $pdo->prepare("INSERT INTO feedback (id_grupo, id_alumno, comentario, calificacion) VALUES (?, ?, ?, ?)");
        try {
            $stmt->execute([$id_grupo, $_SESSION['usuario_id'], $comentario, $calificacion]);
            header('Location: ' . BASE_URL . 'feedback?success=Feedback enviado correctamente');
            exit;
        } catch (\Exception $e) {
            error_log("Error al guardar feedback: " . $e->getMessage());
            header('Location: ' . BASE_URL . 'feedback/crear?clase=' . $id_grupo . '&error=Error al guardar feedback');
            exit;
        }
    }
}
?>