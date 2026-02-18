<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($datos['titulo']) ?></title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>assets/img/logoDreamClass.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .fade-in-up { animation: fadeInUp 0.8s ease-out; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center gap-3">
                    <img class="h-20 w-auto" src="<?= BASE_URL ?>assets/img/logoDreamClass.png" alt="DreamClass">
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

    <section class="relative bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32 pt-20 px-4 sm:px-6 lg:px-8 fade-in-up">
                <main class="mt-10 mx-auto max-w-7xl sm:mt-12 md:mt-16 lg:mt-20 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                            <span class="block xl:inline">La mejor forma de gestionar</span>
                            <span class="block text-blue-600 xl:inline">tus clases particulares</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Conecta alumnos y docentes en un entorno digital diseñado para el aprendizaje. Horarios, tareas, chat y feedback en un solo lugar.
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                <a href="<?= BASE_URL ?>registro" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 md:py-4 md:text-lg md:px-10 transition transform hover:scale-105">
                                    Empieza ahora
                                </a>
                            </div>
                            <div class="mt-3 sm:mt-0 sm:ml-3">
                                <a href="#como-funciona" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 md:py-4 md:text-lg md:px-10 transition">
                                    Saber más
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 bg-gray-100 flex items-center justify-center">
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full opacity-90" src="<?= BASE_URL ?>assets/img/estudiantes.png" alt="Estudiantes estudiando">
        </div>
    </section>

    <section class="bg-blue-600 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-3 text-center">
                <div class="bg-blue-700 rounded-lg p-6 transform hover:scale-105 transition">
                    <p class="text-4xl font-extrabold text-white">+1,200</p>
                    <p class="mt-1 text-lg font-medium text-blue-200">Alumnos Activos</p>
                </div>
                <div class="bg-blue-700 rounded-lg p-6 transform hover:scale-105 transition">
                    <p class="text-4xl font-extrabold text-white">+450</p>
                    <p class="mt-1 text-lg font-medium text-blue-200">Docentes Expertos</p>
                </div>
                <div class="bg-blue-700 rounded-lg p-6 transform hover:scale-105 transition">
                    <p class="text-4xl font-extrabold text-white">98%</p>
                    <p class="mt-1 text-lg font-medium text-blue-200">Feedback Positivo</p>
                </div>
            </div>
        </div>
    </section>

    <section id="como-funciona" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-base text-blue-600 font-semibold tracking-wide uppercase">Comunidad</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Lo que dicen nuestros usuarios
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 flex">★★★★★</div>
                    </div>
                    <p class="text-gray-600 italic mb-4">"DreamClass ha transformado la manera en que organizo mis clases de matemáticas. El chat integrado es súper útil para dudas rápidas."</p>
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">L</div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Laura M.</p>
                            <p class="text-sm text-gray-500">Docente</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="text-yellow-400 flex mb-4">★★★★★</div>
                    <p class="text-gray-600 italic mb-4">"Poder ver mis tareas pendientes y recibir feedback de mi profesor al instante me ayuda muchísimo a mejorar."</p>
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold">C</div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Carlos R.</p>
                            <p class="text-sm text-gray-500">Alumno</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="text-yellow-400 flex mb-4">★★★★☆</div>
                    <p class="text-gray-600 italic mb-4">"La interfaz es muy limpia y fácil de usar. Gestionar mis horarios nunca había sido tan sencillo."</p>
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 font-bold">S</div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Sofía P.</p>
                            <p class="text-sm text-gray-500">Docente</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <div>
                <span class="text-xl font-bold">DreamClass</span>
                <p class="text-gray-400 text-sm">© 2026 DreamClass. Todos los derechos reservados.</p>
            </div>
            <div class="flex space-x-6">
                <a href="<?= BASE_URL ?>privacidad" class="text-gray-400 hover:text-white transition">Privacidad</a>
                <a href="<?= BASE_URL ?>terminos" class="text-gray-400 hover:text-white transition">Términos</a>
                <a href="<?= BASE_URL ?>contacto" class="text-gray-400 hover:text-white transition">Contacto</a>
            </div>
        </div>
    </footer>

</body>
</html>