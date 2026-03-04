<?php
namespace App\Controlador;

class HomeControlador {
    public function index() {
        require_once __DIR__ . '/../../includes/auth.php';
        
        if (isset($_SESSION['usuario_id'])) {
            if ($_SESSION['usuario_rol'] === 'admin') {
                $ruta = 'admin';
            } elseif ($_SESSION['usuario_rol'] === 'docente') {
                $ruta = 'docente';
            } else {
                $ruta = 'alumno';
            }
            header('Location: ' . BASE_URL . $ruta);
            exit;
        }

        $datos = [
            'titulo' => 'DreamClass - Gestiona tus clases particulares'
        ];

        require_once __DIR__ . '/../View/home.php';
    }
}
?>