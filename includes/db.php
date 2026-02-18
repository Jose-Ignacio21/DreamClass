<?php
// En la funcion getPDO() lo que hacemos es separar dos entornos, el local y el del hosting
function getPDO() {
    $db_local = [
        'host' => 'localhost',
        'name' => 'dreamclass',
        'user' => 'root',
        'pass' => ''
    ];

    $db_live = [
        'host' => 'sql313.infinityfree.com',      
        'name' => 'if0_41047472_dreamclass',   
        'user' => 'if0_41047472',   
        'pass' => 'jDaEYPvnLsepid' 
    ];

    // $_SERVER['REMOTE_ADDR'] lo que hace es preguntar al servidor quien esta pidiendo la pagina
    // ['127.0.0.1', '::1'] son las IPs del servidor local
    $is_local = in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']);

    // Aqui recoge si es local, pues cogemos la configuracion local y si no la otra
    $conf = $is_local ? $db_local : $db_live;

    static $pdo = null;
    if ($pdo === null) {
        try {
            //Define la direccion completa del servidor 
            $dsn = "mysql:host={$conf['host']};dbname={$conf['name']};charset=utf8mb4";
            //Creamos una instancia de la clase PDO, con la direccion, usuario y contraseña
            $pdo = new PDO($dsn, $conf['user'], $conf['pass']);
            // PDO se comporta de una manera u otra dependiendo si hay error 
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Nos devuelve los datos en un array asociativo
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            // Sincronizamos la hora de MySQL con la de PHP
            $pdo->exec("SET time_zone = '" . date('P') . "'");
        } catch (PDOException $e) {
            // Aqui si hay errores mostramos los errores tecnicos en local
            // y si es en el hosting mostramos ese mensaje
            if ($is_local) {
                die("Error de conexión: " . $e->getMessage());
            } else {
                die("Error de conexión a la base de datos. Inténtalo más tarde.");
            }
        }
    }
    return $pdo;
}

$pdo = getPDO();
?>