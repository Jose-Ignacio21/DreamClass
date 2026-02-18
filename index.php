<?php
// index.php es utilizado como controlador
// Todas las peticiones van a pasar por él para llevarlas a su controlador necesario

//Iniciamos la sesion
session_start();

// Configuramos la hora local española para que funcione en el servidor del hosting ya que al ser
// InfinityFree, coge la hora local del servidor
date_default_timezone_set("Europe/Madrid");

// Es la configuracion universal que se utiliza en todos los proyectos para ser trabajado en un hosting o en local
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
$baseUrl = rtrim($protocol . "://" . $host . $scriptDir, '/') . '/';

// BASE_URL es fundamental ya que es la que detecta si estamos en local o no
// Ademas a la hora de las carpetas siempre se va a recalcular solos
// Creamos una variable global para usarla en todo el proyecto
define('BASE_URL', $baseUrl);

// Carga automatica de clases ya que antes tenia que estar poniendo require_once 
// y a la hora de los archivos podia romperse 
spl_autoload_register(function ($class) {
    // Definimos el prefijo que va a llevar siempre los namespaces
    $prefix = 'App\\';
    
    // Directorio base donde están los archivos, es decir la carpeta app
    $base_dir = __DIR__ . '/app/';

    // Aqui vemos si la clase utiliza prefijo
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // Como no utiliza, nos movemos a la siguiente función registrada en el autoload
        return;
    }

    // Obtener el nombre relativo de la clase quitando el App
    $relative_class = substr($class, $len);

    // Reemplazamos el prefijo del namespace con el directorio base
    // Reemplazamos separadores de namespace con separadores de directorio 
    // Y por ultimo añadimos el .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // Si el archivo existe, cargarlo
    if (file_exists($file)) {
        require $file;
    }
});

// Esto es el enrutador universal donde vamos a parsear la url 
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$scriptName = $_SERVER['SCRIPT_NAME'];
$scriptDir = dirname($scriptName);

// Lo que esta haciendo aqui es quedarse con la parte de la url carpeta/crear por ejemplo,
// separa en un array esa parte con el explode y guarda la carpeta en la variable $accion
if ($scriptDir !== '/') {
    $path = str_replace($scriptDir, '', $requestUri);
} else {
    $path = $requestUri;
}
$parts = explode('/', trim($path, '/'));
$accion = $parts[0] ?? ''; // La primera parte de la url troceada

// Gestion de rutas
// Vista de Login
if ($accion === 'login') {
    require_once __DIR__ . '/login.php'; 
    
} elseif ($accion === 'procesar_login') {
    $controller = new \App\Controlador\AuthControlador();
    $controller->procesarLogin();

    // Vista de Registro
} elseif ($accion === 'registro') {
    require_once __DIR__ . '/registro.php';
    
} elseif ($accion === 'procesar_registro') {
    $controller = new \App\Controlador\AuthControlador();
    $controller->procesarRegistro();

} elseif ($accion === 'privacidad') {

    require_once __DIR__ . '/app/Controlador/PaginasControlador.php';
    $controller = new \App\Controlador\PaginasControlador();
    $controller->privacidad();

} elseif ($accion === 'terminos') {

    require_once __DIR__ . '/app/Controlador/PaginasControlador.php';
    $controller = new \App\Controlador\PaginasControlador();
    $controller->terminos();

} elseif ($accion === 'contacto') {

    require_once __DIR__ . '/app/Controlador/PaginasControlador.php';
    $controller = new \App\Controlador\PaginasControlador();
    $controller->contacto();

// Esta es la gestion de rutas pero para acceder necesitan antes que se haya logueado
// verificarSesion()

} elseif ($accion === 'clases') {
    verificarSesion();
    $controller = new \App\Controlador\ClaseControlador();
    
    if (isset($parts[1]) && $parts[1] === 'explorar') {
        $controller->explorar(); 
        
    } elseif (isset($parts[1]) && $parts[1] === 'reservar') {
        $controller->procesarReserva(); 

    } elseif (isset($parts[1]) && $parts[1] === 'alumnos') {
        $controller->verAlumnos($parts[2] ?? '');

    } elseif (isset($parts[1]) && $parts[1] === 'crear') {
        $controller->crear();
        
    } elseif (isset($parts[1]) && $parts[1] === 'procesar') {
        $controller->procesar();
        
    } else {
        $controller->index();
    }

} elseif ($accion === 'mensajes') {
    verificarSesion();
    $controller = new \App\Controlador\ChatControlador();
    
    if (isset($parts[1]) && $parts[1] === 'ver') {
        $controller->ver($parts[2] ?? '');

    } elseif (isset($parts[1]) && $parts[1] === 'enviar') {
        $controller->enviar();

    } else {
        $controller->index();
    }

} elseif ($accion === 'recursos') {
    verificarSesion();
    require_once __DIR__ . '/app/Controlador/RecursoControlador.php';
    $controller = new \App\Controlador\RecursoControlador();
    
    if (isset($parts[1]) && $parts[1] === 'subir') {
        $controller->subir();
    } elseif (isset($parts[1]) && $parts[1] === 'eliminar') {
        $controller->eliminar($parts[2] ?? '');
    } else {
        $controller->index();
    }
    
}elseif ($accion === 'historial') {
    verificarSesion();
    require_once __DIR__ . '/app/Controlador/HistorialControlador.php';
    $controller = new \App\Controlador\HistorialControlador();
    
    if (isset($parts[1]) && $parts[1] === 'finalizar') {
        $controller->finalizarClase($parts[2] ?? '');
    } else {
        $controller->index();
    }
} elseif ($accion === 'tareas') {
    verificarSesion();
    $controller = new \App\Controlador\TareaControlador();
    if (isset($parts[1]) && $parts[1] === 'crear') {
        $controller->crear();
    } else {
        $controller->index();
    }

} elseif ($accion === 'feedback') {
    verificarSesion();
    $controller = new \App\Controlador\FeedbackControlador();
    
    if (isset($parts[1]) && $parts[1] === 'crear') {
        $controller->crear();

    } elseif (isset($parts[1]) && $parts[1] === 'procesar') {
        $controller->procesar();

    } else {
        $controller->index();
    }

// Gestion de los roles

} elseif ($accion === 'docente') {
    verificarSesion('docente');
    $controller = new \App\Controlador\DocenteControlador();
    
    $subaccion = $parts[1] ?? '';
    
    
    if ($subaccion === 'estadisticas') {
        $controller->estadisticas();
    } elseif ($subaccion === 'feedback') {
        $controller->feedback();
    } elseif ($subaccion === 'validacion') {
        $controller->validacion();
    } elseif ($subaccion === 'procesar_validacion') {
        $controller->procesarValidacion();

    } else {
        $controller->dashboard();
    }

} elseif ($accion === 'alumno') {
    verificarSesion('alumno');
    $controller = new \App\Controlador\AlumnoControlador();
    $controller->dashboard();

} elseif ($accion === 'perfil') {
    verificarSesion(); 
    
    require_once __DIR__ . '/app/Controlador/PerfilControlador.php';
    $controller = new \App\Controlador\PerfilControlador();

    if (isset($parts[1]) && $parts[1] === 'actualizar') {
        $controller->actualizar();
    } else {
        $controller->mostrar();
    }

//Cerramos sesion
//Redirigimos a la landing page
} elseif ($accion === 'logout') {
    session_destroy();
    header('Location: ' . BASE_URL . '?mensaje=Has cerrado sesión correctamente.');
    exit;

} elseif ($accion === '' || $accion === 'index.php') {
    $controller = new \App\Controlador\HomeControlador();
    $controller->index();

} else {
    // Pagina de error 404 si hubiera algun error
    http_response_code(404);
    echo "<h1>Error 404</h1><p>Página no encontrada.</p>";
}

// Funcion para verificar la sesion tanto si es usuario como docente
// Si os fijais en los parentesis hay la variable booleana null y esto significa
// que si no se añade parametros la funcion lo añade como null pero si se añade parametro
// funciona con el parametro

// Esta funcion se utiliza de dos formas
function verificarSesion($rolRequerido = null) {
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: ' . BASE_URL . 'login');
        exit;
    }
    if ($rolRequerido && $_SESSION['usuario_rol'] !== $rolRequerido) {
        header('Location: ' . BASE_URL . 'login?error=Acceso denegado');
        exit;
    }
}
?>