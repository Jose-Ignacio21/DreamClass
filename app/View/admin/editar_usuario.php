<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($datos['titulo']) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex min-h-screen">

    <?php include __DIR__ . '/../layout/sidebar_admin.php'; ?>

    <main class="flex-1 p-8 w-full max-w-2xl mx-auto">
        
        <header class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Editar Perfil</h1>
                <p class="text-gray-600 mt-2">Modifica los datos del usuario seleccionado.</p>
            </div>
            <a href="<?= BASE_URL ?>admin/usuarios" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md transition">
                Volver
            </a>
        </header>

        <?php if ($datos['error']): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
                <?= htmlspecialchars($datos['error']) ?>
            </div>
        <?php endif; ?>

        <?php $u = $datos['usuario_editar']; ?>

        <div class="bg-white rounded-lg shadow-md p-8 border-t-4 border-indigo-500">
            <form action="<?= BASE_URL ?>admin/procesar_edicion" method="POST" class="space-y-6">
                <input type="hidden" name="id_usuario" value="<?= $u['id_usuario'] ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                        <input type="text" name="nombre" value="<?= htmlspecialchars($u['nombre']) ?>" required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Apellidos</label>
                        <input type="text" name="apellidos" value="<?= htmlspecialchars($u['apellidos'] ?? '') ?>" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico (Email)</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($u['email']) ?>" required 
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Rol en la plataforma</label>
                    <select name="rol" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="alumno" <?= $u['rol'] === 'alumno' ? 'selected' : '' ?>>Alumno</option>
                        <option value="docente" <?= $u['rol'] === 'docente' ? 'selected' : '' ?>>Docente</option>
                        <option value="admin" <?= $u['rol'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
                    </select>
                </div>

                <div class="pt-4 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-md shadow-sm transition">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>

    </main>
</body>
</html>