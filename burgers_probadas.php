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
    $burgers = $hamburguesas->saberBurgersProbadas($usuarioId);
?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Mi Champion - Burgers Probadas</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    </head>

    <body>
        <?php include('components/header.php'); ?>

        <main class="pt-20 bg-gradient-to-br from-[#6c6c6c] to-[#343434] text-white p-6 min-h-screen mt-8">
            <div class="max-w-xl mx-auto text-center mb-8">
                <h1 class="text-[20px] md:text-[30px] lg:text-[35px] uppercase text-amber-400">Hamburguesas probadas</h1>
                <p class="text-[10px] md:text-[20px] lg:text-[30px] text-[#efece3]">Estas son las burgers que ya has disfrutado.<br>
                    ¿Quieres cambiar alguna nota o seguir sumando nuevas experiencias?<br>
                    <span class="text-amber-400">Tú mandas en tu paladar.</span> 😋
                </p>
                <p class="mt-4 text-sm text-white">Has probado <strong class="text-amber-400">2</strong> de <strong class="text-amber-400">27</strong> hamburguesas disponibles. <br>¡Te faltan solo <strong>25</strong>! 🔔</p>
            </div>

            <div class="max-w-4xl mx-auto mb-6">
                <!-- Filtros de alérgenos -->
                <div class="flex flex-wrap gap-2 mt-4 justify-center">
                    <?php 
                    $alergenos = ["Gluten", "Apio", "Frutos secos", "Sésamo", "Soja", "Huevo", "Sulfitos", "Lácteos", "Mostaza"];
                    foreach ($alergenos as $alergeno) {
                        echo "<button class='bg-purple-600 text-white px-4 py-1 rounded-full text-sm hover:bg-purple-700 transition'>{$alergeno}</button>";
                    }
                    ?>
                </div>
            </div>

            <!-- Burgers degustadas -->
            <div class="max-w-6xl mx-auto space-y-6">
                <?php if (empty($burgers)): ?>
                    <p class="text-center text-white">Aún no has probado ninguna burger 🍔</p>
                <?php else: ?>
                    <?php foreach ($burgers as $burger): ?>
                        <ul class="flex flex-col space-y-8 ">
                            <li class="relative group flex flex-col md:flex-row items-center justify-between rounded-2xl shadow-md p-6 gap-4 md:gap-8 bg-neutral-800" style="opacity: 1; transform: none;">
                                <div class="relative overflow-hidden rounded-lg group w-full md:w-48 flex-shrink-0">
                                    <img src="public/<?= $burger['imagen'] ?>" alt="<?= htmlspecialchars($burger['nombre']); ?>" class="w-full h-32 object-cover transform transition-transform duration-300 group-hover:scale-105">
                                </div>
                                <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button class="text-red-500 hover:text-red-700 text-xl transition-colors duration-200" title="Quitar de probadas" tabindex="0" style="transform: none;">🗑️</button>
                                </div>
                                <div class="flex-1 text-center md:text-left">
                                    <img src="public/<?= $burger['logo'] ?>" alt="<?= $burger['nombre'] ?>" class="w-auto h-10 object-cover">
                                    <h3  class="text-[20px] md:text-[30px] lg:text-[35px] uppercase font-anton text-amber-400 hover: hover:text-purple-600 transition"><?= htmlspecialchars($burger['nombre']) ?></h3>
                                    <p class="text-white mt-1 line-clamp-3"><?= htmlspecialchars($burger['descripcion']); ?></p>
                                </div>
                                <div class="flex flex-col items-center md:items-end gap-2 w-full md:w-64">
                                    <div class="text-center" style="opacity: 1;">
                                        <div class="flex space-x-1">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <?php if ($i <= $burger['calificacion']): ?>
                                                    <span class="text-yellow-400 text-2xl">★</span>
                                                <?php else: ?>
                                                    <span class="text-gray-500 text-2xl">☆</span>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap justify-center md:justify-end gap-2 mt-2">
                                        <div class="font-semibold text-white">
                                            <?php if (!empty($burger['atributo_favorito'])): ?>
                                                <?= htmlspecialchars($burger['atributo_favorito']); ?>
                                            <?php else: ?>
                                                Atributo no especificado
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>

        <?php include('components/footer.php'); ?>
    </body>
</html>