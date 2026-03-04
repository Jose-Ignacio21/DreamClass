<?php
namespace App\Controlador;

class AuthControlador {
    
    public function procesarLogin() {
        // Es utilizado universalmente, ya que si el usuario intenta acceder mediante manualmente poniendo la url
        // se le va a redirigir al formulario del login
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }

        require_once __DIR__ . '/../../includes/db.php';

        // Extraemos el email y la contraseña
        // trim es para que no haya espacios
        $email = trim($_POST["email"] ?? '');
        $password = $_POST["password"] ?? '';

        if (empty($email) || empty($password)) {
            // Verificacion a la hora de loguearse que no se deje nada en blanco
            header('Location: ' . BASE_URL . 'login?error=Completa todos los campos');
            exit;
        }

        // SQL para buscar usuario
        $stmt = $pdo->prepare("
            SELECT u.id_usuario, u.nombre, u.apellidos, u.email, u.contrasenia, u.rol, u.foto_perfil, d.estado_validacion 
            FROM usuario u 
            LEFT JOIN docente d ON u.id_usuario = d.id_docente 
            WHERE u.email = ?"
            );
        $stmt->execute([$email]);
        $usuario = $stmt->fetch();

        if (!$usuario || !password_verify($password, $usuario["contrasenia"])) {
            // Verificacion si se han introducido los datos incorrectos
            header('Location: ' . BASE_URL . 'login?error=Email o contraseña incorrectos');
            exit;
        }
        // Se inicia una sesion
        // Si ya esta todo correcto, se pasa al inicio de sesion guardando las variables para utilizarlas posteriormente
        session_start();
        $_SESSION["usuario_id"] = $usuario["id_usuario"];
        $_SESSION["usuario_nombre"] = $usuario["nombre"];
        $_SESSION["usuario_apellidos"] = $usuario["apellidos"]; 
        $_SESSION["usuario_foto"] = $usuario["foto_perfil"];    
        $_SESSION["usuario_rol"] = $usuario["rol"];
        $_SESSION["estado_validacion"] = $usuario["estado_validacion"] ?? null;

        // Redirigir según rol
        if ($usuario['rol'] === 'admin') {
            header('Location: ' . BASE_URL . 'admin');
        } elseif ($usuario['rol'] === 'docente') {
            header('Location: ' . BASE_URL . 'docente');
        } else {
            header('Location: ' . BASE_URL . 'alumno');
        }
        exit;
    }

    public function procesarRegistro() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'registro');
            exit;
        }

        require_once __DIR__ . '/../../includes/db.php';
        
        // require_once __DIR__ . '/../../includes/email.php';

        // Utilizamos ?? ya que si pasa algo, se asigna como valor '' vacio
        $nombre = trim($_POST["nombre"] ?? '');
        $email = trim($_POST["email"] ?? '');
        $rol = $_POST["rol"] ?? '';
        $password = $_POST["password"] ?? '';

        $password_confirm = $_POST['password_confirm'] ?? '';

        if ($password !== $password_confirm) {
            header('Location: ' . BASE_URL . 'registro?error=Las contraseñas no coinciden&nombre=' . urlencode($nombre) . '&email=' . urlencode($email) . '&rol=' . urlencode($rol));
            exit;
        }

        if (!preg_match('/(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}/', $password)) {
            header('Location: ' . BASE_URL . 'registro?error=La contraseña no cumple con los requisitos de seguridad&nombre=' . urlencode($nombre) . '&email=' . urlencode($email) . '&rol=' . urlencode($rol));
            exit;
        }
        // Mas validaciones
        if (empty($nombre) || empty($email) || empty($rol) || empty($password)) {
            header('Location: ' . BASE_URL . 'registro?error=Faltan datos obligatorios&nombre=' . urlencode($nombre) . '&email=' . urlencode($email) . '&rol=' . urlencode($rol));
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header('Location: ' . BASE_URL . 'registro?error=Email inválido&nombre=' . urlencode($nombre) . '&email=' . urlencode($email) . '&rol=' . urlencode($rol));
            exit;
        }

        if ($rol !== 'docente' && $rol !== 'alumno') {
            header('Location: ' . BASE_URL . 'registro?error=Rol no válido&nombre=' . urlencode($nombre) . '&email=' . urlencode($email) . '&rol=' . urlencode($rol));
            exit;
        }

        if (strlen($password) < 8) {
            header('Location: ' . BASE_URL . 'registro?error=La contraseña debe tener al menos 8 caracteres&nombre=' . urlencode($nombre) . '&email=' . urlencode($email) . '&rol=' . urlencode($rol));
            exit;
        }

        // Verificar si el email ya existe
        // ? lo utilizamos para separar los datos de las consultas y sea menos peligroso
        $stmt = $pdo->prepare("SELECT id_usuario FROM usuario WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            header('Location: ' . BASE_URL . 'registro?error=Este email ya está registrado&nombre=' . urlencode($nombre) . '&email=' . urlencode($email) . '&rol=' . urlencode($rol));
            exit;
        }

        // Registro de usuario
        // Hasheamos la contraseña
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        // Lo mismo sentencias SQL separadas de los datos
        $stmt = $pdo->prepare("INSERT INTO usuario (nombre, email, contrasenia, rol) VALUES (?, ?, ?, ?)");
        try {
            $stmt->execute([$nombre, $email, $hashedPassword, $rol]);
            $id_usuario = $pdo->lastInsertId();

            // Creamos el perfil
            if ($rol === 'docente') {
                $stmt = $pdo->prepare("INSERT INTO docente (id_docente) VALUES (?)");
            } else {
                $stmt = $pdo->prepare("INSERT INTO alumno (id_alumno) VALUES (?)");
            }
            $stmt->execute([$id_usuario]);

            require_once __DIR__ ."/../../includes/email.php";

            $asunto = " ¡ Bienvenido a DreamClass, $nombre! ";

            $mensajeHTML = "
            <div style='font-family: Helvetica, Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 30px; border: 1px solid #e5e7eb; border-radius: 12px; background-color: #ffffff;'>
                
                <h2 style='color: #2563eb; text-align: center; font-size: 24px;'>¡Hola, $nombre!</h2>
                
                <p style='color: #4b5563; font-size: 16px; line-height: 1.6; text-align: center;'>
                    Estamos súper emocionados de darte la bienvenida a <strong>DreamClass</strong>. Has dado el primer paso para transformar tu experiencia educativa.
                </p>
                
                <div style='background-color: #f3f4f6; padding: 20px; border-radius: 8px; margin: 25px 0; text-align: center;'>
                    <p style='color: #374151; font-size: 15px; margin: 0;'>
                        Tu cuenta ha sido creada exitosamente con el perfil de:<br>
                        <strong style='font-size: 18px; color: #1f2937; text-transform: uppercase; display: block; margin-top: 10px;'> $rol</strong>
                    </p>
                </div>
                
                <div style='text-align: center; margin: 35px 0;'>
                    <a href='" . BASE_URL . "login' style='background-color: #2563eb; color: #ffffff; padding: 14px 28px; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 16px; display: inline-block;'>
                        Entrar a mi cuenta
                    </a>
                </div>
                
                <hr style='border: none; border-top: 1px solid #e5e7eb; margin: 30px 0;'>
                
                <p style='color: #9ca3af; font-size: 12px; text-align: center; margin: 0;'>
                    Si tienes alguna duda, responde a este correo o visita nuestra sección de contacto.<br><br>
                    © " . date('Y') . " DreamClass. Todos los derechos reservados.
                </p>
            </div>
            ";

            enviarEmailBrevo($email, $nombre, $asunto, $mensajeHTML);

            header('Location: ' . BASE_URL . 'registro?success=¡Registro completado! Ahora inicia sesión.');
            exit;

        } catch (\Exception $e) {
            // Si hay algun error
            error_log("Error en registro: " . $e->getMessage());
            header('Location: ' . BASE_URL . 'registro?error=Error al registrar. Inténtalo más tarde.&nombre=' . urlencode($nombre) . '&email=' . urlencode($email) . '&rol=' . urlencode($rol));
            exit;
        }
    }

    public function recuperarPassword() {
        require_once __DIR__ . '/../../recuperar.php'; 
    }

    // El proceso del email y de la contraseña se hace en esta funcion
    public function procesarRecuperacion() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'recuperar');
            exit;
        }

        require_once __DIR__ . '/../../includes/db.php';
        require_once __DIR__ . '/../../includes/email.php';

        $email = trim($_POST['email'] ?? '');

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header('Location: ' . BASE_URL . 'recuperar?error=Por favor, introduce un email válido.');
            exit;
        }

        $stmt = $pdo->prepare("SELECT id_usuario, nombre FROM usuario WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch();

        if ($usuario) {
            $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $nueva_password = substr(str_shuffle($caracteres), 0, 8);

            $hashedPassword = password_hash($nueva_password, PASSWORD_DEFAULT);

            $stmtUpdate = $pdo->prepare("UPDATE usuario SET contrasenia = ? WHERE id_usuario = ?");
            $stmtUpdate->execute([$hashedPassword, $usuario['id_usuario']]);

            $nombre = $usuario['nombre'];
            $asunto = "Recuperación de contraseña - DreamClass";
            $mensajeHTML = "
            <div style='font-family: Helvetica, Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 30px; border: 1px solid #e5e7eb; border-radius: 12px; background-color: #ffffff;'>
                <h2 style='color: #2563eb; text-align: center; font-size: 24px;'>Recuperación de Acceso</h2>
                <p style='color: #4b5563; font-size: 16px; line-height: 1.6;'>Hola, <strong>$nombre</strong>.</p>
                <p style='color: #4b5563; font-size: 16px; line-height: 1.6;'>Hemos recibido una solicitud para restablecer tu contraseña. Hemos generado una contraseña temporal segura para ti:</p>
                
                <div style='background-color: #f3f4f6; padding: 20px; text-align: center; font-size: 24px; font-weight: bold; letter-spacing: 3px; border-radius: 8px; margin: 25px 0; color: #1f2937;'>
                    $nueva_password
                </div>

                <h3 style='color: #374151;'>Tus próximos pasos:</h3>
                <ol style='color: #4b5563; font-size: 15px; line-height: 1.8;'>
                    <li>Copia la contraseña temporal que aparece arriba.</li>
                    <li>Inicia sesión en DreamClass usando esta contraseña.</li>
                    <li>Una vez dentro, dirígete al menú de <strong>Mi Perfil</strong> (arriba a la derecha).</li>
                    <li>Cambia esta contraseña por una que puedas recordar fácilmente.</li>
                </ol>

                <div style='text-align: center; margin: 35px 0;'>
                    <a href='" . BASE_URL . "login' style='background-color: #2563eb; color: #ffffff; padding: 14px 28px; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 16px; display: inline-block;'>
                        Ir a Iniciar Sesión
                    </a>
                </div>
                
                <hr style='border: none; border-top: 1px solid #e5e7eb; margin: 30px 0;'>
                <p style='color: #9ca3af; font-size: 12px; text-align: center;'>Si no solicitaste este cambio, contacta con nosotros de inmediato.</p>
            </div>
            ";

            try {
                enviarEmailBrevo($email, $nombre, $asunto, $mensajeHTML);
            } catch (\Exception $e) {
                error_log("Error al enviar email de recuperación: " . $e->getMessage());
            }
        }

        header('Location: ' . BASE_URL . 'login?success=Si tu email está registrado, recibirás las instrucciones en breve.');
        exit;
    }
}
?>