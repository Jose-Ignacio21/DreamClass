<?php
namespace App\Modelo;

use PDO;

class Feedback {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Muestra los feedbacks tanto del alumno como para el docente
    public function getAllByAlumno($id_alumno) {
        $stmt = $this->pdo->prepare("
            SELECT f.*, u.nombre AS docente_nombre, c.fecha
            FROM feedback f
            JOIN clase c ON f.id_clase = c.id_clase
            JOIN usuario u ON c.id_docente = u.id_usuario
            WHERE c.id_alumno = ?
            ORDER BY f.fecha DESC
        ");
        $stmt->execute([$id_alumno]);
        return $stmt->fetchAll();
    }

    public function getAllByDocente($id_docente) {
        $stmt = $this->pdo->prepare("
            SELECT f.*, u.nombre AS alumno_nombre, c.fecha
            FROM feedback f
            JOIN clase c ON f.id_clase = c.id_clase
            JOIN usuario u ON c.id_alumno = u.id_usuario
            WHERE c.id_docente = ?
            ORDER BY f.fecha DESC
        ");
        $stmt->execute([$id_docente]);
        return $stmt->fetchAll();
    }

    // Crear el feedback
    public function create($id_clase, $id_alumno, $comentario, $calificacion) {
        $stmt = $this->pdo->prepare("
            INSERT INTO feedback (id_clase, id_alumno, comentario, calificacion)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$id_clase, $id_alumno, $comentario, $calificacion]);
    }

   public function obtenerResumenDocente($id_docente) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT COUNT(*) as total_valoraciones, 
                       COALESCE(AVG(f.calificacion), 0) as nota_media
                FROM feedback f
                JOIN grupo g ON f.id_grupo = g.id_grupo
                WHERE g.id_docente = ?
            ");
            $stmt->execute([$id_docente]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            return ['total_valoraciones' => 0, 'nota_media' => 0];
        }
    }
}
?>