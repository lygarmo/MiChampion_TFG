<?php
    if (!isset($burger) || !isset($alergenos)) return;
    $alergenos = $alergenosPorBurger[$burger['id']] ?? [];
?>

<a href="detalle_burger.php?id=<?= htmlspecialchars($burger['id']) ?>" class="bg-gray-900 rounded-xl overflow-hidden shadow-lg hover:shadow-amber-400 transition-shadow">
    <div class="flex justify-center items-center p-4">
        <img src="public/<?= $burger['logo'] ?>" alt="Logo <?= htmlspecialchars($burger['restaurante']) ?>" class="h-12 object-contain">
    </div>
    <img src="public/<?= $burger['imagen'] ?>" alt="<?= $burger['nombre'] ?>" class="w-full h-48 object-cover">
    <div class="p-4 space-y-2">
        <h3 class="text-xl font-bold text-amber-400"><?= htmlspecialchars($burger['nombre']) ?></h3>
        <p class="text-sm text-gray-300"><?= htmlspecialchars($burger['descripcion']) ?></p>
        <?php if (!empty($alergenos)): ?>
            <div class="mt-2">
                <p class="text-xs text-gray-400 uppercase mb-1">Alérgenos:</p>
                <div class="flex flex-wrap gap-2">
                    <?php foreach ($alergenos as $alergeno): ?>
                        <span class="bg-black rounded-full p-1" title="<?= htmlspecialchars($alergeno['nombre']) ?>">
                            <img src="public/<?= htmlspecialchars($alergeno['icono']) ?>" alt="<?= htmlspecialchars($alergeno['nombre']) ?>" class="h-5 w-5 object-contain">
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</a>
