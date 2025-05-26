<?php
    session_start();
    require_once 'Conexion.php';
    require_once 'Hamburguesas.php';

    $conexion = new Conexion();
    $db = $conexion->getConexion();

    $hamburguesas = new Hamburguesas($db);

    // Obtener alérgenos seleccionados
    $alergenosSeleccionados = isset($_GET['alergenos']) ? $_GET['alergenos'] : [];
    if (!empty($alergenosSeleccionados)) {
        $burgers = $hamburguesas->obtenerBurgersSinAlergenos($alergenosSeleccionados);
    } else {
        $burgers = $hamburguesas->obtenerTodasLasBurgers();
    }

    // Obtener todas las burgers y sus alérgenos
    $alergenosPorBurger = $hamburguesas->obtenerAlergenosDeTodasLasBurgers();
    $alergenos=$hamburguesas->obtenerTodosLosAlergenos();
?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Mi Champion - Carta de Burgers</title>
        <script src="https://cdn.tailwindcss.com"></script>

        <style>
            /* Oculta el checkbox real */
            input[type="checkbox"] {
                position: absolute;
                opacity: 0;
                width: 0;
                height: 0;
                pointer-events: none;
            }

            /* icono + texto */
            label {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                cursor: pointer;
                position: relative;
                user-select: none;
            }

            /* El icono por defecto (cuando NO está seleccionado) */
            label img {
                filter: grayscale(100%);
                transition: filter 0.3s ease;
            }

            /* Cuando el checkbox está checked, cambia el icono para "colorearlo" */
            input[type="checkbox"]:checked + img {
                filter: none;
            }
            body, html {
                height: 100%;
                margin: 0;
            }

            main {
                min-height: 60vh;
                display: flex;
                flex-direction: column;
            }

        </style>
    </head>

    <body>
        <?php include('components/header.php'); ?>
        <main class="pt-20 bg-gradient-to-br from-[#6c6c6c] to-[#343434] text-white p-6">
            <section class="py-16">
                <form method="GET" action="carta_burgers.php" class="mb-6 flex flex-wrap items-center gap-4">
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 flex-grow">
                        <?php foreach ($alergenos as $alergeno): ?>
                            <label
                                class="inline-flex items-center gap-2 cursor-pointer bg-gradient-to-r from-gray-800 via-gray-900 to-black rounded-xl px-3 py-2 w-[150px] shadow-md
                                    transition-transform duration-200 ease-in-out hover:scale-105 hover:shadow-lg select-none relative overflow-hidden">
                                <input type="checkbox" name="alergenos[]" value="<?= $alergeno['id'] ?>" class="absolute opacity-0 w-0 h-0 pointer-events-none"
                                    <?= (isset($_GET['alergenos']) && in_array($alergeno['id'], $_GET['alergenos'])) ? 'checked' : '' ?>
                                />
                                <img src="public/<?= htmlspecialchars($alergeno['icono']) ?>" alt="<?= htmlspecialchars($alergeno['nombre']) ?>" class="h-5 w-5 object-contain transition-filter duration-300
                                        <?= (isset($_GET['alergenos']) && in_array($alergeno['id'], $_GET['alergenos'])) ? 'filter-none' : 'filter grayscale' ?>"/>
                                <span class="text-sm font-semibold text-white drop-shadow-md">
                                    <?= htmlspecialchars($alergeno['nombre']) ?>
                                </span>
                                <span class="absolute top-1 right-1 w-5 h-5 rounded-full bg-green-500 text-white flex items-center justify-center text-xs font-bold opacity-0 transition-opacity duration-300
                                        peer-checked:opacity-100">✓
                                </span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <div class="flex items-center gap-4 mt-4">
                        <span class="ml-auto text-white font-semibold text-lg select-none">
                            Total hamburguesas: <?= count($burgers) ?>
                        </span>
                        <div class="relative group inline-block ml-4">
                            <button type="button" class="bg-gray-700 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-gray-600" title="Haz clic para más información">
                                ?
                            </button>
                            <div class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 w-64 text-sm text-white bg-gray-800 p-2 rounded-lg shadow-lg opacity-0 group-hover:opacity-100
                                        transition-opacity duration-300 pointer-events-none z-10">Marca los alérgenos que <strong>NO quieres</strong> que lleve tu hamburguesa.
                            </div>
                        </div>
                        <button type="submit" class="inline-flex items-center gap-2 cursor-pointer bg-gradient-to-r from-amber-300 to-amber-400 rounded-xl px-5 py-2 font-semibold text-black
                                shadow-lg hover:scale-105 hover:shadow-xl transition-transform duration-200">Filtrar
                        </button>
                        <a href="carta_burgers.php" class="inline-flex items-center gap-2 cursor-pointer bg-gradient-to-r from-amber-300 to-amber-400 rounded-xl px-5 py-2
                            font-semibold text-black shadow-lg hover:scale-105 hover:shadow-xl transition-transform duration-200">Limpiar filtros</a>
                    </div>
                </form>
                <div class="h-2 w-full bg-amber-400 rounded animate-pulse my-10 mx-auto"></div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php if (count($burgers) === 0): ?>
                        <p class="text-center col-span-full text-red-400 font-bold text-lg">No hay ninguna burger con estos requisitos.</p>
                    <?php else: ?>
                        <?php foreach ($burgers as $burger): ?>
                            <?php
                                $alergenosBurger = $alergenosPorBurger[$burger['id']] ?? [];
                                include(__DIR__ . '/components/card_burger.php');
                            ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>
        </main>
        <?php include('components/footer.php'); ?>
    </body>
</html>
