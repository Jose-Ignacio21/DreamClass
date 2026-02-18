<?php
namespace App\Modelo;

use PDO;

class Alumno {
    // Creamos una conexion privada
    private $pdo;

    // El constructor que se ejecuta cuando hacemos una nueva instancia
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function obtenerProximaClase($id_alumno) {
        try {
            $sql = "SELECT 
                        c.fecha, 
                        c.hora_inicio, 
                        u.nombre as nombre_profe, 
                        u.apellidos as apellido_profe,
                        'Clase Particular' as materia 
                    FROM clase c
                    JOIN usuario u ON c.id_docente = u.id_usuario
                    WHERE c.id_alumno = ? 
                    AND c.fecha >= CURDATE()
                    ORDER BY c.fecha ASC, c.hora_inicio ASC
                    LIMIT 1";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id_alumno]);
            
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function obtenerProgresoHoy($id_alumno) {
        try {
            $hoy = date('Y-m-d');
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM tarea WHERE id_alumno = ? AND fecha_limite = ?");
            $stmt->execute([$id_alumno, $hoy]);
            $total = $stmt->fetchColumn();

            if ($total == 0) {
                return ['porcentaje' => 0, 'total' => 0, 'completadas' => 0];
            }

            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM tarea WHERE id_alumno = ? AND fecha_limite = ? AND estado = 'completada'");
            $stmt->execute([$id_alumno, $hoy]);
            // Extraemos el dato en especifico
            $completadas = $stmt->fetchColumn();

            $porcentaje = ($completadas / $total) * 100;

            return [
                'porcentaje' => round($porcentaje),
                'total' => $total,
                'completadas' => $completadas
            ];
        } catch (\Exception $e) {
            return ['porcentaje' => 0, 'total' => 0, 'completadas' => 0];
        }
    }
}
?>