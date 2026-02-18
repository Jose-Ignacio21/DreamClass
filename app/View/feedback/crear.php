<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dejar Feedback - DreamClass</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex">

    <?php include __DIR__ . '/../layout/sidebar_alumno.php'; ?>

    <main class="flex-1 p-6 max-w-6xl w-full">
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Dejar Feedback</h1>
            
            <p class="mb-4">Clase con: <strong><?= htmlspecialchars($datos['docente_nombre']) ?></strong></p>

            <form action="<?= BASE_URL ?>feedback/procesar" method="POST" class="space-y-6">
                <input type="hidden" name="id_clase" value="<?= $datos['id_clase'] ?>">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Calificación</label>
                    <select name="calificacion" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        <option value="">-- Selecciona --</option>
                        <option value="1">1 estrella</option>
                        <option value="2">2 estrellas</option>
                        <option value="3">3 estrellas</option>
                        <option value="4">4 estrellas</option>
                        <option value="5">5 estrellas</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Comentario (opcional)</label>
                    <textarea name="comentario" rows="4" placeholder="¿Qué te pareció la clase?" 
                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"></textarea>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Enviar Feedback</button>
                    <a href="<?= BASE_URL ?>alumno" class="px-6 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition">← Volver</a>
                </div>
            </form>
        </div>
    </main>

</body>
</html>