<?php
    session_start();
    if (!isset($_SESSION['email'])) {
        header('Location: index.php');
        exit();
    } 

    require_once 'Conexion.php';
    require_once 'Usuario.php';
    require_once 'Hamburguesas.php';

    $conexion = new Conexion();
    $db = $conexion->getConexion();
    $usuario = new Usuario($db);
    $hamburguesas = new Hamburguesas($db);

    $email = $_SESSION['email'];
    $usuarioId = $usuario->obtenerIdUsuario($email);
    $datosUsuario = $usuario->obtenerDatosUsuarios($email);
    
    $burgers_probadas = $hamburguesas->contarBurgersProbadasPorUsuario($usuarioId);
    $burgers_totales = $hamburguesas->contarTotalBurgers();

    $niveles = 4;
    $burgersPorNivel = ceil($burgers_totales / $niveles);
    $nivelActual = min(ceil($burgers_probadas / $burgersPorNivel), $niveles);
    $burgersEnNivelActual = $burgers_probadas % $burgersPorNivel;
    $progresoNivel = min(($burgersEnNivelActual / $burgersPorNivel) * 100, 100);

    $logros = [
        1 => "Principiante de las burgers 🍔",
        2 => "Conocedor de burgers 😋",
        3 => "Sabedor de la carne 🧠🥩",
        4 => "Maestro de la hamburguesa 🔥👑",
    ];
    $logroActual = $logros[$nivelActual];
    
?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Mi Champion - Perfil</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    </head>

    <body>
        <?php include('components/header.php'); ?>

        <main class="bg-neutral-900 text-[#efece3] py-40 px-6 md:px-20">
            <div class="flex items-center justify-center gap-12 mb-10">
                <div class="w-24 h-24 bg-neutral-800 rounded-full flex items-center justify-center relative overflow-hidden shadow-lg">
                    <!-- Pan superior -->
                    <div class="w-16 h-8 bg-amber-500 rounded-t-full absolute top-[15%] z-10"></div>
                    <?php if ($nivelActual >= 4): ?>
                        <!-- Tomate (solo si es nivel 4) -->
                        <div class="absolute top-[32%] w-16 h-1 bg-red-600 rounded z-20"></div>
                    <?php endif; ?>
                    <?php if ($nivelActual >= 3): ?>
                        <!-- Lechuga (solo si es nivel 3) -->
                        <div class="absolute top-[35%] w-16 h-2 bg-green-500 rounded z-20"></div>
                    <?php endif; ?>
                    <?php if ($nivelActual >= 2): ?>
                        <!-- Queso (solo si es nivel 2  -->
                        <div class="absolute top-[40%] w-16 h-2 bg-yellow-300 z-20"></div>
                    <?php endif; ?>

                    <!-- Carne -->
                    <div class="absolute top-[45%] w-16 h-4 bg-[#6B4226] rounded z-10"></div>

                    <!-- Pan inferior -->
                    <div class="absolute top-[60%] w-16 h-3 bg-amber-500 rounded-b-full shadow-inner z-0"></div>
                </div>

                <div class="flex-1 max-w-md">
                    <h2 class="text-2xl md:text-3xl font-bold mb-4">Nivel <?= $nivelActual ?>: <?= $logroActual ?></h2>
                    <div class="w-full bg-neutral-700 h-6 rounded-full overflow-hidden relative">
                        <div class="bg-amber-400 h-full rounded-full transition-all duration-500 ease-in-out" style="width: <?= $progresoNivel ?>%;"></div>
                    </div>
                    <p class="mt-2 text-sm"><?= round($progresoNivel) ?>% completado en este nivel</p>
                </div>
            </div>
            <div class="h-2 w-full bg-amber-400 rounded animate-pulse my-10 mx-auto"></div>
            
            <div class="w-full max-w-md mx-auto bg-neutral-800 p-8 rounded-2xl shadow-xl space-y-8 text-center">
                <div class="flex items-center justify-center gap-4 bg-neutral-700 rounded-lg p-4 shadow-inner hover:bg-neutral-600 transition cursor-default select-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    <p class="text-xl font-bold text-amber-300 tracking-wide drop-shadow-md"><?= htmlspecialchars($datosUsuario['nombre']) . ' ' . htmlspecialchars($datosUsuario['apellidos']) ?></p>
                </div>

                <!-- Email -->
                <div class="flex items-center justify-center gap-4 bg-neutral-700 rounded-lg p-4 shadow-inner hover:bg-neutral-600 transition cursor-default select-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Zm0 0c0 1.657 1.007 3 2.25 3S21 13.657 21 12a9 9 0 1 0-2.636 6.364M16.5 12V8.25" />
                    </svg>
                    <p class="text-base text-amber-200 font-medium tracking-wide break-all"><?= htmlspecialchars($datosUsuario['email']) ?></p>
                </div>
            </div>
        </main>

        <?php include('components/footer.php'); ?>

    </body>
</html>