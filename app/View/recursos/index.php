<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Recursos - DreamClass</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden font-sans">

    <?php include __DIR__ . '/../layout/sidebar_docente.php'; ?>

    <div class="flex-1 flex flex-col h-screen overflow-y-auto">
        <div class="px-8 pt-6">
            <?php include __DIR__ . '/../layout/topbar.php'; ?>
        </div>

        <main class="flex-1 px-8 pb-12">
            
            <div class="mb-8 flex justify-between items-end">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Mis Recursos</h1>
                    <p class="text-gray-500">Guarda y organiza tus apuntes, ejercicios y PDFs por asignatura.</p>
                </div>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="bg-red-50 text-red-700 p-4 rounded-lg mb-6 border-l-4 border-red-500"><?= htmlspecialchars($_GET['error']) ?></div>
            <?php endif; ?>
            <?php if (isset($_GET['success'])): ?>
                <div class="bg-green-50 text-green-700 p-4 rounded-lg mb-6 border-l-4 border-green-500"><?= htmlspecialchars($_GET['success']) ?></div>
            <?php endif; ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            Subir Nuevo Archivo
                        </h2>
                        
                        <form action="<?= BASE_URL ?>recursos/subir" method="POST" enctype="multipart/form-data" class="space-y-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Asignatura</label>
                                <input type="text" name="asignatura" required placeholder="Ej: Matemáticas" list="asignaturas_list"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 bg-gray-50">
                                <datalist id="asignaturas_list">
                                    <?php foreach (array_keys($recursos) as $asig): ?>
                                        <option value="<?= htmlspecialchars($asig) ?>"></option>
                                    <?php endforeach; ?>
                                </datalist>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Archivo</label>
                                <input type="file" name="archivo" required
                                       class="w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer border border-gray-300 rounded-xl bg-gray-50">
                            </div>

                            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 transition mt-2">
                                Guardar en la Nube
                            </button>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-8">
                    <?php if (empty($recursos)): ?>
                        <div class="bg-white p-10 rounded-2xl border-2 border-dashed border-gray-200 text-center">
                            <h3 class="text-xl font-bold text-gray-800">Tu nube está vacía</h3>
                            <p class="text-gray-500 mt-2">Sube tu primer archivo usando el panel de la izquierda.</p>
                        </div>
                    <?php else: ?>
                        
                        <?php foreach ($recursos as $asignatura => $archivos): ?>
                            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                                <h3 class="text-lg font-extrabold text-gray-800 mb-4 flex items-center gap-2 border-b pb-3">
                                    <?= htmlspecialchars($asignatura) ?>
                                    <span class="text-sm font-normal text-gray-400 ml-auto"><?= count($archivos) ?> archivos</span>
                                </h3>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <?php foreach ($archivos as $archivo): ?>
                                        <div class="flex items-center justify-between p-3 border border-gray-100 rounded-xl hover:bg-gray-50 transition group">
                                            <div class="flex items-center gap-3 overflow-hidden">
                                                <svg class="w-8 h-8 text-gray-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                                                <div class="truncate">
                                                    <a href="<?= BASE_URL ?>public/recursos/<?= $archivo['archivo_fisico'] ?>" target="_blank" class="text-sm font-bold text-gray-700 hover:text-blue-600 truncate block" title="<?= htmlspecialchars($archivo['nombre_original']) ?>">
                                                        <?= htmlspecialchars($archivo['nombre_original']) ?>
                                                    </a>
                                                    <span class="text-xs text-gray-400"><?= date('d M Y', strtotime($archivo['fecha_subida'])) ?></span>
                                                </div>
                                            </div>
                                            <a href="<?= BASE_URL ?>recursos/eliminar/<?= $archivo['id_recurso'] ?>" onclick="return confirm('¿Seguro que quieres borrar este archivo?')" class="text-red-400 hover:text-red-600 p-2 opacity-0 group-hover:opacity-100 transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    <?php endif; ?>
                </div>

            </div>
        </main>
    </div>
</body>
</html>