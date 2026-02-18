<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $datos['titulo'] ?? 'Contacto' ?> - DreamClass</title>
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

    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 w-full">
        
        <?php if (isset($_GET['success'])): ?>
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-8 rounded-r-lg shadow-sm max-w-2xl mx-auto text-center font-bold">
                <?= htmlspecialchars($_GET['success']) ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
            
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 mb-6">Estamos aquí para ayudarte.</h1>
                <p class="text-lg text-gray-600 mb-10 leading-relaxed">
                    ¿Tienes dudas sobre cómo publicar un grupo, necesitas ayuda con tu suscripción o simplemente quieres decirnos hola? Rellena el formulario y nuestro equipo de soporte te responderá en menos de 24 horas.
                </p>

                <div class="space-y-8">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg">Soporte por Email</h3>
                            <p class="text-gray-500 mt-1">Envíanos un correo directamente y te atenderemos enseguida.</p>
                            <a href="mailto:soporte@dreamclass.com" class="text-blue-600 font-medium hover:underline mt-1 block">soporte_dreamclass@hotmail.com</a>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg">Llámanos</h3>
                            <p class="text-gray-500 mt-1">Lunes a Viernes, de 09:00 a 18:00 (CET).</p>
                            <p class="text-blue-600 font-medium mt-1 block">+34 643 66 96 29</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 md:p-10 rounded-3xl shadow-lg border border-gray-100">
                <form action="<?= BASE_URL ?>contacto?success=Mensaje%20enviado%20correctamente.%20Te%20responderemos%20pronto." method="POST" class="space-y-6">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nombre" class="block text-sm font-bold text-gray-700 mb-2">Nombre completo</label>
                            <input type="text" id="nombre" name="nombre" required placeholder="Ej: Jose Ignacio" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition bg-gray-50">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Correo electrónico</label>
                            <input type="email" id="email" name="email" required placeholder="tu@email.com" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition bg-gray-50">
                        </div>
                    </div>

                    <div>
                        <label for="asunto" class="block text-sm font-bold text-gray-700 mb-2">¿En qué podemos ayudarte?</label>
                        <select id="asunto" name="asunto" required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition bg-gray-50">
                            <option value="">Selecciona un asunto...</option>
                            <option value="duda_alumno">Soy alumno y tengo una duda</option>
                            <option value="duda_docente">Soy docente y quiero dar clases</option>
                            <option value="facturacion">Problemas con pagos o facturación</option>
                            <option value="tecnico">Soporte técnico / Error en la web</option>
                            <option value="otros">Otros asuntos</option>
                        </select>
                    </div>

                    <div>
                        <label for="mensaje" class="block text-sm font-bold text-gray-700 mb-2">Tu mensaje</label>
                        <textarea id="mensaje" name="mensaje" rows="5" required placeholder="Cuéntanos con detalle qué necesitas..." 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition bg-gray-50 resize-none"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-4 rounded-xl hover:bg-blue-700 transition shadow-md shadow-blue-200 flex justify-center items-center gap-2">
                        <span>Enviar mensaje</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                    
                    <p class="text-xs text-gray-400 text-center mt-4">
                        Al hacer clic en "Enviar mensaje", aceptas nuestra política de privacidad.
                    </p>
                </form>
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
                <a href="<?= BASE_URL ?>terminos" class="text-gray-400 hover:text-white transition">Términos</a>
                <a href="<?= BASE_URL ?>contacto" class="text-white font-bold transition">Contacto</a>
            </div>
        </div>
    </footer>

</body>
</html>