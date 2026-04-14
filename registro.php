<?php
    require_once 'config.php';

    $error = '';
    $exito = '';

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // VULNERABILIDAD 3 : Hash MD5 sin salt - inseguro
        $hash = md5($password);

        // VULNERABILIDAD 2 : Concatenacion directa - inyeccion SQL
        $query = "INSERT INTO users(nombre, email, password) 
                    VALUES('$nombre', '$email', '$hash')";
        $resul = pg_query($conn, $query);

        if($resul) {
            $exito = 'Usuario registrado. Ahora puedes iniciar sesion.';
        } else {
            // VULNERABILIDAD 1: Error completo expuesto al usuario
            $error = 'Error al registrarse: ' . preg_last_error($conn);
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Insecure Notes</title>
</head>
<body>
    <h1>Registro</h1>
    <?php if($error): ?>
        <p><?php echo $error ?></p>
    <?php endif; ?>
    <?php if($exito): ?>
        <p><?php echo $exito ?></p>
    <?php endif; ?> 
    <form method="POST">
        <label>Nombre:</label>
        <input type="text" name="nombre" required>
        <label>E-Mail:</label>
        <input type="email" name="email" required>
        <label>Contraseña:</label>
        <input type="password" name="password" required>
        <button type="submit">Ingresar</button>
    </form>
    <p>Ya tienes una cuenta? <a href="login.php">Inicia sesión</a></p>
</body>
</html>