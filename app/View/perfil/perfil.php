<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - DreamClass</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex min-h-screen">

    <?php 
    $rol = $_SESSION['usuario_rol'];
    include __DIR__ . "/../layout/sidebar_{$rol}.php"; 
    ?>

    <main class="flex-1 p-8"> 
        
        <?php include __DIR__ . '/../layout/topbar.php'; ?>

        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-800">Editar Mi Perfil</h2>
                <p class="text-gray-500 text-sm">Actualiza tu información personal y tu foto.</p>
            </div>

            <?php if (isset($_GET['success'])): ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 m-6" role="alert">
                    <p><?= htmlspecialchars($_GET['success']) ?></p>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['error'])): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 m-6" role="alert">
                    <p><?= htmlspecialchars($_GET['error']) ?></p>
                </div>
            <?php endif; ?>

            <form action="<?= BASE_URL ?>perfil/actualizar" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                
                <div class="flex items-center space-x-6">
                    <div class="shrink-0">
                        <?php 
                        $fotoActual = $_SESSION['usuario_foto'] ?? null;
                        if ($fotoActual && file_exists(__DIR__ . '/../../../public/uploads/' . $fotoActual)): ?>
                            <img class="h-24 w-24 object-cover rounded-full border-2 border-gray-200" src="<?= BASE_URL ?>public/uploads/<?= $fotoActual ?>" alt="Foto actual">
                        <?php else: ?>
                            <div class="h-24 w-24 rounded-full bg-blue-100 flex items-center justify-center text-blue-500 text-2xl font-bold">
                                <?= substr($_SESSION['usuario_nombre'], 0, 1) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <label class="block">
                        <span class="sr-only">Elige una foto de perfil</span>
                        <input type="file" name="foto" accept="image/*" class="block w-full text-sm text-gray-500
                          file:mr-4 file:py-2 file:px-4
                          file:rounded-full file:border-0
                          file:text-sm file:font-semibold
                          file:bg-blue-50 file:text-blue-700
                          hover:file:bg-blue-100
                        "/>
                        <p class="mt-1 text-xs text-gray-500">JPG, PNG o GIF (Max. 2MB)</p>
                    </label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" name="nombre" value="<?= htmlspecialchars($_SESSION['usuario_nombre']) ?>" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 border">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Apellidos</label>
                        <input type="text" name="apellidos" value="<?= htmlspecialchars($_SESSION['usuario_apellidos'] ?? '') ?>" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 border">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($datos['usuario']['email'] ?? '') ?>" required
                            class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm sm:text-sm p-2 border cursor-not-allowed" readonly>
                        <p class="text-xs text-gray-500 mt-1">El email no se puede cambiar por seguridad.</p>
                    </div>
                </div>

                <hr>

                <div>
                    <h3 class="text-lg font-medium text-gray-900">Seguridad</h3>
                    <p class="text-xs text-gray-500 mb-4">Deja esto en blanco si no quieres cambiar tu contraseña.</p>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nueva Contraseña</label>
                        <input type="password" name="password" placeholder="••••••••" minlength="8"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 border">
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition shadow-md font-medium">
                        Guardar Cambios
                    </button>
                </div>

            </form>
        </div>
    </main>
</body>
</html>