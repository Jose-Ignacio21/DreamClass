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
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        } 
        $id_docente = $_SESSION['usuario_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['titulo'])) {
            
            $archivo = $_FILES['titulo'];
            $nombreOriginal = $archivo['name'];
            $tipo = $archivo['type'];
            $tmpName = $archivo['tmp_name'];
            $error = $archivo['error'];
            $tamano = $archivo['size'];

            $ext = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));
            $permitidos = ['pdf', 'jpg', 'jpeg', 'png'];

            if (!in_array($ext, $permitidos)) {
                header('Location: ' . BASE_URL . 'docente/validacion?error=Formato no permitido. Usa PDF o Imagen.');
                exit;
            }

            if ($tamano > 5 * 1024 * 1024) { 
                header('Location: ' . BASE_URL . 'docente/validacion?error=El archivo es demasiado grande (Máx 5MB).');
                exit;
            }

            $carpetaDestino = __DIR__ . '/../../public/uploads/titulos/';
            if (!file_exists($carpetaDestino)) {
                mkdir($carpetaDestino, 0777, true);
            }

            // Generar nombre único para no sobrescribir
            $nombreFinal = 'titulo_' . $id_docente . '_' . time() . '.' . $ext;
            $rutaDestino = $carpetaDestino . $nombreFinal;

            // Coger el archivo de la carpeta temporal y llevarlo a la carpeta creada
            if (move_uploaded_file($tmpName, $rutaDestino)) {
                require_once __DIR__ . '/../../includes/db.php';
                require_once __DIR__ . '/../Modelo/Docente.php';
                
                $modelo = new \App\Modelo\Docente($pdo);
                $modelo->subirTitulo($id_docente, $nombreFinal);

                header('Location: ' . BASE_URL . 'docente?mensaje=Documento subido correctamente. En revisión.');
            } else {
                header('Location: ' . BASE_URL . 'docente/validacion?error=Error al subir el archivo al servidor.');
            }
        }
    }
}
?>