<?php
namespace App\Controlador;

class HistorialControlador {
    
    // Muestra el panel y clases cerradas
    public function index() {
        require_once __DIR__ . '/../../includes/db.php';
        
        if ($_SESSION['usuario_rol'] !== 'docente') {
            header('Location: ' . BASE_URL . 'dashboard?error=Acceso denegado');
            exit;
        }

        $id_docente = $_SESSION['usuario_id'];

        $sql = "
            SELECT g.*, 
                   COUNT(i.id_alumno) as total_alumnos, 
                   (COUNT(i.id_alumno) * g.precio) as ganancias
            FROM grupo g
            LEFT JOIN inscripcion i ON g.id_grupo = i.id_grupo
            WHERE g.id_docente = ? AND g.estado = 'cerrado'
            GROUP BY g.id_grupo
            ORDER BY g.mes_anio DESC
        ";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_docente]);
        $historial = $stmt->fetchAll();

        // Calculamos los totales acumulados
        $total_ganado = 0;
        $total_alumnos_historicos = 0;
        foreach ($historial as $clase) {
            $total_ganado += $clase['ganancias'];
            $total_alumnos_historicos += $clase['total_alumnos'];
        }

        require_once __DIR__ . '/../View/historial/index.php';
    }

    // Esto lo hacemos para que el profesor cierre las clases
    public function finalizarClase($id_grupo) {
        require_once __DIR__ . '/../../includes/db.php';

        if ($_SESSION['usuario_rol'] !== 'docente') {
            exit;
        }

        $stmt = $pdo->prepare("UPDATE grupo SET estado = 'cerrado' WHERE id_grupo = ? AND id_docente = ?");
        $stmt->execute([$id_grupo, $_SESSION['usuario_id']]);

        header('Location: ' . BASE_URL . 'historial?success=¡Mes cerrado correctamente! Las ganancias se han sumado a tu historial.');
        exit;
    }
}
?>