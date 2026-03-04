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
        <header class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Validación de Docentes</h1>
            <p class="text-gray-600 mt-2">Revisa los títulos y los profesores seran validadados.</p>
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

        <?php if (empty($datos['docentes'])): ?>
            <div class="bg-white p-8 text-center rounded-lg shadow border border-gray-200">
                <h3 class="text-xl font-medium text-gray-800">¡Todo al día!</h3>
                <p class="text-gray-500 mt-2">No hay docentes pendientes de validación en este momento.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 gap-6">
                <?php foreach ($datos['docentes'] as $docente): ?>
                    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-400 flex flex-col md:flex-row items-center justify-between">
                        
                        <div class="mb-4 md:mb-0 flex-1">
                            <h2 class="text-xl font-bold text-gray-800">
                                <?= htmlspecialchars($docente['nombre'] . ' ' . $docente['apellidos']) ?>
                            </h2>
                            <p class="text-gray-500 text-sm mb-2"><?= htmlspecialchars($docente['email']) ?></p>
                            <p class="text-xs text-gray-400">Registrado el: <?= date('d/m/Y', strtotime($docente['fecha_registro'])) ?></p>
                        </div>

                        <div class="flex-1 text-center mb-4 md:mb-0">
                            <?php if (!empty($docente['archivo_titulo'])): ?>
                                <p class="text-sm font-semibold text-gray-600 mb-1">Título / Certificado:</p>
                                <a href="<?= BASE_URL ?>uploads/titulos/<?= htmlspecialchars($docente['archivo_titulo']) ?>" target="_blank" class="inline-flex items-center text-blue-600 hover:text-blue-800 hover:underline">
                                    Ver Documento
                                </a>
                            <?php else: ?>
                                <span class="text-sm italic text-gray-400">No ha subido documento</span>
                            <?php endif; ?>
                        </div>

                        <div class="flex gap-3">
                            <form action="<?= BASE_URL ?>admin/procesar_validacion" method="POST" onsubmit="return confirm('¿Aprobar a este docente?');">
                                <input type="hidden" name="id_docente" value="<?= $docente['id_usuario'] ?>">
                                <input type="hidden" name="accion" value="verificado">
                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md transition flex items-center shadow-sm">
                                    Aprobar
                                </button>
                            </form>

                            <form action="<?= BASE_URL ?>admin/procesar_validacion" method="POST" onsubmit="return confirm('¿Rechazar a este docente?');">
                                <input type="hidden" name="id_docente" value="<?= $docente['id_usuario'] ?>">
                                <input type="hidden" name="accion" value="rechazado">
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md transition flex items-center shadow-sm">
                                    Rechazar
                                </button>
                            </form>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </main>
</body>
</html>