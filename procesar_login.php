<?php

    session_start();
    require_once 'Conexion.php';
    require_once 'Usuario.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

    }

    $datos = [
        'email' => $email,
        'password' => $password
    ];

    // Validar campos vacíos
if (empty($email) || empty($password)) {
    $mensaje = "Todos los campos son obligatorios.";
} else {
    // Crear conexión y objeto Usuario
    $conexion = new Conexion();
    $db = $conexion->getConexion();
    $usuario = new Usuario($db);

    // Autenticar usuario
    $resultado = $usuario->autenticarUsuario($email, $password);

    if ($resultado) {
        $_SESSION['email'] = $resultado['email'];

        if (isset($_SESSION['redirect_after_login'])) {
            $redirect = $_SESSION['redirect_after_login'];
            unset($_SESSION['redirect_after_login']);
            header("Location: $redirect");
        } else {
            header("Location: panel_inicio.php"); // por defecto
        }
    } else {
        // Credenciales incorrectas
        $mensaje = "Email o contraseña incorrectos.";
    }
}

// Mostrar el formulario nuevamente si hubo error
include 'login.php';
