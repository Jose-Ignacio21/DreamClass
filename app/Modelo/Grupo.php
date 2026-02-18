<?php
namespace App\Modelo;

use PDO;

class Grupo {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Crea la oferta del mes
    public function crear($id_docente, $nivel, $mes_anio, $precio) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO grupo (id_docente, nivel, mes_anio, precio) VALUES (?, ?, ?, ?)");
            return $stmt->execute([$id_docente, $nivel, $mes_anio, $precio]);
        } catch (\PDOException $e) {
            if ($e->getCode() == 23000) {
                throw new \Exception("Ya has publicado un grupo de $nivel para ese mes.");
            }
            throw $e;
        }
    }

    // El docente ve sus grupos y ve cuantos alumnos tiene inscritos 
    public function obtenerGruposPorDocente($id_docente) {
        $stmt = $this->pdo->prepare("
            SELECT g.*, COUNT(i.id_alumno) as total_alumnos 
            FROM grupo g
            LEFT JOIN inscripcion i ON g.id_grupo = i.id_grupo
            WHERE g.id_docente = ? AND g.estado = 'abierto'
            GROUP BY g.id_grupo
            ORDER BY g.mes_anio DESC, g.nivel ASC
        ");
        $stmt->execute([$id_docente]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // El alumno es dondeve los grupos que hay disponibles
    public function obtenerGruposDisponibles($mes_actual) {
        $stmt = $this->pdo->prepare("
            SELECT g.*, u.nombre as nombre_profe, u.apellidos as apellidos_profe
            FROM grupo g
            JOIN usuario u ON g.id_docente = u.id_usuario
            WHERE g.estado = 'abierto' AND g.mes_anio >= ?
            ORDER BY g.mes_anio ASC, g.nivel ASC
        ");
        $stmt->execute([$mes_actual]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // El alumno se inscribe a un grupo
    public function inscribir($id_grupo, $id_alumno) {
        try {
            $stmtVerificar = $this->pdo->prepare("
                SELECT COUNT(*) FROM inscripcion i
                JOIN grupo g ON i.id_grupo = g.id_grupo
                WHERE i.id_alumno = ? AND g.mes_anio = (SELECT mes_anio FROM grupo WHERE id_grupo = ?)
            ");
            $stmtVerificar->execute([$id_alumno, $id_grupo]);
            
            if ($stmtVerificar->fetchColumn() > 0) {
                throw new \Exception("Solo puedes inscribirte en un nivel por mes.");
            }

            $stmt = $this->pdo->prepare("INSERT INTO inscripcion (id_grupo, id_alumno) VALUES (?, ?)");
            return $stmt->execute([$id_grupo, $id_alumno]);
            
        } catch (\PDOException $e) {
            if ($e->getCode() == 23000) {
                throw new \Exception("Ya estás inscrito en este grupo específico.");
            }
            throw $e;
        }
    }
    
    // El docente ve la lista de alumnos dentro de un grupo
    public function obtenerAlumnosPorGrupo($id_grupo, $id_docente) {
        $stmt = $this->pdo->prepare("
            SELECT u.id_usuario, u.nombre, u.apellidos, u.email, i.fecha_inscripcion
            FROM inscripcion i
            JOIN usuario u ON i.id_alumno = u.id_usuario
            JOIN grupo g ON i.id_grupo = g.id_grupo
            WHERE i.id_grupo = ? AND g.id_docente = ?
            ORDER BY u.nombre ASC
        ");
        $stmt->execute([$id_grupo, $id_docente]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // El alumno ve a que grupos esta inscrito solo los abiertos
    public function obtenerGruposPorAlumno($id_alumno) {
        $stmt = $this->pdo->prepare("
            SELECT g.*, u.nombre as nombre_profe, u.apellidos as apellidos_profe, i.fecha_inscripcion
            FROM inscripcion i
            JOIN grupo g ON i.id_grupo = g.id_grupo
            JOIN usuario u ON g.id_docente = u.id_usuario
            WHERE i.id_alumno = ? AND g.estado = 'abierto'
            ORDER BY g.mes_anio DESC
        ");
        $stmt->execute([$id_alumno]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>