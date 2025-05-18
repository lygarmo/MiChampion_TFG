<?php
    session_start();
    if (!isset($_SESSION['email'])) {
        // No hay sesión con email, redirigir a index.php
        header('Location: index.php');
        exit();
    } 
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Mi Champion - Inicio</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>

    <body class="bg-neutral-800">
        <!-- Incluir el header -->
        <?php include('components/header_sesion.php'); ?>

        <!-- Incluir el main -->
        <?php include('components/main_sesion.php'); ?>

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

