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
        $atributo_favorito = $_POST['atributo_favorito'];
    }

    $atributo=$hamburguesas->guardarAtributoFavorito($id_usuario, $id_burger, $atributo_favorito);

    header("Location: detalle_burger.php?id=$id_burger");
    exit;
?>