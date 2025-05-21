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
    $alergenos_por_burger = $hamburguesa->obtenerAlergenosDeTodasLasBurgers();

    
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
    <div id="slides" class="flex transition-transform ease-in-out duration-700 w-full">
      <?php foreach ($burgers_destacadas as $burger): ?>
        <div class="min-w-full flex gap-6 slide">
          <!-- Izquierda: foto -->
          <div class="flex-1 ml-10">
            <img src="public/<?= $burger['imagen'] ?>" alt="<?php echo htmlspecialchars($burger['nombre']); ?>" class="rounded-lg w-full h-auto object-cover">
          </div>
        
          <!-- Derecha: logo, nombre, descripción, alérgenos -->
          <div class="flex-1 flex mr-8 flex-col justify-center space-y-4">
            <div class="flex items-center gap-4">
              <img src="public/<?= $burger['logo'] ?>" alt="Logo <?php echo htmlspecialchars($burger['nombre']); ?>" class="h-12 object-contain">
              <h3 class="text-3xl font-bold text-amber-400"><?php echo htmlspecialchars($burger['nombre']); ?></h3>
            </div>
            <p class="text-gray-300"><?php echo htmlspecialchars($burger['descripcion']); ?></p>
            <div>
              <p class="text-sm uppercase font-semibold mb-1">Alérgenos:</p>
              <div class="flex flex-wrap gap-2">
                <?php if (isset($alergenos_por_burger[$burger['id']])): ?>
                  <?php foreach ($alergenos_por_burger[$burger['id']] as $alergeno): ?>
                    <div class="flex items-center gap-1 bg-grey ext-white text-xs px-2 py-1 rounded-full">
                      <img src="public/<?= htmlspecialchars($alergeno['icono']) ?>" alt="<?= htmlspecialchars($alergeno['nombre']) ?>" class="h-4 w-4">
                      <?= htmlspecialchars($alergeno['nombre']) ?>
                    </div>
                  <?php endforeach; ?>
                <?php else: ?>
                  <span class="text-gray-400 text-sm">Sin alérgenos registrados</span>
                <?php endif; ?>
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
    const slidesContainer = document.getElementById('slides');
    const slideElements = slidesContainer.children;
    const totalSlides = slideElements.length;
    const slideWidth = slideElements[0].clientWidth;

    let currentIndex = 0;
    let isTransitioning = false;

    function goToSlide(index, animate = true) {
      if (animate) {
        slidesContainer.style.transition = 'transform 0.7s ease-in-out';
      } else {
        slidesContainer.style.transition = 'none';
      }

      slidesContainer.style.transform = `translateX(-${index * 100}%)`;
    }

    function nextSlide() {
      if (isTransitioning) return;
      isTransitioning = true;

      currentIndex++;

      if (currentIndex < totalSlides) {
        goToSlide(currentIndex);
        setTimeout(() => {
          isTransitioning = false;
        }, 700);
      } else {
        // Animar hasta el final
        goToSlide(currentIndex);
        setTimeout(() => {
          // Sin animación, saltar al inicio
          currentIndex = 0;
          goToSlide(currentIndex, false);
          isTransitioning = false;
        }, 700);
      }
    }

    // Botones manuales
    document.getElementById('next').addEventListener('click', () => {
      nextSlide();
      restartAutoSlide();
    });

    document.getElementById('prev').addEventListener('click', () => {
      if (isTransitioning) return;
      isTransitioning = true;

      if (currentIndex === 0) {
        currentIndex = totalSlides - 1;
        goToSlide(currentIndex, false);
        setTimeout(() => {
          goToSlide(currentIndex);
          setTimeout(() => isTransitioning = false, 700);
        }, 20);
      } else {
        currentIndex--;
        goToSlide(currentIndex);
        setTimeout(() => isTransitioning = false, 700);
      }

      restartAutoSlide();
    });

    // Auto slide
    let interval = setInterval(nextSlide, 3000);

    function restartAutoSlide() {
      clearInterval(interval);
      interval = setInterval(nextSlide, 5000);
    }

    // Iniciar
    goToSlide(currentIndex);
  });
</script>


</html>

