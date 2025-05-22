<?php
    session_start();
?>

<link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
<style>
    .font-anton {
        font-family: 'Anton', sans-serif;
    }
</style>
<header>
    <nav class="fixed top-0 w-full z-50 bg-neutral-800 h-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <?php if (!isset($_SESSION['email'])): ?>
                <div class="flex justify-between items-center h-full">
                    <!-- Logo -->
                    <a href="index.php" class="flex-shrink-0">
                        <img src="public/michampion_oscuro.png" alt="Mi Champion" style="height: 70px;">
                    </a>

                    <!-- Botones -->
                    <div class="flex space-x-4">
                        <a href="carta_burgers.php" class="text-[20px] md:text-[30px] lg:text-[35px] uppercase font-anton text-[#efece3] px-4 py-2 leading-none hover:text-amber-400 transition-colors duration-200">Burgers</a>
                        <a href="login.php" class="text-[16px] md:text-[20px] lg:text-[24px] uppercase font-anton text-[#efece3] border border-[#efece3] px-4 py-2 rounded hover:text-amber-400 hover:border-amber-400 transition-colors duration-200">Iniciar sesión</a>
                        <a href="registro.php" class="text-[16px] md:text-[20px] lg:text-[24px] uppercase font-anton text-[#efece3] border border-[#efece3] px-4 py-2 rounded hover:text-amber-400 hover:border-amber-400 transition-colors duration-200">Registrarse</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="flex justify-between items-center px-8">
                    <!-- Logo -->
                    <a href="panel_inicio.php" class="flex items-center space-x-3 mr-20">
                        <img src="public/michampion_oscuro.png" alt="Mi Champion" style="height: 70px;">
                    </a>

                    <!-- Enlaces principales -->
                    <div class="flex space-x-8 items-center">
                        <a href="carta_burgers.php" class="text-[20px] md:text-[30px] lg:text-[35px] uppercase font-anton text-[#efece3] leading-none hover:text-amber-400 transition-colors duration-200">
                            Burgers
                        </a>
                        <a href="burgers_probadas.php" class="text-[20px] md:text-[30px] lg:text-[35px] uppercase font-anton text-[#efece3] leading-none hover:text-amber-400 transition-colors duration-200">
                            Mis Burgers Probadas
                        </a>
                        <a href="perfil.php" class="text-[20px] md:text-[30px] lg:text-[35px] uppercase font-anton text-[#efece3] leading-none hover:text-amber-400 transition-colors duration-200">
                            Perfil
                        </a>
                        <a href="cerrar_sesion.php" class="text-[20px] md:text-[30px] lg:text-[35px] uppercase font-anton text-red-500 leading-none hover:text-amber-400 transition-colors duration-200">
                            Cerrar sesión
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </nav>
</header>