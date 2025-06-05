<?php
    session_start();

    require_once 'Conexion.php';
    require_once 'Usuario.php';
    require_once 'Hamburguesas.php';

    $conexion = new Conexion();
    $db = $conexion->getConexion();
    $usuario = new Usuario($db);
    $hamburguesas = new Hamburguesas($db);

    // Obtener el id de la burger desde la URL
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        // Si no hay id o no es válido, redirigir o mostrar error
        header('Location: carta_burgers.php');
        exit();
    }
    
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI']; // Guarda la URL actual

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

    $email = $_SESSION['email'];
    $usuarioId = $usuario->obtenerIdUsuario($email);

    $burgerId = $burger['id'];

    $yaProbada = $hamburguesas->probada($usuarioId, $burgerId);

    $atributos = ['Pan', 'Carne', 'Combinacion', 'Originalidad', 'Presentacion'];

    $valoracionGuardada = $hamburguesas->obtenerValoracion($usuarioId, $burger['id']) ?? 0;
    $atributoFavoritoGuardado = $hamburguesas->obtenerAtributoFavorito($usuarioId, $burger['id']);
    $redirect = urlencode("burger_detalle.php?id=$burgerId");

?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />
        <title><?= htmlspecialchars($burger['nombre']) ?> - Detalles</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
        <link rel="icon" href="/MiChampion_TFG/public/michampion_logo.png" type="image/png">
    </head>
    <body class="bg-gradient-to-br from-[#6c6c6c] to-[#343434] text-white">
        <?php include('components/header.php');?>

        <main class="pt-24 mt-8">
            <div class="bg-neutral-800 rounded-xl shadow-xl text-white mt-8 mb-8 p-8 max-w-6xl mx-auto">
                <div class="flex flex-col lg:flex-row gap-10">
                    
                    <!-- Imagen -->
                    <div class="flex-shrink-0 w-full lg:w-1/2">
                        <img src="public/<?= htmlspecialchars($burger['imagen']) ?>" alt="<?= htmlspecialchars($burger['nombre']) ?>" class="rounded-2xl w-full object-cover shadow-md">
                    </div>

                    <!-- Detalles -->
                    <div class="flex flex-col justify-between w-full lg:w-1/2 space-y-6">
                        <!-- Logo -->
                        <div class="flex justify-center lg:justify-start">
                            <img src="public/<?= htmlspecialchars($burger['logo']) ?>" alt="Logo <?= htmlspecialchars($burger['restaurante']) ?>" class="h-16">
                        </div>

                        <!-- Nombre -->
                        <h1 class="text-3xl md:text-5xl font-anton text-amber-400 uppercase mb-8"><?= htmlspecialchars($burger['nombre']) ?></h1>
                        <!-- Descripción -->
                        <p class="text-lg text-white"><?= htmlspecialchars($burger['descripcion']) ?></p>
                                            

                        <!-- Alérgenos -->
                        <?php if (!empty($alergenos)): ?>
                            <div>
                                <p class="font-semibold mb-2">Alérgenos:</p>
                                <div class="flex flex-wrap gap-2">
                                    <?php foreach ($alergenos as $alergeno): ?>
                                        <span class="bg-black rounded-full p-1 inline-flex items-center gap-1" title="<?= htmlspecialchars($alergeno['nombre']) ?>">
                                            <img src="public/<?= htmlspecialchars($alergeno['icono']) ?>" alt="<?= htmlspecialchars($alergeno['nombre']) ?>" class="h-5 w-5 object-contain"><?= htmlspecialchars($alergeno['nombre']) ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="w-full mt-20">
                    <!-- Acciones -->
                    <?php if (isset($_SESSION['email'])): ?>
                        <!-- Usuario con sesión -->
                        <div class="mt-8" id="acciones-burger-<?= $burger['id'] ?>">
                            <?php if ($yaProbada): ?>
                                <div class="h-1 w-full bg-amber-400 rounded animate-pulse my-10 mx-auto"></div>

                                <div class="flex flex-col items-center justify-center text-center mb-20">
                                    <p class="text-2xl md:text-4xl font-anton text-white uppercase mb-8">¿Qué fue lo mejor de esta burger?</p>
                                    <div class="flex flex-wrap justify-center gap-4 mt-6">
                                        <?php foreach ($atributos as $atributo): ?>
                                            <form method="POST" action="guardar_atributo.php">
                                                <input type="hidden" name="id_burger" value="<?= htmlspecialchars($burger['id']) ?>">
                                                <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($usuarioId) ?>">
                                                <input type="hidden" name="atributo_favorito" value="<?= $atributo ?>">
                                                <button type="submit" class="cursor-pointer text-center focus:outline-none">
                                                    <img src="public/<?= $atributo ?>.svg" alt="<?= ucfirst($atributo) ?>" class="w-20 h-20 object-contain rounded-full border-4 
                                                        <?= ($atributo === $atributoFavoritoGuardado) ? 'border-amber-400' : 'border-transparent' ?> hover:border-amber-400 hover:shadow-lg transition duration-300 mx-auto">
                                                    <p class="text-1xl md:text-2xl font-anton text-white mt-2"><?= ucfirst($atributo) ?></p>
                                                </button>
                                            </form>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="h-1 w-full bg-amber-400 rounded animate-pulse my-10 mx-auto"></div>

                                <div class="mt-20 text-center mt-10 mb-20">
                                    <p class="text-2xl md:text-4xl font-anton text-white uppercase mb-4">¿Qué puntuación le das?</p>
                                    <div class="flex justify-center gap-2 text-4xl">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <form method="POST" action="guardar_valoracion.php">
                                            <input type="hidden" name="id_burger" value="<?= htmlspecialchars($burger['id']) ?>">
                                            <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($usuarioId) ?>">
                                            <input type="hidden" name="valoracion" value="<?= $i ?>">
                                            <button type="submit" class="<?= $i <= $valoracionGuardada ? 'text-amber-400' : 'text-gray-400' ?> hover:text-amber-400 transition duration-200">
                                                ★
                                            </button>
                                        </form>
                                    <?php endfor; ?>
                                </div>
                                <div class="h-2 w-full bg-amber-400 rounded animate-pulse my-10 mx-auto"></div>


                                <div class="flex items-center justify-center gap-4 flex-wrap text-center mr-20 mt-20">
                                    <p class="text-2xl md:text-3xl font-anton text-white uppercase mb-8">¿Te equivocaste de burger? 😅</p>
                                    <form method="POST" action="marcar.php" class="inline">
                                        <input type="hidden" name="id_burger" value="<?= htmlspecialchars($burger['id']) ?>">
                                        <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($usuarioId) ?>">
                                        <input type="hidden" name="marcar" value="desmarcar">
                                        <button type="submit" class="text-2xl md:text-3xl font-anton text-amber-400 uppercase mb-8 transition-shadow duration-300 hover:shadow-[0_0_20px_rgba(251,191,36,0.8)]">
                                            Desmarcar como probada
                                        </button>
                                    </form>
                                </div>

                            <?php else: ?>
                                <div class="flex items-center justify-center gap-4 flex-wrap text-center mr-20 mt-20">
                                    <p class="text-2xl md:text-4xl font-anton text-white uppercase mb-8 mr-5">¿Ya la has probado?</p>
                                    <form method="POST" action="marcar.php" class="inline">
                                        <input type="hidden" name="id_burger" value="<?= htmlspecialchars($burger['id']) ?>">
                                        <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($usuarioId) ?>">
                                        <input type="hidden" name="marcar" value="marcar">
                                        <button type="submit" class="text-2xl md:text-4xl font-anton text-amber-400 uppercase mb-8 transition-shadow duration-300 hover:shadow-[0_0_20px_rgba(251,191,36,0.8)]">
                                            Marcar como probada
                                        </button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>

                    <?php else: ?>
                        <!-- Usuario sin sesión -->
                        <div class="mt-6 mx-auto p-6 border border-black bg-neutral-950 rounded-lg text-center shadow-sm">
                            <h3 class="text-2xl font-extrabold text-amber-400 uppercase mb-1">¿Has probado esta burger?</h3>
                            <p class="text-1xl font-extrabold text-white uppercase mb-8">Inicia sesión para marcarla como probada y darle una puntuación.</p>
                            <div class="flex justify-center gap-4">
                                <a href="login.php" class="px-4 py-2 bg-zinc-700 text-white rounded hover:bg-amber-400 hover:text-black transition">Login</a>
                                <a href="registro.php?redirect=<?= $redirect ?>" class="px-4 py-2 bg-zinc-700 text-white rounded hover:bg-amber-400 hover:text-black transition">Registro</a>
                            </div>
                        </div>

                    <?php endif; ?>
                </div>
            </div>
        </main>

        <?php include('components/footer.php'); ?>
        <script>
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', () => {
                    sessionStorage.setItem('scrollPos', window.scrollY);
                });
            });

            // Guardar posición al enviar cualquier formulario
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', () => {
                sessionStorage.setItem('scrollPos', window.scrollY);
                });
            });

            // Al cargar, restaurar scroll si existe
            window.addEventListener('load', () => {
                const scrollPos = sessionStorage.getItem('scrollPos');
                if (scrollPos) {
                    // Primero nos aseguramos que el scroll está arriba
                    window.scrollTo(0, 0);

                    // Luego, tras un pequeño retraso (ejemplo 100ms), hacemos el scroll suave a la posición guardada
                    setTimeout(() => {
                    window.scrollTo({
                        top: parseInt(scrollPos),
                        behavior: 'smooth'
                    });
                    }, 100);

                    // Opcional: limpiamos el storage para la próxima carga
                    sessionStorage.removeItem('scrollPos');
                }
            });
        </script>
    </body>
</html>
