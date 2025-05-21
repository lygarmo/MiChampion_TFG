<?php
    session_start();

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
$alergenos = $hamburguesas->obtenerAlergenosPorBurger($burger['id']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title><?= htmlspecialchars($burger['nombre']) ?> - Detalle</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-[#6c6c6c] to-[#343434] text-white p-6">
    <?php include('components/header_sesion.php'); ?>

    <main class="pt-24">
        <?php include('components/detalles_burger.php'); ?>
    </main>

    <?php include('components/footer.php'); ?>
</body>
</html>
