<?php
namespace App\Modelo;

use PDO;

class Horario {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Obtiene los horarios agrupados
    public function getAllByDocente($id_docente) {
        // ELT() para convertir el número en texto
        $stmt = $this->pdo->prepare("
            SELECT 
                ELT(dia_semana, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo') as nombre_dia,
                id_horario, 
                hora_inicio, 
                hora_fin 
            FROM horario
            WHERE id_docente = ?
            ORDER BY dia_semana, hora_inicio
        ");
        $stmt->execute([$id_docente]);
        return $stmt->fetchAll(\PDO::FETCH_GROUP | \PDO::FETCH_ASSOC);
    }

    // Funcion de crear la clase
    public function create($id_docente, $dia_semana, $hora_inicio, $hora_fin) {
        // Verifica solapamiento
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) FROM horario 
            WHERE id_docente = ? AND dia_semana = ? 
            AND NOT (hora_fin <= ? OR hora_inicio >= ?)
        ");
        $stmt->execute([$id_docente, $dia_semana, $hora_inicio, $hora_fin]);
        if ($stmt->fetchColumn()) {
            throw new \Exception('Este horario se solapa con uno existente');
        }

        $stmt = $this->pdo->prepare("
            INSERT INTO horario (id_docente, dia_semana, hora_inicio, hora_fin)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$id_docente, $dia_semana, $hora_inicio, $hora_fin]);
    }

    // Borra un hueco en el horario
    public function delete($id_horario, $id_docente) {
        $stmt = $this->pdo->prepare("DELETE FROM horario WHERE id_horario = ? AND id_docente = ?");
        return $stmt->execute([$id_horario, $id_docente]);
    }
}
?>