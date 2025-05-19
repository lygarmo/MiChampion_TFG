<?php
    session_start();
    if (!isset($_SESSION['email'])) {
        // No hay sesión con email, redirigir a index.php
        header('Location: index.php');
        exit();
    } 
    require_once 'Hamburguesas.php';
    require_once 'Conexion.php';
    require_once 'Usuario.php';
    $conexion = new Conexion();
    $db = $conexion->getConexion();
    $hamburguesa = new Hamburguesas($db);
    $usuario = new Usuario($db);

    // Obtener id usuario
    $emailUsuario = $_SESSION['email'];
    $idUsuario = $usuario->obtenerIdUsuario($emailUsuario);
    $nombreUsuario = $usuario->obtenerNombre($emailUsuario);

    // Inicializar contadores
    $burgers_probadas = 0;
    $burgers_totales = 0;

    if ($idUsuario !== null) {
        // Hhamburguesas probadas
        $burgers_probadas = $hamburguesa->contarBurgersProbadasPorUsuario($idUsuario);
        // Hamburguesas totales
        $burgers_totales = $hamburguesa->contarTotalBurgers();
    }

    $burgers_destacadas = $hamburguesa->obtenerBurgersDestacadas();
    
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Mi Champion - Inicio</title>
        <script src="https://cdn.tailwindcss.com"></script>

        <style>
            header {
                position: fixed;
                top: 0;
                width: 100%;
                height: 80px;
                z-index: 1000;
            }
            main {
                padding-top: 150px;
            }
        </style>
    </head>

    <body class="bg-neutral-800">
        <!-- Incluir el header -->
        <?php include('components/header_sesion.php'); ?>


    <main>

  <!-- Sección de estadísticas del usuario -->
  <section class="bg-neutral-900 text-[#efece3] py-16 px-6 md:px-20">
    <div class="max-w-7xl mx-auto">
        <!-- Saludo -->
        <h2 class="text-3xl md:text-5xl font-anton uppercase mb-8">
            Hola, <?php echo htmlspecialchars($nombreUsuario); ?>! <br>Estas son tus estadísticas:
        </h2>

        <!-- Contadores -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
            <!-- Hamburguesas probadas -->
            <div class="bg-neutral-800 rounded-2xl p-8 shadow-lg text-center">
                <h3 class="text-xl md:text-2xl uppercase font-anton mb-4">Hamburguesas Probadas</h3>
                <p class="text-6xl font-bold text-amber-400">
                    <?php echo $burgers_probadas; ?>
                </p>
            </div>

            <!-- Total de hamburguesas -->
            <div class="bg-neutral-800 rounded-2xl p-8 shadow-lg text-center">
                <h3 class="text-xl md:text-2xl uppercase font-anton mb-4">Total Hamburguesas</h3>
                <p class="text-6xl font-bold text-amber-400">
                    <?php echo $burgers_totales; ?>
                </p>
            </div>
        </div>
    </div>
  </section>

  <hr class="border-white border-t w-full mx-auto">

  <!-- Imagen y texto -->
  <section class="bg-neutral-900 text-white py-16 px-6 max-w-7xl mx-auto">
  <h2 class="text-3xl font-bold mb-8 text-amber-400 text-center">Hamburguesas Destacadas</h2>
  
  <div id="carousel" class="relative overflow-hidden">
    <div id="slides" class="flex transition-transform duration-500">
      <?php foreach ($burgers_destacadas as $burger): ?>
        <div class="min-w-full flex gap-6">
          <!-- Izquierda: foto -->
          <div class="flex-1">
            <img src="<?php echo htmlspecialchars($burger['foto']); ?>" alt="<?php echo htmlspecialchars($burger['nombre']); ?>" class="rounded-lg w-full h-auto object-cover">
          </div>

          <!-- Derecha: logo, nombre, descripción, alérgenos -->
          <div class="flex-1 flex flex-col justify-center space-y-4">
            <div class="flex items-center gap-4">
              <img src="<?php echo htmlspecialchars($burger['logo']); ?>" alt="Logo <?php echo htmlspecialchars($burger['nombre']); ?>" class="h-12 object-contain">
              <h3 class="text-3xl font-bold text-amber-400"><?php echo htmlspecialchars($burger['nombre']); ?></h3>
            </div>
            <p class="text-gray-300"><?php echo htmlspecialchars($burger['descripcion']); ?></p>
            <div>
              <p class="text-sm uppercase font-semibold mb-1">Alérgenos:</p>
              <div class="flex flex-wrap gap-2">
                <?php foreach ($burger['alergenos'] as $alergeno): ?>
                  <span class="bg-red-600 text-white text-xs px-2 py-1 rounded-full"><?php echo htmlspecialchars($alergeno); ?></span>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Botones -->
    <button id="prev" class="absolute top-1/2 left-2 -translate-y-1/2 bg-amber-400 text-neutral-900 rounded-full p-2 shadow-lg hover:bg-amber-500">
      &#10094;
    </button>
    <button id="next" class="absolute top-1/2 right-2 -translate-y-1/2 bg-amber-400 text-neutral-900 rounded-full p-2 shadow-lg hover:bg-amber-500">
      &#10095;
    </button>
  </div>
</section>

  <hr class="border-white border-t w-full mx-auto">

  <!-- Resto de secciones (Patrocinadores, galería, ubicación, catálogo, etc.) -->

</main>


        <!-- Incluir el footer -->
        <?php include('components/footer_sesion.php'); ?>

    </body>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const button = document.getElementById('menuButton');
                const dropdown = document.getElementById('menuDropdown');

                button.addEventListener('click', () => {
                    dropdown.classList.toggle('hidden');
                });

                document.addEventListener('click', (e) => {
                    if (!button.contains(e.target) && !dropdown.contains(e.target)) {
                        dropdown.classList.add('hidden');
                    }
                });
            });
        </script>
</html>

