<header>
    <nav class="fixed top-0 w-full z-50 bg-neutral-800 h-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center h-full">
                <!-- Logo -->
                <a href="index.php" class="flex-shrink-0">
                    <img src="public/michampion_oscuro.png" alt="Mi Champion" class="h-20">
                </a>

                <!-- Icono menú hamburguesa -->
                <div class="relative inline-block text-left">
                    <button id="menuButton" class="p-2 rounded-md bg-neutral-700 text-white hover:bg-neutral-600 focus:outline-none focus:ring-2 focus:ring-amber-400">
                        <!-- Icono de hamburguesa -->
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <!-- Menú desplegable -->
                    <div id="menuDropdown" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-neutral-800 ring-1 ring-black ring-opacity-5 hidden z-50">
                        <div class="py-1 text-white">
                            <a href="perfil.php" class="block px-4 py-2 text-sm hover:bg-neutral-700">Perfil</a>
                            <a href="catalogo_burgers.php" class="block px-4 py-2 text-sm hover:bg-neutral-700">Catálogo Burgers</a>
                            <a href="burgers_probadas.php" class="block px-4 py-2 text-sm hover:bg-neutral-700">Burgers Probadas</a>
                            <a href="cerrar_sesion.php" class="block px-4 py-2 text-sm text-red-400 hover:bg-neutral-700 hover:text-red-300">Cerrar Sesión</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
