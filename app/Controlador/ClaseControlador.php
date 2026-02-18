<?php
namespace App\Controlador;

class ClaseControlador {

    public function index() {
        require_once __DIR__ . '/../../includes/db.php';
        require_once __DIR__ . '/../Modelo/Grupo.php';
        
        $grupoModel = new \App\Modelo\Grupo($pdo);

        if ($_SESSION['usuario_rol'] === 'docente') {
            // El docente ve los grupos que ha creado
            $grupos = $grupoModel->obtenerGruposPorDocente($_SESSION['usuario_id']);
            require_once __DIR__ . '/../View/clases/index_docente.php';
        } else {
            // El alumno va a ver los grupos a los que esta inscrito
            $grupos = $grupoModel->obtenerGruposPorAlumno($_SESSION['usuario_id']);
            require_once __DIR__ . '/../View/clases/index_alumno.php';
        }
    }

    public function crear() {
        if ($_SESSION['usuario_rol'] !== 'docente') {
            header('Location: ' . BASE_URL . 'clases?error=Acceso denegado');
            exit;
        }
        require_once __DIR__ . '/../View/clases/crear.php';
    }
    
    // Procesa el formulario anterior y lo guarda en la base de datos
    public function procesar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || $_SESSION['usuario_rol'] !== 'docente') {
            header('Location: ' . BASE_URL . 'clases');
            exit;
        }

        require_once __DIR__ . '/../../includes/db.php';
        require_once __DIR__ . '/../Modelo/Grupo.php';
        
        $grupoModel = new \App\Modelo\Grupo($pdo);

        // Recogemos los datos del formulario
        $nivel = $_POST['nivel'] ?? '';
        $precio = $_POST['precio'] ?? 0;
        
        // El formulario que lo tenemos tipo para meses y años envía yyyy-mm y si le añadimos el -01 la base de datos la acepta como date.
        $mes_anio = ($_POST['mes_anio'] ?? '') . '-01'; 

        try {
            $grupoModel->crear($_SESSION['usuario_id'], $nivel, $mes_anio, $precio);
            header('Location: ' . BASE_URL . 'clases?success=Grupo mensual publicado con éxito');
        } catch (\Exception $e) {
            header('Location: ' . BASE_URL . 'clases/crear?error=' . urlencode($e->getMessage()));
        }
    }

    // Se trata de que al alumnado le va a saltar todas las clases de todos los profesores que han creado
    // y van a poder ver cual es la que le viene mejor
    public function explorar() {
        if ($_SESSION['usuario_rol'] !== 'alumno') {
            header('Location: ' . BASE_URL . 'clases?error=Acceso denegado');
            exit;
        }

        require_once __DIR__ . '/../../includes/db.php';
        require_once __DIR__ . '/../Modelo/Grupo.php';
        
        $grupoModel = new \App\Modelo\Grupo($pdo);

        // Aqui vamos a recoger el mes actual para que no nos salgan clases antiguas 
        $mes_actual = date('Y-m-01');
        $grupos = $grupoModel->obtenerGruposDisponibles($mes_actual);

        require_once __DIR__ . '/../View/clases/explorar.php';
    }

    public function procesarReserva() {
        if ($_SESSION['usuario_rol'] !== 'alumno') {
            header('Location: ' . BASE_URL . 'clases?error=Acceso denegado');
            exit;
        }

        require_once __DIR__ . '/../../includes/db.php';
        require_once __DIR__ . '/../Modelo/Grupo.php';
        
        $grupoModel = new \App\Modelo\Grupo($pdo);

        // Recogemos el ID del grupo al que se quiere apuntar
        $id_grupo = $_POST['id_grupo'] ?? ($_GET['id_grupo'] ?? null);

        if (!$id_grupo) {
            header('Location: ' . BASE_URL . 'clases/explorar?error=No se especificó la clase');
            exit;
        }

        try {
            $grupoModel->inscribir($id_grupo, $_SESSION['usuario_id']);

            require_once __DIR__ . '/../../includes/email.php';

            // Recogemos el nivel, el mes, nombre del docente y el email del docente
            // Juntamos las tablas

            $stmtGrupo = $pdo->prepare("
                SELECT g.nivel, g.mes_anio, u_docente.nombre as docente_nombre, u_docente.email as docente_email 
                FROM grupo g 
                JOIN usuario u_docente ON g.id_docente = u_docente.id_usuario 
                WHERE g.id_grupo = ?
            ");
            $stmtGrupo->execute([$id_grupo]);
            $infoGrupo = $stmtGrupo->fetch();

            
            $stmtAlumno = $pdo->prepare("SELECT email FROM usuario WHERE id_usuario = ?");
            $stmtAlumno->execute([$_SESSION['usuario_id']]);
            $infoAlumno = $stmtAlumno->fetch();

            if ($infoGrupo && $infoAlumno) {

                $mes_bonito = date('m/Y', strtotime($infoGrupo['mes_anio']));
                $nombre_alumno = $_SESSION['usuario_nombre'];

                $asuntoAlumno = "¡Inscripción Confirmada! - Nivel: " . $infoGrupo['nivel'];
                $htmlAlumno = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #e2e8f0; border-radius: 10px;'>
                    <h2 style='color: #2563eb; text-align: center;'>¡Todo listo, $nombre_alumno! </h2>
                    <p style='color: #475569; font-size: 16px; text-align: center;'>Te has inscrito correctamente en tu nueva clase.</p>
                    <div style='background-color: #f1f5f9; padding: 15px; border-radius: 8px; margin: 20px 0;'>
                        <p style='margin: 5px 0; color: #1e293b;'><strong>Nivel:</strong> " . $infoGrupo['nivel'] . "</p>
                        <p style='margin: 5px 0; color: #1e293b;'><strong>Mes:</strong> $mes_bonito</p>
                        <p style='margin: 5px 0; color: #1e293b;'><strong>Profesor:</strong> " . $infoGrupo['docente_nombre'] . "</p>
                    </div>
                    <p style='color: #64748b; font-size: 14px; text-align: center;'>Ya puedes entrar al sistema para ver el chat de la clase o comunicarte con el profesor.</p>
                </div>";
                
                enviarEmailBrevo($infoAlumno['email'], $nombre_alumno, $asuntoAlumno, $htmlAlumno);

                $asuntoDocente = "¡Nuevo alumno inscrito! - " . $infoGrupo['nivel'];
                $htmlDocente = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #e2e8f0; border-radius: 10px;'>
                    <h2 style='color: #16a34a; text-align: center;'>¡Buenas noticias, " . $infoGrupo['docente_nombre'] . "!</h2>
                    <p style='color: #475569; font-size: 16px; text-align: center;'>Un nuevo alumno acaba de apuntarse a tu grupo.</p>
                    <div style='background-color: #f0fdf4; border-left: 4px solid #16a34a; padding: 15px; margin: 20px 0;'>
                        <p style='margin: 5px 0; color: #1e293b;'><strong>Alumno:</strong> $nombre_alumno</p>
                        <p style='margin: 5px 0; color: #1e293b;'><strong>Grupo matriculado:</strong> " . $infoGrupo['nivel'] . " ($mes_bonito)</p>
                    </div>
                    <p style='color: #64748b; font-size: 14px; text-align: center;'>Revisa tu panel para ponerte en contacto y enviarle la primera tarea.</p>
                </div>";

                enviarEmailBrevo($infoGrupo['docente_email'], $infoGrupo['docente_nombre'], $asuntoDocente, $htmlDocente);
            }

            header('Location: ' . BASE_URL . 'clases/explorar?success=¡Inscripción confirmada! Ya estás en la clase.');
        } catch (\Exception $e) {
            header('Location: ' . BASE_URL . 'clases/explorar?error=' . urlencode($e->getMessage()));
        }
    }

    // Vamos a ver la lista de los grupos
    public function verAlumnos($id_grupo) {
        if ($_SESSION['usuario_rol'] !== 'docente') {
            header('Location: ' . BASE_URL . 'clases?error=Acceso denegado');
            exit;
        }

        require_once __DIR__ . '/../../includes/db.php';
        require_once __DIR__ . '/../Modelo/Grupo.php';
        
        $grupoModel = new \App\Modelo\Grupo($pdo);
        
        $alumnos = $grupoModel->obtenerAlumnosPorGrupo($id_grupo, $_SESSION['usuario_id']);
        
        require_once __DIR__ . '/../View/clases/ver_alumnos.php';
    }
}
?>