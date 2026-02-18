<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $datos['titulo'] ?? 'Política de Privacidad' ?> - DreamClass</title>
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
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-2">Política de Privacidad</h1>
                <p class="text-gray-500">Última actualización: <?= date('d/m/Y') ?></p>
            </div>
            
            <div class="space-y-8 text-gray-600 leading-relaxed">
                
                <section>
                    <h2 class="text-xl font-bold text-gray-800 mb-3">1. Compromiso con tu privacidad</h2>
                    <p>En <strong>DreamClass</strong>, nos tomamos muy en serio la privacidad y seguridad de los datos de nuestra comunidad de docentes y alumnos. Esta política explica qué información recopilamos, cómo la usamos y qué derechos tienes sobre ella, en cumplimiento con el Reglamento General de Protección de Datos (RGPD).</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-gray-800 mb-3">2. Información que recopilamos</h2>
                    <p>Para poder ofrecerte nuestros servicios educativos, necesitamos recopilar ciertos datos en función de tu rol en la plataforma:</p>
                    <ul class="list-disc pl-6 mt-2 space-y-2">
                        <li><strong>Datos de Registro:</strong> Nombre, apellidos y dirección de correo electrónico, necesarios para crear tu cuenta y comunicarnos contigo.</li>
                        <li><strong>Datos de Docentes:</strong> Información sobre niveles educativos que impartes, tarifas de tus grupos y documentos acreditativos (títulos) para validar tu perfil profesional.</li>
                        <li><strong>Datos Académicos:</strong> Historial de grupos en los que estás inscrito, tareas asignadas, estado de completado y las valoraciones o feedback que dejas a tus profesores.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-gray-800 mb-3">3. Cómo utilizamos tu información</h2>
                    <p>Utilizamos tus datos exclusivamente para el correcto funcionamiento de la plataforma:</p>
                    <ul class="list-disc pl-6 mt-2 space-y-2">
                        <li>Gestionar tus inscripciones y organizar los grupos mensuales.</li>
                        <li>Facilitar la comunicación interna mediante el sistema de mensajería entre alumno y docente.</li>
                        <li>Verificar la identidad y las credenciales de los profesores para mantener una comunidad segura.</li>
                        <li>Mostrar estadísticas de rendimiento en tu panel de control.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-gray-800 mb-3">4. Seguridad y retención de datos</h2>
                    <p>Aplicamos medidas técnicas y organizativas rigurosas para proteger tus datos. <strong>Tus contraseñas son encriptadas</strong> mediante algoritmos de hash seguros antes de guardarse en nuestra base de datos, lo que significa que ni siquiera nuestro equipo puede leerlas. Mantenemos tu información solo durante el tiempo que tu cuenta esté activa o según sea necesario para cumplir con obligaciones legales.</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-gray-800 mb-3">5. Tus derechos (Derechos ARCO)</h2>
                    <p>Como usuario de DreamClass, eres dueño de tus datos. Tienes derecho a:</p>
                    <ul class="list-disc pl-6 mt-2 space-y-2">
                        <li><strong>Acceder</strong> a la información que tenemos sobre ti.</li>
                        <li><strong>Rectificar</strong> datos inexactos o incompletos desde tu perfil.</li>
                        <li><strong>Cancelar o eliminar</strong> tu cuenta y tus datos personales de nuestros servidores en cualquier momento.</li>
                        <li><strong>Oponerte</strong> al tratamiento de tus datos para ciertos fines.</li>
                    </ul>
                    <p class="mt-2">Para ejercer estos derechos, simplemente escríbenos a través de nuestra <a href="<?= BASE_URL ?>contacto" class="text-blue-600 hover:underline">página de contacto</a>.</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-gray-800 mb-3">6. Compartición de datos con terceros</h2>
                    <p>En DreamClass <strong>no vendemos, alquilamos ni comercializamos</strong> tus datos personales a terceros. Tu información solo es visible para las partes estrictamente necesarias (ej. un profesor puede ver el nombre y email del alumno que se ha inscrito en su grupo para poder comunicarse con él).</p>
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
                <a href="<?= BASE_URL ?>privacidad" class="text-white font-bold transition">Privacidad</a>
                <a href="<?= BASE_URL ?>terminos" class="text-gray-400 hover:text-white transition">Términos</a>
                <a href="<?= BASE_URL ?>contacto" class="text-gray-400 hover:text-white transition">Contacto</a>
            </div>
        </div>
    </footer>

</body>
</html>