<?php
$uri = $_SERVER['REQUEST_URI'];

function getActiveClass($uri, $keyword) {
    if ($keyword === 'dashboard') {
        return (strpos($uri, '/alumno') !== false && 
                strpos($uri, 'clases') === false && 
                strpos($uri, 'mensajes') === false && 
                strpos($uri, 'tareas') === false && 
                strpos($uri, 'feedback') === false) 
            ? 'bg-blue-600 text-white shadow-md' 
            : 'text-gray-400 hover:bg-slate-800 hover:text-white';
    }

    return strpos($uri, $keyword) !== false 
        ? 'bg-blue-600 text-white shadow-md' 
        : 'text-gray-400 hover:bg-slate-800 hover:text-white';
}
?>

<aside class="w-64 bg-slate-900 text-white min-h-screen p-4 sticky top-0 flex flex-col transition-all duration-300">
    <div class="text-center mb-8 pt-4">
        <a href="<?= BASE_URL ?>alumno" class="block hover:opacity-80 transition transform hover:scale-105 duration-200">
            <img src="<?= BASE_URL ?>assets/img/logoDreamClass.png" alt="DreamClass Logo" class="h-16 w-auto mx-auto mb-3"> 
        </a>
    </div>

    <nav class="space-y-2 flex-1">
        <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Principal</p>
        
        <a href="<?= BASE_URL ?>alumno" class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium group <?= getActiveClass($uri, 'dashboard') ?>">
            <svg class="w-6 h-6 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            Inicio
        </a>

        <a href="<?= BASE_URL ?>clases" class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium group <?= (strpos($uri, 'clases') !== false && strpos($uri, 'explorar') === false) ? 'bg-blue-600 text-white shadow-md' : 'text-gray-400 hover:bg-slate-800 hover:text-white' ?>">
            <svg class="w-6 h-6 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            Mis Clases
        </a>

        <a href="<?= BASE_URL ?>clases/explorar" class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium group <?= getActiveClass($uri, 'explorar') ?>">
            <svg class="w-6 h-6 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            Buscar Clases
        </a>
        
        <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mt-6 mb-2">Gestión</p>

        <a href="<?= BASE_URL ?>mensajes" class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium group <?= getActiveClass($uri, 'mensajes') ?>">
            <svg class="w-6 h-6 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
            Chat
        </a>
        <a href="<?= BASE_URL ?>tareas" class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium group <?= getActiveClass($uri, 'tareas') ?>">
            <svg class="w-6 h-6 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            Tareas
        </a>
        <a href="<?= BASE_URL ?>feedback" class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium group <?= getActiveClass($uri, 'feedback') ?>">
            <svg class="w-6 h-6 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
            Feedback
        </a>
    </nav>
</aside>