<?php
// Utilizamos el namespace para evitar colisiones llamando a los demas controladores
namespace App\Controlador;

// Creamos la clase
class AlumnoControlador {
    
    // Creamos la funcion dashboard
    public function dashboard() {
        // Comprueba si hay una sesion abierta, si no la hay la crea
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        
        // Incluimos estos dos archivos
        // Utilizamos require_once para evitar en caso de que no existiera el archivo, se detuviera
        // __DIR__ lo utilizamos para que busque donde le indicamos
        require_once __DIR__ . '/../../includes/db.php';
        require_once __DIR__ . '/../Modelo/Alumno.php'; 

        // Extrae la sesion del alumno
        $id_alumno = $_SESSION['usuario_id'];
        // Instanciamos el Alumno y le pasamos la conexion
        $modeloAlumno = new \App\Modelo\Alumno($pdo);

        // Obtenemos la proxima clase que tendriamos
        $proximaClase = $modeloAlumno->obtenerProximaClase($id_alumno);

        // Y obtenemos las tareas que nos han definido para hoy
        $progreso = $modeloAlumno->obtenerProgresoHoy($id_alumno);
        
        // Creamos un array para enviarselo para que lo muestre en pantalla
        $datos = [
            'titulo' => 'Panel Alumno',
            'usuario' => $_SESSION,
            'proxima_clase' => $proximaClase,
            'progreso' => $progreso          
        ];

        // Necesitamos este archivo para pasarle $datos
        require_once __DIR__ . '/../View/alumno/dashboard.php';
    }
}
?>