<?php
    function renderBurgerCard($id, $nombre, $descripcion, $imagen_url, $logo_url, $alergenos = []) {
?>
    <a href="burger.php?id=<?= $id ?>" class="bg-gray-900 rounded-xl overflow-hidden shadow-lg hover:shadow-amber-400 transition-shadow">
        <div class="bg-white flex justify-center items-center p-4">
            <img src="<?= $logo_url ?>" alt="Logo <?= htmlspecialchars($nombre) ?>" class="h-12 object-contain">
        </div>
        <img src="<?= $imagen_url ?>" alt="<?= htmlspecialchars($nombre) ?>" class="w-full h-48 object-cover">
        <div class="p-4 space-y-2">
            <h3 class="text-xl font-bold text-amber-400"><?= htmlspecialchars($nombre) ?></h3>
            <p class="text-sm text-gray-300"><?= htmlspecialchars($descripcion) ?></p>
            <?php if (!empty($alergenos)): ?>
                <div class="mt-2">
                    <p class="text-xs text-gray-400 uppercase mb-1">Alérgenos:</p>
                    <div class="flex flex-wrap gap-2">
                        <?php foreach ($alergenos as $alergeno): ?>
                            <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full"><?= htmlspecialchars($alergeno) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </a>
<?php   
    }   
?>
