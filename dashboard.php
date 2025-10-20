<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Principal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .dashboard-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .welcome {
            color: #333;
            margin-bottom: 20px;
        }
        .logout-btn {
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }
        .logout-btn:hover {
            background-color: #c82333;
        }
        .features {
            margin-top: 30px;
        }
        .feature-item {
            background: #f8f9fa;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            border-left: 4px solid #007bff;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1 class="welcome">¡Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</h1>
        
        <div class="features">
            <h2>Panel de Control</h2>
            <div class="feature-item">
                <h3>Estadísticas</h3>
                <p>Aquí puedes ver tus estadísticas de ejercicios.</p>
            </div>
            <div class="feature-item">
                <h3>Progreso</h3>
                <p>Revisa tu progreso en los entrenamientos.</p>
            </div>
            <div class="feature-item">
                <h3>Rutinas</h3>
                <p>Gestiona tus rutinas de ejercicios.</p>
            </div>
        </div>
        
        <a href="logout.php" class="logout-btn">Cerrar Sesión</a>
    </div>
</body>
</html>