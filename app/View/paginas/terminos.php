<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $datos['titulo'] ?? 'Términos y Condiciones' ?> - DreamClass</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen font-sans">

    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center gap-3">
                    <a href="<?= BASE_URL ?>">
                    <img class="h-20 w-auto" src="<?= BASE_URL ?>assets/img/logoDreamClass.png" alt="DreamClass">
                    </a>
                </div>

                <div class="flex space-x-4">
                    <a href="<?= BASE_URL ?>login" class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition">
                        Iniciar Sesión
                    </a>
                    <a href="<?= BASE_URL ?>registro" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-full text-sm font-medium transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        Registrarse
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-grow max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full">
        <div class="bg-white p-8 md:p-12 rounded-3xl shadow-sm border border-gray-100">
            
            <div class="border-b border-gray-100 pb-6 mb-8">
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-2">Términos y Condiciones de Uso</h1>
                <p class="text-gray-500">Última actualización: <?= date('d/m/Y') ?></p>
            </div>
            
            <div class="space-y-8 text-gray-600 leading-relaxed">
                
                <section>
                    <h2 class="text-xl font-bold text-gray-800 mb-3">1. Introducción y Aceptación</h2>
                    <p>Bienvenido a <strong>DreamClass</strong>. Al registrarte, acceder o utilizar nuestra plataforma, aceptas estar sujeto a estos Términos y Condiciones. Si no estás de acuerdo con alguna parte de estos términos, no podrás utilizar nuestros servicios. DreamClass actúa como un intermediario tecnológico que conecta a profesionales de la educación Docentes con estudiantes.</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-gray-800 mb-3">2. Cuentas de Usuario y Roles</h2>
                    <p>Para utilizar DreamClass, debes registrarte y crear una cuenta, proporcionando información veraz, precisa y actualizada. Existen dos tipos de perfiles:</p>
                    <ul class="list-disc pl-6 mt-2 space-y-2">
                        <li><strong>Docentes:</strong> Usuarios registrados que ofrecen servicios de enseñanza mediante la creación de grupos mensuales.</li>
                        <li><strong>Alumnos:</strong> Usuarios registrados que exploran la oferta educativa y se suscriben a los grupos mensuales.</li>
                    </ul>
                    <p class="mt-2">Eres responsable de mantener la confidencialidad de tu contraseña y de todas las actividades que ocurran bajo tu cuenta.</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-gray-800 mb-3">3. Validación de Docentes</h2>
                    <p>Para garantizar la máxima calidad y seguridad en nuestra comunidad, DreamClass requiere que los Docentes suban un documento acreditativo (título o certificado) a través de su panel de control. Hasta que dicho documento no sea verificado por la administración y su estado cambie a "Verificado", no sabreis si el docente viene con dicha titulacion o no.</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-gray-800 mb-3">4. Suscripciones y Grupos Mensuales</h2>
                    <p>El modelo educativo de DreamClass se basa en <strong>suscripciones mensuales</strong>. Las reglas de este servicio son las siguientes:</p>
                    <ul class="list-disc pl-6 mt-2 space-y-2">
                        <li>Los Docentes publican ofertas de grupos indicando el nivel (Primaria, Secundaria, Bachillerato), el mes de impartición y el precio.</li>
                        <li>Un alumno solo puede estar inscrito en <strong>un nivel educativo por mes</strong> para asegurar un seguimiento pedagógico adecuado.</li>
                        <li>Las reservas y pagos se consideran compromisos vinculantes para el mes completo de clases.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-gray-800 mb-3">5. Código de Conducta (Chat, Tareas y Feedback)</h2>
                    <p>DreamClass provee herramientas de comunicación interna, asignación de tareas y un sistema de valoraciones (Feedback). Los usuarios se comprometen a:</p>
                    <ul class="list-disc pl-6 mt-2 space-y-2">
                        <li>Mantener un trato respetuoso y profesional en todo momento.</li>
                        <li>No utilizar el chat para enviar spam, publicidad o material inapropiado.</li>
                        <li>Dejar reseñas y calificaciones honestas y basadas exclusivamente en la experiencia académica. El feedback falso o malintencionado será motivo de suspensión de la cuenta.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-gray-800 mb-3">6. Limitación de Responsabilidad</h2>
                    <p>DreamClass proporciona la infraestructura tecnológica para conectar Docentes y Alumnos. No somos responsables directos de la calidad de las clases impartidas, ni de las disputas académicas que puedan surgir entre las partes. Cualquier reclamación económica deberá resolverse inicialmente entre el Docente y el Alumno.</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-gray-800 mb-3">7. Modificación de los Términos</h2>
                    <p>Nos reservamos el derecho de modificar estos Términos y Condiciones en cualquier momento. Las modificaciones entrarán en vigor en el momento de su publicación en la plataforma. Te notificaremos sobre cambios significativos a través del correo electrónico asociado a tu cuenta.</p>
                </section>

            </div>
        </div>
    </main>

    <footer class="bg-gray-800 text-white py-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="text-center md:text-left">
                <span class="text-xl font-bold tracking-tight">DreamClass</span>
                <p class="text-gray-400 text-sm mt-1">© <?= date('Y') ?> DreamClass. Todos los derechos reservados.</p>
            </div>
            <div class="flex space-x-6 text-sm">
                <a href="<?= BASE_URL ?>privacidad" class="text-gray-400 hover:text-white transition">Privacidad</a>
                <a href="<?= BASE_URL ?>terminos" class="text-white font-bold transition">Términos</a>
                <a href="<?= BASE_URL ?>contacto" class="text-gray-400 hover:text-white transition">Contacto</a>
            </div>
        </div>
    </footer>

</body>
</html>