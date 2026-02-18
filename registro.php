<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro || DreamClass</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen py-10">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Crear cuenta</h2>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r shadow-sm">
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['success'])): ?>
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r shadow-sm">
                <?= htmlspecialchars($_GET['success']) ?>
            </div>
        <?php endif; ?>

        <form action="procesar_registro" method="POST" class="space-y-5" id="formRegistro">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                <input type="text" name="nombre" required 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                       value="<?= htmlspecialchars($_GET['nombre'] ?? '') ?>">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" required 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                       value="<?= htmlspecialchars($_GET['email'] ?? '') ?>">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Rol</label>
                <select name="rol" required 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition bg-white">
                    <option value="">-- Selecciona --</option>
                    <option value="docente" <?= (($_GET['rol'] ?? '') === 'docente') ? 'selected' : '' ?>>Docente</option>
                    <option value="alumno" <?= (($_GET['rol'] ?? '') === 'alumno') ? 'selected' : '' ?>>Alumno</option>
                </select>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                <input type="password" id="password" name="password" required 
                       pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}" 
                       title="Debe tener al menos 8 caracteres, incluir una mayúscula, una minúscula y un carácter especial."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                <p class="text-xs text-gray-500 mt-1">Mín. 8 caracteres, incluye mayúscula, minúscula y símbolo especial.</p>
            </div>

            <div>
                <label for="password_confirm" class="block text-sm font-medium text-gray-700 mb-1">Confirmar Contraseña</label>
                <input type="password" id="password_confirm" name="password_confirm" required 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                <p id="errorMensaje" class="text-xs text-red-600 font-semibold mt-1 hidden">Las contraseñas no coinciden.</p>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition shadow-md">
                Registrarse
            </button>
        </form>

        <p class="mt-6 text-center text-gray-600">
            ¿Ya tienes cuenta? <a href="<?= BASE_URL ?>login" class="text-blue-600 font-bold hover:underline">Inicia sesión</a>
        </p>
        <p class="mt-4 text-center text-gray-600">
            <a href="<?= BASE_URL ?>" class="text-blue-600 font-bold hover:underline">Volver</a>
        </p>
    </div>

    <script>

        document.getElementById('formRegistro').addEventListener('submit', function(event) {
            const contrasenia = document.getElementById("password").value;
            const contraseniaConfirmar = document.getElementById("password_confirm").value;
            const errorMsg = document.getElementById("errorMensaje");

            if (contrasenia !== contraseniaConfirmar) {
                event.preventDefault(); // Evitamos que la página envie los datos
                errorMsg.classList.remove('hidden'); // Mostramos el mensaje de error rojo
                document.getElementById('password_confirm').focus(); // Lo ponemos en foco
            } else {
                errorMsg.classList.add('hidden'); // Ocultamos el error ya que es valido
            }
        });
    </script>
</body>
</html>