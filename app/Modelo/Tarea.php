<?php
namespace App\Modelo;

use PDO;

class Tarea {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // Listado de tareas
    public function getAllByDocente($id_docente) {
        $stmt = $this->pdo->prepare("
            SELECT t.*, u.nombre AS alumno_nombre, a.ruta_archivo
            FROM tarea t
            JOIN usuario u ON t.id_alumno = u.id_usuario
            LEFT JOIN archivotarea a ON t.id_tarea = a.id_tarea
            WHERE t.id_docente = ?
            ORDER BY t.fecha_asignacion DESC
        ");
        $stmt->execute([$id_docente]);
        return $stmt->fetchAll();
    }

    public function getAllByAlumno($id_alumno) {
        $stmt = $this->pdo->prepare("
            SELECT t.*, u.nombre AS docente_nombre, a.ruta_archivo
            FROM tarea t
            JOIN usuario u ON t.id_docente = u.id_usuario
            LEFT JOIN archivotarea a ON t.id_tarea = a.id_tarea
            WHERE t.id_alumno = ?
            ORDER BY t.fecha_asignacion DESC
        ");
        $stmt->execute([$id_alumno]);
        return $stmt->fetchAll();
    }

    // Crear la tarea
    public function create($id_docente, $id_alumno, $titulo, $descripcion) {
        $stmt = $this->pdo->prepare("
            INSERT INTO tarea (id_docente, id_alumno, titulo, descripcion)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$id_docente, $id_alumno, $titulo, $descripcion]);
    }

    // Marca como completada la tarea
    public function marcarCompletada($id_tarea) {
        $stmt = $this->pdo->prepare("
            UPDATE tarea SET completada = 1, fecha_completada = NOW()
            WHERE id_tarea = ?
        ");
        return $stmt->execute([$id_tarea]);
    }
}
?>