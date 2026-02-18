<?php
namespace App\Controlador;

class RecursoControlador {
    
    public function index() {
        require_once __DIR__ . '/../../includes/db.php';
        
        if ($_SESSION['usuario_rol'] !== 'docente') {
            header('Location: ' . BASE_URL . 'dashboard?error=Acceso denegado');
            exit;
        }

        $id_docente = $_SESSION['usuario_id'];

        $stmt = $pdo->prepare("SELECT * FROM recurso WHERE id_docente = ? ORDER BY asignatura ASC, fecha_subida DESC");
        $stmt->execute([$id_docente]);
        $recursos_raw = $stmt->fetchAll();

        $recursos = [];
        foreach ($recursos_raw as $rec) {
            $recursos[$rec['asignatura']][] = $rec;
        }

        require_once __DIR__ . '/../View/recursos/index.php';
    }

    public function subir() {
        require_once __DIR__ . '/../../includes/db.php';

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || $_SESSION['usuario_rol'] !== 'docente') {
            header('Location: ' . BASE_URL . 'recursos');
            exit;
        }

        $id_docente = $_SESSION['usuario_id'];
        $asignatura = trim($_POST['asignatura'] ?? 'General');
        
        if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
            $nombre_original = $_FILES['archivo']['name'];
            $tmp_name = $_FILES['archivo']['tmp_name'];

            $extension = pathinfo($nombre_original, PATHINFO_EXTENSION);
            $nombre_fisico = uniqid('rec_') . '.' . $extension;

            $ruta_destino = __DIR__ . '/../../public/uploads/recursos/' . $nombre_fisico;

            if (move_uploaded_file($tmp_name, $ruta_destino)) {
                $stmt = $pdo->prepare("INSERT INTO recurso (id_docente, asignatura, nombre_original, archivo_fisico) VALUES (?, ?, ?, ?)");
                $stmt->execute([$id_docente, $asignatura, $nombre_original, $nombre_fisico]);
                
                header('Location: ' . BASE_URL . 'recursos?success=Recurso subido correctamente');
                exit;
            } else {
                header('Location: ' . BASE_URL . 'recursos?error=Error al mover el archivo al servidor');
                exit;
            }
        } else {
            header('Location: ' . BASE_URL . 'recursos?error=No se seleccionó ningún archivo o hubo un error');
            exit;
        }
    }

    public function eliminar($id_recurso) {
        require_once __DIR__ . '/../../includes/db.php';

        if ($_SESSION['usuario_rol'] !== 'docente') {
            exit;
        }

        $id_docente = $_SESSION['usuario_id'];

        $stmt = $pdo->prepare("SELECT archivo_fisico FROM recurso WHERE id_recurso = ? AND id_docente = ?");
        $stmt->execute([$id_recurso, $id_docente]);
        $recurso = $stmt->fetch();

        if ($recurso) {
            $ruta_archivo = __DIR__ . '/../../public/uploads/recursos/' . $recurso['archivo_fisico'];
            if (file_exists($ruta_archivo)) {
                unlink($ruta_archivo);
            }
            
            $stmtDel = $pdo->prepare("DELETE FROM recurso WHERE id_recurso = ?");
            $stmtDel->execute([$id_recurso]);
            
            header('Location: ' . BASE_URL . 'recursos?success=Recurso eliminado');
        } else {
            header('Location: ' . BASE_URL . 'recursos?error=Recurso no encontrado');
        }
        exit;
    }
}
?>