<?php
require_once 'Conexion.php';
require_once 'Hamburguesas.php';

$conexion = new Conexion();
$db = $conexion->getConexion();

$hamburguesas = new Hamburguesas($db);

// Obtener todas las burgers y sus alérgenos
$burgers = $hamburguesas->obtenerTodasLasBurgers();
$alergenosPorBurger = $hamburguesas->obtenerAlergenosDeTodasLasBurgers();

// Si luego quieres filtrar, aquí procesarías $_GET['alergeno'] o $_GET['tipo'], etc.

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Mi Champion - Carta de Burgers</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-neutral-800 text-white p-6">
        <?php include('components/header_sesion.php'); ?>
        <main class="pt-20">
            <section class="py-16">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($burgers as $burger): ?>
                        <?php
                            $alergenos = $alergenosPorBurger[$burger['id']] ?? [];
                            include(__DIR__ . '/components/card_burger.php');
                        ?>
                    <?php endforeach; ?>
                </div>
            </section>
        </main>
    </body>
</html>
