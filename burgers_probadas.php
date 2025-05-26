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

    $alergenosSeleccionados = isset($_GET['alergenos']) ? array_map('intval', $_GET['alergenos']) : [];
    if (!empty($alergenosSeleccionados)) {
        $burgers = $hamburguesas->obtenerBurgersSinAlergenosProbadas($alergenosSeleccionados, $usuarioId);
    } else {
        $burgers = $hamburguesas->saberBurgersProbadas($usuarioId);
    }
   

    $burgers_probadas = $hamburguesas->contarBurgersProbadasPorUsuario($usuarioId);
    $burgers_totales = $hamburguesas->contarTotalBurgers();
    $alergenosPorBurger = $hamburguesas->obtenerAlergenosDeTodasLasBurgers();
    $alergenos=$hamburguesas->obtenerTodosLosAlergenos();
    
    
?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Mi Champion - Burgers Probadas</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
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

        </style>
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
                <p class="mt-4 text-sm text-white">Has probado <strong class="text-amber-400"><?php echo $burgers_probadas; ?></strong> de <strong class="text-amber-400"><?php echo $burgers_totales; ?></strong> hamburguesas disponibles. <br>¡Te faltan solo <strong><?php echo $burgers_totales - $burgers_probadas; ?></strong>! 🔔</p>
            </div>
            <div class="h-2 w-full bg-amber-400 rounded animate-pulse my-10 mx-auto"></div>

            <form method="GET" action="burgers_probadas.php" class="mb-6 flex flex-wrap items-center gap-4">
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
                        <a href="burgers_probadas.php" class="inline-flex items-center gap-2 cursor-pointer bg-gradient-to-r from-amber-300 to-amber-400 rounded-xl px-5 py-2
                            font-semibold text-black shadow-lg hover:scale-105 hover:shadow-xl transition-transform duration-200">Limpiar filtros</a>
                    </div>
                </form>
                <div class="h-2 w-full bg-amber-400 rounded animate-pulse my-10 mx-auto"></div>

            <!-- Burgers degustadas -->
            <div class="max-w-6xl mx-auto space-y-6">
                <?php if (empty($burgers)): ?>
                    <p class="text-center text-white">Aún no has probado ninguna burger 🍔</p>
                <?php else: ?>
                    <?php foreach ($burgers as $burger): ?>
                        <ul class="flex flex-col space-y-8 ">
                            <a href="detalle_burger.php?id=<?php echo $burger['id']; ?>">
                                <li class="relative group flex flex-col md:flex-row items-center justify-between rounded-2xl shadow-md p-6 gap-4 md:gap-8 bg-neutral-800" style="opacity: 1; transform: none;">
                                    <div class="relative overflow-hidden rounded-lg group w-full md:w-48 flex-shrink-0">
                                        <img src="public/<?= $burger['imagen'] ?>" alt="<?= htmlspecialchars($burger['nombre']); ?>" class="w-full h-32 object-cover transform transition-transform duration-300 group-hover:scale-105">
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
                                                    <img src="public/<?= htmlspecialchars($burger['atributo_favorito']) ?>.svg" alt="<?= htmlspecialchars($burger['atributo_favorito']) ?>" class="inline-block w-6 h-6 mr-2">
                                                    <?= htmlspecialchars($burger['atributo_favorito']); ?>
                                                <?php else: ?>
                                                    Atributo no especificado
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </a>
                        </ul>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>

        <?php include('components/footer.php'); ?>
    </body>
</html>