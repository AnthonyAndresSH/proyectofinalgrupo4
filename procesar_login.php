<?php
// procesar_login.php

// Verificar si se enviaron datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $usuario = $_POST["usuario"];
    $contrasena = $_POST["contrasena"];
    $rol = $_POST["rol"];

    // Aquí deberías realizar la autenticación con la base de datos
    // y asegurarte de implementar medidas de seguridad adecuadas
    
    // Por ahora, solo verificaré un usuario de ejemplo
    $usuarioEjemplo = "admin";
    $contrasenaEjemplo = "admin123";
    
    //if ($usuario == $usuarioEjemplo && $contrasena == $contrasenaEjemplo) {
        // Autenticación exitosa, redirigir según el rol
        if ($rol == "Administrador") {
            header("Location: startadmin.php");
            exit();
        } elseif ($rol == "Jugador") {
            header("Location: startplayer.php");
            exit();
        }
    /*} else {
        // Autenticación fallida, puedes manejar esto según tus necesidades
        echo "Autenticación fallida. Usuario o contraseña incorrectos.";
    }*/
} else {
    // Si no se envió el formulario correctamente, redirigir a index.php
    header("Location: index.php");
    exit();
}
?>
