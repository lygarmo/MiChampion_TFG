<?php
    if (!isset($burger) || !isset($alergenos)) return;

    require_once 'Usuario.php';
    require_once 'Hamburguesas.php';
    require_once 'Conexion.php';

    $conexion = new Conexion();
    $db = $conexion->getConexion();

    $usuario = new Usuario($db);
    $hamburguesas = new Hamburguesas($db);

    $email = $_SESSION['email'];
    $usuarioId = $usuario->obtenerIdUsuario($email);

    $burgerId = $burger['id'];

    $yaProbada = $hamburguesas->probada($usuarioId, $burgerId);
?>


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
            <h1 class="text-4xl font-extrabold text-amber-400 uppercase"><?= htmlspecialchars($burger['nombre']) ?></h1>

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

    <div class="w-full">
        <!-- Acciones -->
        <?php if (isset($_SESSION['email'])): ?>
            <!-- Usuario con sesión -->
            <div class="flex mt-8" id="acciones-burger-<?= $burger['id'] ?>">
                <?php if ($yaProbada): ?>
                    <span class="bg-green-100 text-green-800 font-semibold px-4 py-2 rounded-lg flex items-center gap-2">
                        ✅ Ya probada
                    </span>
                    <button class="bg-red-100 text-red-600 font-semibold px-4 py-2 rounded-lg hover:bg-red-200" onclick="desmarcarComoProbada(<?= $burger['id'] ?>)">
                        Eliminar de probadas
                    </button>
                    <!-- Puedes agregar aquí un enlace o botón para valorar -->
                    <a href="valorar.php?burger_id=<?= htmlspecialchars($burger['id']) ?>" class="ml-4 bg-blue-100 text-blue-600 font-semibold px-4 py-2 rounded-lg hover:bg-blue-200">
                        Valorar
                    </a>
                <?php else: ?>
                    <p>¿Ya la has probado?</p>
                    <button class="bg-red-100 text-red-600 font-semibold px-4 py-2 rounded-lg hover:bg-red-200" onclick="function marcarComoProbada(burgerId) {(<?= $burger['id'] ?>)">
                        Marcar como probada
                    </button>
                <?php endif; ?>
            </div>

        <?php else: ?>
            <!-- Usuario sin sesión -->
            <div class="mt-6 mx-auto p-6 border border-black bg-neutral-950 rounded-lg text-center shadow-sm">
                <h3 class="text-2xl font-extrabold text-amber-400 uppercase mb-1">¿Has probado esta burger?</h3>
                <p class="text-1xl font-extrabold text-white uppercase mb-8">Inicia sesión para marcarla como probada y darle una puntuación.</p>
                <div class="flex justify-center gap-4">
                    <a href="login.php" class="px-4 py-2 bg-zinc-700 text-white rounded hover:bg-amber-400 hover:text-black transition">Login</a>
                    <a href="registro.php" class="px-4 py-2 bg-zinc-700 text-white rounded hover:bg-amber-400 hover:text-black transition">Registro</a>
                </div>
            </div>

        <?php endif; ?>
    </div>
</div>

<script>
function marcarComoProbada(burgerId) {
    fetch('acciones/marcar_como_probada.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ burger_id: burgerId })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success && data.html){
            document.getElementById('acciones-burger-' + burgerId).innerHTML = data.html;
        } else {
            alert(data.error || 'Error al marcar como probada');
        }
    })
    .catch(() => alert('Error de conexión'));
}

function desmarcarComoProbada(burgerId) {
    fetch('acciones/desmarcar_como_probada.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ burger_id: burgerId })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success && data.html){
            document.getElementById('acciones-burger-' + burgerId).innerHTML = data.html;
        } else {
            alert(data.error || 'Error al desmarcar como probada');
        }
    })
    .catch(() => alert('Error de conexión'));
}
</script>
