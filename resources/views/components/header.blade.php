<header class="bg-white border-b border-gray-200 fixed top-0 left-64 w-full h-16 flex items-center justify-between px-6 z-10">
    <!-- Logo and Company Name -->
    <div class="flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-800" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 1.5A6.5 6.5 0 1110 16a6.5 6.5 0 010-13zM9.2 6.2a1.2 1.2 0 112.4 0 1.2 1.2 0 01-2.4 0zm2.9 8.2a.75.75 0 01-.96.49 4.1 4.1 0 00-2.48 0 .75.75 0 11-.48-1.42 5.6 5.6 0 013.44 0 .75.75 0 01.48.93z"/>
        </svg>
        <span class="ml-3 text-lg font-bold text-gray-800">Mi Empresa</span>
    </div>

    <!-- Authenticated User -->
    <div class="flex items-center">
        <span class="mr-4 text-sm text-gray-800">Bienvenido, {{ Auth::user()->name ?? 'Invitado' }}</span>
        <img src="https://via.placeholder.com/40" alt="User Avatar" class="w-10 h-10 rounded-full">
    </div>
</header>
