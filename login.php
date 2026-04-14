<?php
    require_once 'config.php';

    $error = '';

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // VULNERABILIDAD 2 y 3 : SQL injection y Comparacion MD5 directa
        $query = "SELECT * FROM users WHERE email = '$email' 
                    AND password = '" . md5($password) . "'";
        $resul = pg_query($conn, $query);

        if($resul && pg_num_rows($resul) > 0 ) {
            $user = pg_fetch_assoc($resul);
            // VULNERABILIDAD 4: Sin session_regenarate_id()
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nombre'] = $user['nombre'];
            $_SESSION['user_email'] = $user['email'];
            header('Location: notas/index.php');
            exit;
        } else {
            $error = 'Credenciales incorrectas.';
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Insecure Notes</title>
</head>
<body>
    <h1>Iniciar sesión</h1>
    <?php if($error): ?>
        <p><?php echo $error ?></p>
    <?php endif; ?>
    <form method="POST">
        <label>E-Mail:</label>
        <input type="email" name="email" required>
        <label>Contraseña:</label>
        <input type="password" name="password" required>
        <button type="submit">Ingresar</button>
    </form>
    <p>No tienes una cuenta? <a href="registro.php">Regístrate</a></p>
</body>
</html>