<?php

    session_start(); 
    require_once 'Conexion.php';
    require_once 'Usuario.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $email = $_POST['email'];
        $password = $_POST['password'];

    }
    

    $datos = [
        'nombre' => $nombre,
        'apellidos' => $apellidos,
        'email' => $email
    ];

    // Validar campos vacíos
    if (empty($nombre) || empty($apellidos) || empty($email) || empty($password)) {
        $mensaje = "Todos los campos son obligatorios.";
    } else {
        // Crear conexión y objeto Usuario
        $conexion = new Conexion();
        $db = $conexion->getConexion();
        $usuario = new Usuario($db);

        // Comprobar si el usuario ya existe
        if ($usuario->existeUsuario($email)) {
            $mensaje = "El correo ya está registrado.";
        } else {
            // Insertar el usuario
            $usuario->insertarUsuario($nombre, $apellidos, $email, $password);

            // iniciar sesión automáticamente
            $_SESSION['email'] = $email;
            if (isset($_SESSION['redirect_after_login'])) {
                $redirect = $_SESSION['redirect_after_login'];
                unset($_SESSION['redirect_after_login']);
                header("Location: $redirect");
            } else {
                header("Location: panel_inicio.php"); // por defecto
            }
        }
    }

// Mostrar el formulario nuevamente si hubo error
include 'registro.php';
