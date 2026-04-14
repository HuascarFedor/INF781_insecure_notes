<?php
    // VULNERABILIDAD 1: display_errors activado - expone rutas y datos internos
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // VULNERABILIDAD 4: configuracion insegura de sesiones
    ini_set('session.cookie_httponly', 0); // JS puede leer la cookie
    ini_set('session.cookie_samesite', ''); // Sin restriccion de origen
    ini_set('session.cookie_secure', 0); // Funciona sin HTTPS
    ini_set('session.use_strict_mode', 0); // Acepta IDs arbitrarios

    session_start();

    // VULNERABILIDAD 1: credenciales hardcodeadas directamente en el codigo
    $db_host = 'localhost';
    $db_name = 'insecure_notes';
    $db_user = 'postgres';
    $db_pass = '';

    $conn = pg_connect("host=$db_host dbname=$db_name user=$db_user password=$db_pass");

    if(!$conn) {
        // Muestra el error completo sin filter
        die("Error de conexion: " . pg_last_error());
    }
?>