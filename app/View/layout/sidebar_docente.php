<?php
$uri = $_SERVER['REQUEST_URI'];

function getActiveClass($uri, $keyword) {
    if ($keyword === 'dashboard') {
        $isDashboard = strpos($uri, '/docente') !== false && 
                       strpos($uri, 'clases') === false && 
                       strpos($uri, 'mensajes') === false && 
                       strpos($uri, 'tareas') === false && 
                       strpos($uri, 'feedback') === false && 
                       strpos($uri, 'validacion') === false &&
                       strpos($uri, 'recursos') === false &&
                       strpos($uri, 'horario') === false;
        return $isDashboard ? 'bg-blue-600 text-white shadow-md' : 'text-gray-400 hover:bg-slate-800 hover:text-white';
    }

    return strpos($uri, $keyword) !== false 
        ? 'bg-blue-600 text-white shadow-md' 
        : 'text-gray-400 hover:bg-slate-800 hover:text-white';
}
?>

<aside class="w-64 bg-slate-900 text-white min-h-screen p-4 sticky top-0 flex flex-col transition-all duration-300">
    <div class="text-center mb-8 pt-4">
        <a href="<?= BASE_URL ?>docente" class="block hover:opacity-80 transition transform hover:scale-105 duration-200">
            <img src="<?= BASE_URL ?>assets/img/logoDreamClass.png"
                alt="DreamClass Logo"
                class="h-16 w-auto mx-auto mb-3"> 
        </a>
    </div>

    <nav class="space-y-2 flex-1">
        <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Principal</p>
        
        <a href="<?= BASE_URL ?>docente" class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium group <?= getActiveClass($uri, 'dashboard') ?>">
            <svg class="w-6 h-6 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            Inicio
        </a>

        <a href="<?= BASE_URL ?>clases" class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium group <?= getActiveClass($uri, 'clases') ?>">
            <svg class="w-6 h-6 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            Mis Clases
        </a>
        
        <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mt-6 mb-2">Gestión</p>

        <a href="<?= BASE_URL ?>mensajes" class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium group <?= getActiveClass($uri, 'mensajes') ?>">
            <svg class="w-6 h-6 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
            Mensajes
        </a>

        <a href="<?= BASE_URL ?>tareas/crear" class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium group <?= getActiveClass($uri, 'tareas') ?>">
            <svg class="w-6 h-6 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Asignar Tarea
        </a>

        <a href="<?= BASE_URL ?>docente/feedback" class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium group <?= getActiveClass($uri, 'feedback') ?>">
            <svg class="w-6 h-6 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
            Feedback
        </a>
        
        <a href="<?= BASE_URL ?>docente/validacion" class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium group <?= getActiveClass($uri, 'validacion') ?>">
            <svg class="w-6 h-6 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M12 14l9-5-9-5-9 5 9 5z" />
                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
            </svg>
            Validación
        </a>

        <a href="<?= BASE_URL ?>recursos" class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium group <?= getActiveClass($uri, 'recursos') ?>">
            <svg class="w-6 h-6 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"></path></svg>
            Mis Recursos
        </a>

        <a href="<?= BASE_URL ?>historial" class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium group <?= getActiveClass($uri, 'historial') ?>">
            <svg class="w-6 h-6 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Finanzas e Historial
        </a>
        
        <div class="mt-auto pt-6">
            <a href="<?= BASE_URL ?>logout" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white transition text-sm font-bold group">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Cerrar sesión
            </a>
        </div>
    </nav>
</aside>