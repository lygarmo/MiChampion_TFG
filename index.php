<?php
   session_start();
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Mi Champion</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="icon" href="/MiChampion_TFG/public/michampion_logo.png" type="image/png">
    </head>

    <body class="bg-neutral-800">
        <!-- Incluir el header -->
        <?php include('components/header.php'); ?>

        <!-- Incluir el contenido principal -->
        <?php include('components/main.php'); ?>

        <!-- Incluir el footer -->
        <?php include('components/footer.php'); ?>

    </body>
    <script>
    // Selecciona todos los botones con la clase 'accordion-btn'
    const buttons = document.querySelectorAll('.accordion-btn');

    // Añade el evento de click a cada botón
    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            const content = btn.nextElementSibling;
            const icon = btn.querySelector('svg');

            // Alterna la visibilidad del contenido y la rotación del icono
            content.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        });
    });
</script>

</html>

