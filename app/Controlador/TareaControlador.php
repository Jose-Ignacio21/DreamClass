<?php
namespace App\Controlador;

class TareaControlador {
    public function index() {
        require_once __DIR__ . '/../../includes/auth.php';
        require_once __DIR__ . '/../../includes/db.php';

        if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['usuario_rol'], ['alumno', 'docente'])) {
            header('Location: ' . BASE_URL . 'login?error=Acceso denegado');
            exit;
        }

        $usuario_id = $_SESSION['usuario_id'];
        $rol = $_SESSION['usuario_rol'];
        $estado = $_GET['estado'] ?? 'todas';

        if ($rol === 'docente') {
            $sql = "
                SELECT t.*, u.nombre AS alumno_nombre, a.ruta_archivo
                FROM tarea t
                JOIN usuario u ON t.id_alumno = u.id_usuario
                LEFT JOIN archivotarea a ON t.id_tarea = a.id_tarea
                WHERE t.id_docente = ?
            ";
            $params = [$usuario_id];
        } else {
            $sql = "
                SELECT t.*, u.nombre AS docente_nombre, a.ruta_archivo
                FROM tarea t
                JOIN usuario u ON t.id_docente = u.id_usuario
                LEFT JOIN archivotarea a ON t.id_tarea = a.id_tarea
                WHERE t.id_alumno = ?
            ";
            $params = [$usuario_id];
        }
        
        if ($estado === 'pendientes') {
            $sql .= " AND t.completada = 0";
        } elseif ($estado === 'completadas') {
            $sql .= " AND t.completada = 1";
        }

        $sql .= " ORDER BY t.fecha_asignacion DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $tareas = $stmt->fetchAll();

        $datos = [
            'titulo' => 'Mis Tareas - DreamClass',
            'rol' => $rol,
            'tareas' => $tareas,
            'estado' => $estado,
            'error' => $_GET['error'] ?? null,
            'success' => $_GET['success'] ?? null
        ];

        require_once __DIR__ . '/../View/tareas/index.php';
    }

    public function crear() {
        require_once __DIR__ . '/../../includes/auth.php';
        require_once __DIR__ . '/../../includes/db.php';

        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'docente') {
            header('Location: ' . BASE_URL . 'login?error=Acceso denegado');
            exit;
        }

        $docente_id = $_SESSION['usuario_id'];
        $stmt = $pdo->prepare("
            SELECT DISTINCT u.id_usuario, u.nombre, u.apellidos
            FROM inscripcion i
            JOIN grupo g ON i.id_grupo = g.id_grupo
            JOIN usuario u ON i.id_alumno = u.id_usuario
            WHERE g.id_docente = ?
            ORDER BY u.nombre
        ");
        $stmt->execute([$docente_id]);
        $alumnos = $stmt->fetchAll();

        $datos = [
            'titulo' => 'Asignar Tarea - DreamClass',
            'alumnos' => $alumnos,
            'error' => $_GET['error'] ?? null
        ];

        require_once __DIR__ . '/../View/tareas/crear.php';
    }

    public function procesar() {
        require_once __DIR__ . '/../../includes/auth.php';
        require_once __DIR__ . '/../../includes/db.php';

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'tareas');
            exit;
        }

        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . BASE_URL . 'login?error=Acceso denegado');
            exit;
        }

        $accion = $_POST['accion'] ?? '';

        if ($accion === 'crear') {
            if ($_SESSION['usuario_rol'] !== 'docente') {
                header('Location: ' . BASE_URL . 'login?error=Acceso denegado');
                exit;
            }

            $id_alumno = $_POST['id_alumno'] ?? '';
            $titulo = $_POST['titulo'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';
            
            if (empty($id_alumno) || empty($titulo)) {
                header('Location: ' . BASE_URL . 'tareas/crear?error=Faltan datos obligatorios');
                exit;
            }

            // Es para ver si es mi alumno
            $stmtVerificar = $pdo->prepare("
                SELECT COUNT(*) FROM inscripcion i
                JOIN grupo g ON i.id_grupo = g.id_grupo
                WHERE i.id_alumno = ? AND g.id_docente = ?
            ");
            $stmtVerificar->execute([$id_alumno, $_SESSION['usuario_id']]);
            
            if (!$stmtVerificar->fetchColumn()) {
                 header('Location: ' . BASE_URL . 'tareas/crear?error=Este alumno no está en tus grupos');
                 exit;
            }

            // Insertamos en la base de datos 
            $stmt = $pdo->prepare("INSERT INTO tarea (id_docente, id_alumno, titulo, descripcion, fecha_asignacion, completada) VALUES (?, ?, ?, ?, NOW(), 0)");
            
            try {
                $stmt->execute([$_SESSION['usuario_id'], $id_alumno, $titulo, $descripcion]);

                header('Location: ' . BASE_URL . 'tareas?success=Tarea asignada correctamente');
                exit;
            } catch (\Exception $e) {
                error_log("Error al crear tarea: " . $e->getMessage());
                header('Location: ' . BASE_URL . 'tareas/crear?error=Error al asignar tarea');
                exit;
            }

        } elseif ($accion === 'completar') {
            if ($_SESSION['usuario_rol'] !== 'alumno') {
                header('Location: ' . BASE_URL . 'login?error=Acceso denegado');
                exit;
            }

            $id_tarea = $_POST['id_tarea'] ?? '';
            $stmt = $pdo->prepare("UPDATE tarea SET completada = 1, fecha_completada = NOW() WHERE id_tarea = ? AND id_alumno = ?");
            try {
                $stmt->execute([$id_tarea, $_SESSION['usuario_id']]);
                header('Location: ' . BASE_URL . 'tareas?success=Tarea marcada como completada');
                exit;
            } catch (\Exception $e) {
                error_log("Error al completar tarea: " . $e->getMessage());
                header('Location: ' . BASE_URL . 'tareas?error=Error al completar tarea');
                exit;
            }
        }
    }
}
?>