<?php

    session_start(); 
    require_once 'Conexion.php';
    require_once 'Usuario.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $conexion = new Conexion();
        $db = $conexion->getConexion();

        $usuario = new Usuario($db);

        $datos = compact('nombre', 'apellidos', 'email'); // Para repintar el formulario

        if ($usuario->existeUsuario($email)) {
            // Mostrar de nuevo el formulario con mensaje de error
            $this->mostrarFormulario('Ya hay un usuario registrado con ese email', $datos);
        } else {
            // Insertar usuario, iniciar sesión y redirigir
            $usuario->insertarUsuario($nombre, $apellidos, $email, $password);

            $_SESSION['usuario_email'] = $email;

            // Redirigir a inicio.php
            header('Location: /src/Views/inicio.php');
            exit;
        }
    } else {
         $this->mostrarFormulario();
    }