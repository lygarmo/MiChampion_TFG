<?php
    session_start();
    require_once 'Conexion.php';
    require_once 'Hamburguesas.php';

    $conexion = new Conexion();
    $db = $conexion->getConexion();

    $hamburguesas = new Hamburguesas($db);

    // Obtener todas las burgers y sus alérgenos
    $burgers = $hamburguesas->obtenerTodasLasBurgers();
    $alergenosPorBurger = $hamburguesas->obtenerAlergenosDeTodasLasBurgers();
?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Mi Champion - Carta de Burgers</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body>
        <?php include('components/header.php'); ?>
        <main class="pt-20 bg-gradient-to-br from-[#6c6c6c] to-[#343434] text-white p-6"">
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
        <?php include('components/footer.php'); ?>
    </body>
</html>
