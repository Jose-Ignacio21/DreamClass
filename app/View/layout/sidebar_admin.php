<?php
$uri = $_SERVER['REQUEST_URI'];

function getActiveClass($uri, $keyword) {
    if ($keyword === 'dashboard') {
        $isDashboard = strpos($uri, '/admin') !== false && 
                       strpos($uri, 'usuarios') === false && 
                       strpos($uri, 'validacion') === false &&
                       strpos($uri, 'editar_usuario') === false;
        return $isDashboard ? 'bg-blue-600 text-white shadow-md' : 'text-gray-400 hover:bg-slate-800 hover:text-white';
    }

    return strpos($uri, $keyword) !== false 
        ? 'bg-blue-600 text-white shadow-md' 
        : 'text-gray-400 hover:bg-slate-800 hover:text-white';
}
?>

<aside class="w-64 bg-slate-900 text-white min-h-screen p-4 sticky top-0 flex flex-col transition-all duration-300 z-20 shadow-lg">
    
    <div class="mb-8 pt-4 text-center">
            <h2 class="text-3xl font-bold text-blue-500 tracking-tight">Dream<span class="text-white">Class</span></h2>
            <p class="text-xs text-purple-400 mt-1 uppercase tracking-wider font-semibold">Administración</p>
    </div>

    <nav class="space-y-2 flex-1">
        <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Panel de Control</p>
        
        <a href="<?= BASE_URL ?>admin" class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium group <?= getActiveClass($uri, 'dashboard') ?>">
            <svg class="w-6 h-6 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            Inicio
        </a>
        
        <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mt-6 mb-2">Usuarios</p>

        <a href="<?= BASE_URL ?>admin/usuarios" class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium group <?= getActiveClass($uri, 'usuarios') ?>">
            <svg class="w-6 h-6 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            Gestionar Usuarios
        </a>

        <a href="<?= BASE_URL ?>admin/validacion" class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium group <?= getActiveClass($uri, 'validacion') ?>">
            <svg class="w-6 h-6 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Validar Docentes
        </a>
    </nav>
</aside>