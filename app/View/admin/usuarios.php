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

    <main class="flex-1 p-8 w-full max-w-7xl mx-auto">
        
        <header class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Gestión de Usuarios</h1>
                <p class="text-gray-600 mt-2">Administra los roles de la plataforma</p>
            </div>
        </header>

        <?php if ($datos['error']): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
                <?= htmlspecialchars($datos['error']) ?>
            </div>
        <?php endif; ?>
        <?php if ($datos['success']): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                <?= htmlspecialchars($datos['success']) ?>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rol</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Registro</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($datos['usuarios'] as $usuario): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                #<?= htmlspecialchars($usuario['id_usuario']) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellidos']) ?></div>
                                <div class="text-sm text-gray-500"><?= htmlspecialchars($usuario['email']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if ($usuario['rol'] === 'admin'): ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Admin</span>
                                <?php elseif ($usuario['rol'] === 'docente'): ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Docente</span>
                                <?php else: ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Alumno</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('d/m/Y', strtotime($usuario['fecha_registro'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <?php if ($usuario['rol'] !== 'admin'): ?>
                                    <a href="<?= BASE_URL ?>admin/editar_usuario?id=<?= $usuario['id_usuario'] ?>" class="text-indigo-600 hover:text-indigo-900 mr-3 font-medium transition">Editar</a>
                                    <a href="<?= BASE_URL ?>admin/eliminar_usuario?id=<?= $usuario['id_usuario'] ?>" onclick="return confirm('¿Estas seguro?\n\nAl borrar a este usuario desaparecerán también sus clases, mensajes y tareas para siempre.');" class="text-red-600 hover:text-red-900 font-medium transition">Eliminar</a>
                                <?php else: ?>
                                    <span class="text-gray-400 text-xs italic">Intocable</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </main>
</body>
</html>