<?php
require_once 'Conexion.php';
require_once 'Hamburguesas.php';

$conexion = new Conexion();
$db = $conexion->getConexion();
$hamburguesas = new Hamburguesas($db);

// Obtener el id de la burger desde la URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Si no hay id o no es válido, redirigir o mostrar error
    header('Location: carta_burgers.php');
    exit();
}

$idBurger = intval($_GET['id']);

// Obtener la info de la burger
$burger = $hamburguesas->obtenerBurgerPorId($idBurger);

if (!$burger) {
    // Si no existe, redirigir o mostrar error
    header('Location: carta_burgers.php');
    exit();
}

// Obtener alérgenos de esa burger
$alergenos = $hamburguesas->obtenerAlergenosPorBurger($idBurger);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title><?= htmlspecialchars($burger['nombre']) ?> - Detalle</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-neutral-800 text-white p-6">
    <?php include('components/header_sesion.php'); ?>

    <main class="pt-20 max-w-4xl mx-auto">
        <section class="bg-neutral-900 rounded-xl p-6 shadow-lg">
            <h1 class="text-4xl font-anton text-amber-400 mb-6"><?= htmlspecialchars($burger['nombre']) ?></h1>

            <div class="flex flex-col md:flex-row gap-6">
                <div class="flex-1">
                    <img src="public/<?= $burger['imagen'] ?>" alt="<?= htmlspecialchars($burger['nombre']) ?>" class="rounded-lg w-full object-cover">
                </div>
                <div class="flex-1 flex flex-col justify-between">
                    <div>
                        <img src="public/<?= $burger['logo'] ?>" alt="Logo <?= htmlspecialchars($burger['restaurante']) ?>" class="h-16 mb-4 object-contain">
                        <p class="text-gray-300 mb-6"><?= htmlspecialchars($burger['descripcion']) ?></p>
                    </div>

                    <div>
                        <p class="uppercase font-semibold text-sm text-gray-400 mb-2">Alérgenos:</p>
                        <?php if (!empty($alergenos)): ?>
                            <div class="flex flex-wrap gap-3">
                                <?php foreach ($alergenos as $alergeno): ?>
                                    <div class="flex items-center gap-2 bg-gray-700 px-3 py-1 rounded-full">
                                        <img src="public/<?= htmlspecialchars($alergeno['icono']) ?>" alt="<?= htmlspecialchars($alergeno['nombre']) ?>" class="h-6 w-6 object-contain">
                                        <span><?= htmlspecialchars($alergeno['nombre']) ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-gray-500">Sin alérgenos registrados</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <a href="carta_burgers.php" class="inline-block bg-amber-400 text-neutral-900 px-6 py-3 rounded-full font-semibold hover:bg-amber-500 transition">
                    Volver a la carta
                </a>
            </div>
        </section>
    </main>

    <?php include('components/footer_sesion.php'); ?>
</body>
</html>
