<?php
$nombre = $_SESSION['usuario_nombre'] ?? 'Usuario';
$apellido = $_SESSION['usuario_apellidos'] ?? ''; 
$rol = $_SESSION['usuario_rol'] ?? 'alumno';
$foto = $_SESSION['usuario_foto'] ?? null;

$iniciales = strtoupper(substr($nombre, 0, 1));
if (!empty($apellido)) {
    $iniciales .= strtoupper(substr($apellido, 0, 1));
}

if ($rol === 'docente') {
    $bgColor = 'bg-green-600';
} elseif ($rol === 'admin') {
    $bgColor = 'bg-purple-600';
} else {
    $bgColor = 'bg-blue-600';
}

$tituloPanel = ($rol === 'admin') ? 'Panel de Control' : 'Panel de ' . ucfirst($rol);
?>

<div class="flex justify-between items-center bg-white shadow-sm px-6 py-3 mb-6 rounded-lg sticky top-0 z-40">
    
    <div>
        <h2 class="text-xl font-bold text-gray-700">
            <?= $tituloPanel ?>
        </h2>
        
        <p class="text-sm text-gray-500 flex items-center gap-1">
            Bienvenido, <?= $nombre ?>
            
            <?php if ($rol === 'docente' && ($_SESSION['estado_validacion'] ?? '') === 'verificado'): ?>
                <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20" title="Docente Verificado">
                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            <?php endif; ?>
        </p>
    </div>

    <div class="relative">
        <button onclick="toggleUserMenu()" class="flex items-center justify-center w-12 h-12 rounded-full border-2 border-gray-100 focus:outline-none hover:shadow-md transition overflow-hidden">
            <?php if ($foto && file_exists('public/uploads/' . $foto)): ?>
                <img src="<?= BASE_URL ?>public/uploads/<?= $foto ?>" alt="Perfil" class="w-full h-full object-cover">
            <?php else: ?>
                <div class="w-full h-full <?= $bgColor ?> text-white flex items-center justify-center font-bold text-lg">
                    <?= $iniciales ?>
                </div>
            <?php endif; ?>
        </button>

        <div id="userDropdown" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl py-2 z-50 border border-gray-100">
            <div class="px-4 py-3 border-b border-gray-100">
                <p class="text-sm font-bold text-gray-900"><?= $nombre . ' ' . $apellido ?></p>
                <p class="text-xs text-gray-500 capitalize"><?= $rol ?></p>
            </div>

            <a href="<?= BASE_URL ?>perfil" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                Mi Perfil
            </a>

            <?php if ($rol === 'docente'): ?>
                <a href="<?= BASE_URL ?>docente/validacion" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                    Validar Título
                </a>
            <?php endif; ?>

            <div class="border-t border-gray-100 my-1"></div>
            
            <a href="<?= BASE_URL ?>logout" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center gap-2">
                Cerrar Sesión
            </a>
        </div>
    </div>
</div>

<script>
    function toggleUserMenu() {
        document.getElementById('userDropdown').classList.toggle('hidden');
    }
    window.addEventListener('click', function(e) {
        const menu = document.getElementById('userDropdown');
        const btn = document.querySelector('button[onclick="toggleUserMenu()"]');
        if (!btn.contains(e.target) && !menu.contains(e.target)) {
            menu.classList.add('hidden');
        }
    });
</script>