<?php
session_start();
// Credenciales definidas en el código
$usuario_valido = "admin";
$password_valido = "123456";

if ($_POST) {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    
    if ($usuario === $usuario_valido && $password === $password_valido) {
        $_SESSION['loggedin'] = true;
        $_SESSION['usuario'] = $usuario;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
            width: 300px;
        }
        .login-image {
            max-width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="assets/ejercicios.jpg" alt="Imagen de ejercicios" class="login-image">
        <h2>Iniciar Sesión</h2>
        
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <input type="text" name="usuario" placeholder="Usuario" required value="<?php echo isset($_POST['usuario']) ? $_POST['usuario'] : ''; ?>">
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Ingresar</button>
        </form>
        
        <p style="margin-top: 15px; font-size: 12px; color: #666;">
            Usuario: admin | Contraseña: 123456
        </p>
    </div>
</body>
</html>