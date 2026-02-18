<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos del Grupo - DreamClass</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden font-sans">

    <?php include __DIR__ . '/../layout/sidebar_docente.php'; ?>

    <div class="flex-1 flex flex-col h-screen overflow-y-auto">
        <div class="px-8 pt-6">
            <?php include __DIR__ . '/../layout/topbar.php'; ?>
        </div>

        <main class="flex-1 px-8 pb-12">
            
            <div class="mb-6">
                <a href="<?= BASE_URL ?>clases" class="text-gray-500 hover:text-blue-600 flex items-center gap-2 mb-2">
                    <span>←</span> Volver a mis grupos
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Alumnos Inscritos</h1>
                <p class="text-gray-500">Aquí tienes a todos los alumnos que han pagado la suscripción para este grupo.</p>
            </div>

            <?php if (empty($alumnos)): ?>
                <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-800 p-4 mb-6 rounded-r-lg shadow-sm">
                    Todavía no hay ningún alumno inscrito en este grupo.
                </div>
            <?php else: ?>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th scope="col" class="px-6 py-4">Nombre y Apellidos</th>
                                <th scope="col" class="px-6 py-4">Email Contacto</th>
                                <th scope="col" class="px-6 py-4">Fecha de Inscripción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php foreach ($alumnos as $alumno): ?>
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">
                                            <?= strtoupper(substr($alumno['nombre'], 0, 1)) ?>
                                        </div>
                                        <?= htmlspecialchars($alumno['nombre'] . ' ' . $alumno['apellidos']) ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="mailto:<?= htmlspecialchars($alumno['email']) ?>" class="text-blue-600 hover:underline">
                                            <?= htmlspecialchars($alumno['email']) ?>
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500">
                                        <?= date('d/m/Y - H:i', strtotime($alumno['fecha_inscripcion'])) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>