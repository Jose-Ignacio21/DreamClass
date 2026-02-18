<?php
namespace App\Controlador;

require_once __DIR__ . '/../Modelo/Usuario.php';

use App\Modelo\Usuario;

class PerfilControlador {

    public function mostrar() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }

        require_once __DIR__ . '/../../includes/db.php';
        
        $modeloUsuario = new Usuario($pdo);
        $usuario = $modeloUsuario->obtenerPorId($_SESSION['usuario_id']);

        $datos = [
            'titulo' => 'Mi Perfil',
            'usuario' => $usuario
        ];
        
        $rutaVista = __DIR__ . '/../View/perfil/perfil.php'; 

        if (file_exists($rutaVista)) {
            require_once $rutaVista;
        } else {
            die("Error: No se encuentra la vista en " . $rutaVista);
        }
    }

    public function actualizar() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        require_once __DIR__ . '/../../includes/db.php';
        $modeloUsuario = new Usuario($pdo);

        $id_usuario = $_SESSION['usuario_id'];
        $nombre = trim($_POST['nombre']);
        $apellidos = trim($_POST['apellidos']);
        $email = trim($_POST['email']);
        $password = !empty($_POST['password']) ? $_POST['password'] : null;
        
        $fotoNombre = null;
        
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $directorioDestino = __DIR__ . '/../../public/uploads/';
            
            if (!file_exists($directorioDestino)) {
                mkdir($directorioDestino, 0777, true);
            }

            $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $fotoNombre = 'perfil_' . $id_usuario . '_' . time() . '.' . $extension;
            
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $directorioDestino . $fotoNombre)) {
                // Actualizar sesion con la nueva foto para verla al instante
                $_SESSION['usuario_foto'] = $fotoNombre;
            }
        }

        if ($modeloUsuario->actualizarUsuario($id_usuario, $nombre, $apellidos, $email, $fotoNombre, $password)) {
            // Actualizamos la sesión
            $_SESSION['usuario_nombre'] = $nombre;
            $_SESSION['usuario_apellidos'] = $apellidos;
            
            header('Location: ' . BASE_URL . 'perfil?success=Datos actualizados correctamente');
            exit;
        } else {
            header('Location: ' . BASE_URL . 'perfil?error=No se pudo actualizar');
            exit;
        }
    }
}
?>