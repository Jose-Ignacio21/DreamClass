<?php
namespace App\Modelo;

use PDO;

class Docente {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function obtenerPorId($id_docente) {
        $stmt = $this->pdo->prepare("SELECT * FROM docente WHERE id_docente = ?");
        $stmt->execute([$id_docente]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerEstadisticas($id_docente) {
        // Hacemos una consulta para saber los grupos que estan abiertos
        $stmtGrupos = $this->pdo->prepare("SELECT COUNT(*) FROM grupo WHERE id_docente = ? AND estado = 'abierto'");
        $stmtGrupos->execute([$id_docente]);
        $total_grupos = $stmtGrupos->fetchColumn() ?: 0;

        // Contamos los alumnos y sumamos el dinero de los grupos abiertos que tienes hasta ahora'
        $stmtDatos = $this->pdo->prepare("
            SELECT 
                COUNT(i.id_alumno) as total_alumnos,
                COALESCE(SUM(g.precio), 0) as ingresos
            FROM inscripcion i
            JOIN grupo g ON i.id_grupo = g.id_grupo
            WHERE g.id_docente = ? AND g.estado = 'abierto'
        ");
        $stmtDatos->execute([$id_docente]);
        $datos = $stmtDatos->fetch(\PDO::FETCH_ASSOC);

        $total_alumnos = $datos['total_alumnos'] ?? 0;
        $ingresos = $datos['ingresos'] ?? 0;

        return [
            'total_grupos' => $total_grupos,     
            'total_alumnos' => $total_alumnos,
            'ingresos_totales' => $ingresos  
        ];
    }

    // Subida del titulo
    public function subirTitulo($id_docente, $nombre_archivo) {
        try {
            $sql = "UPDATE docente 
                    SET archivo_titulo = ?, 
                        estado_validacion = 'pendiente' 
                    WHERE id_docente = ?";
            
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$nombre_archivo, $id_docente]);
        } catch (\Exception $e) {
            return false;
        }
    }
}
?>