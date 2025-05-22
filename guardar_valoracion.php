<?php
    session_start();

    require_once 'Conexion.php';
    require_once 'Hamburguesas.php';

    $conexion = new Conexion();
    $db = $conexion->getConexion();
    $hamburguesas = new Hamburguesas($db);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_burger = $_POST['id_burger'];
        $id_usuario = $_POST['id_usuario'];
        $valoracion = $_POST['valoracion'];
    }

    $valoracion=$hamburguesas->guardarValoracion($id_usuario, $id_burger, $valoracion);

    header("Location: detalle_burger.php?id=$id_burger");
    exit;
?>