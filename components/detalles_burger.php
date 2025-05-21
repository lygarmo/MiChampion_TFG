<?php
    if (!isset($burger) || !isset($alergenos)) return;
?>

<div class="bg-neutral-800 rounded-xl shadow-xl text-white mt-8 p-8 max-w-6xl mx-auto flex flex-col lg:flex-row gap-10">
    
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
                        <span class="bg-black rounded-full p-1" title="<?= htmlspecialchars($alergeno['nombre']) ?>">
                            <img src="public/<?= htmlspecialchars($alergeno['icono']) ?>" alt="<?= htmlspecialchars($alergeno['nombre']) ?>" class="h-5 w-5 object-contain">
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Acciones -->
        <?php if (isset($_SESSION['email'])): ?>
            <div class="flex gap-4 mt-4">
                <!-- Ejemplo de ya marcada -->
                <span class="bg-green-100 text-green-800 font-semibold px-4 py-2 rounded-lg flex items-center gap-2">
                    ✅ Ya probada
                </span>
                <form action="acciones/quitar_de_probadas.php" method="POST">
                    <input type="hidden" name="burger_id" value="<?= htmlspecialchars($burger['id']) ?>">
                    <button type="submit" class="bg-red-100 text-red-600 font-semibold px-4 py-2 rounded-lg hover:bg-red-200">
                        Desmarcar
                    </button>
                </form>
            </div>
        <?php endif; ?>

        <!-- Valoración (ejemplo simple de estrellas) -->
        <div class="flex items-center mt-6 text-yellow-500 text-2xl">
            ★☆☆☆☆
        </div>
    </div>
</div>
