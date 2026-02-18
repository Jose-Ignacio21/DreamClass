<?php
namespace App\Controlador;

class HomeControlador {
    public function index() {
        require_once __DIR__ . '/../../includes/auth.php';
        
        // Si ya hay sesión iniciada, redirigimos al panel correspondiente
        if (isset($_SESSION['usuario_id'])) {
            $ruta = ($_SESSION['usuario_rol'] === 'docente') ? 'docente' : 'alumno';
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