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
        // Usuario autenticado correctamente
        $_SESSION['email'] = $resultado['email'];
        header('Location: panel_inicio.php');
        exit();
    } else {
        // Credenciales incorrectas
        $mensaje = "Email o contraseña incorrectos.";
    }
}

// Mostrar el formulario nuevamente si hubo error
include 'login.php';
