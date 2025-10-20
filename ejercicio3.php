<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}

// Variables
$lado1 = $lado2 = $lado3 = "";
$tipo_triangulo = "";
$error = "";
$clase_resultado = "";

// Procesar formulario
if (isset($_POST['clasificar'])) {
    $lado1 = $_POST['lado1'] ?? '';
    $lado2 = $_POST['lado2'] ?? '';
    $lado3 = $_POST['lado3'] ?? '';
    
    // Validaciones básicas
    if (empty($lado1) || empty($lado2) || empty($lado3)) {
        $error = "❌ Por favor, complete todos los campos";
    } elseif (!is_numeric($lado1) || !is_numeric($lado2) || !is_numeric($lado3)) {
        $error = "❌ Todos los valores deben ser números válidos";
    } elseif ($lado1 <= 0 || $lado2 <= 0 || $lado3 <= 0) {
        $error = "❌ Los lados deben ser números positivos mayores a cero";
    } else {
        // Verificar desigualdad triangular
        if (($lado1 + $lado2 <= $lado3) || 
            ($lado1 + $lado3 <= $lado2) || 
            ($lado2 + $lado3 <= $lado1)) {
            $error = "⚠️ No cumple la desigualdad triangular. La suma de dos lados debe ser mayor al tercero";
        } else {
            // Clasificar el triángulo
            if ($lado1 == $lado2 && $lado2 == $lado3) {
                $tipo_triangulo = "Equilátero";
                $clase_resultado = "equilatero";
            } elseif ($lado1 == $lado2 || $lado1 == $lado3 || $lado2 == $lado3) {
                $tipo_triangulo = "Isósceles";
                $clase_resultado = "isosceles";
            } else {
                $tipo_triangulo = "Escaleno";
                $clase_resultado = "escaleno";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 3: Clasificación de Triángulos</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }
        
        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 10px;
            font-size: 2.5em;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }
        
        .subtitle {
            text-align: center;
            color: #7f8c8d;
            margin-bottom: 30px;
            font-size: 1.1em;
        }
        
        .calculator {
            background: linear-gradient(145deg, #ffffff, #f8f9fa);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #34495e;
            font-size: 1.1em;
        }
        
        .input-with-icon {
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .input-icon {
            position: absolute;
            left: 15px;
            color: #3498db;
            font-size: 1.2em;
        }
        
        input[type="number"] {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #fafafa;
        }
        
        input[type="number"]:focus {
            outline: none;
            border-color: #3498db;
            background: white;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
            transform: translateY(-2px);
        }
        
        button {
            background: linear-gradient(135deg, #9b59b6, #8e44ad);
            color: white;
            padding: 16px 30px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            width: 100%;
            font-size: 18px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(155, 89, 182, 0.3);
            margin-top: 10px;
        }
        
        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(155, 89, 182, 0.4);
        }
        
        .error {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
        }
        
        .result-container {
            text-align: center;
            padding: 30px;
            border-radius: 15px;
            margin-top: 20px;
            transition: all 0.5s ease;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        
        .result-container.equilatero {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            color: white;
        }
        
        .result-container.isosceles {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
        }
        
        .result-container.escaleno {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
        }
        
        .result-icon {
            font-size: 4em;
            margin-bottom: 15px;
        }
        
        .result-title {
            font-size: 2em;
            margin-bottom: 10px;
            font-weight: 700;
        }
        
        .result-subtitle {
            font-size: 1.2em;
            opacity: 0.9;
        }
        
        .triangle-visual {
            width: 120px;
            height: 120px;
            margin: 20px auto;
            background: rgba(255,255,255,0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2em;
        }
        
        .back-btn {
            display: inline-block;
            background: linear-gradient(135deg, #95a5a6, #7f8c8d);
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 8px;
            margin-top: 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(149, 165, 166, 0.3);
        }
        
        .back-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(149, 165, 166, 0.4);
            text-decoration: none;
            color: white;
        }
        
        .info-box {
            background: linear-gradient(135deg, #f39c12, #e67e22);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            text-align: center;
        }
        
        .info-title {
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 1.1em;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            
            h1 {
                font-size: 2em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔺 Clasificación de Triángulos</h1>
        <p class="subtitle">Ingresa los tres lados para clasificar el tipo de triángulo</p>
        
        <div class="calculator">
            <?php if ($error): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="lado1">Lado 1:</label>
                    <div class="input-with-icon">
                        <span class="input-icon">📏</span>
                        <input type="number" id="lado1" name="lado1" step="0.01" min="0.01" required 
                               value="<?php echo htmlspecialchars($lado1); ?>" 
                               placeholder="Ingrese la longitud del primer lado">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="lado2">Lado 2:</label>
                    <div class="input-with-icon">
                        <span class="input-icon">📐</span>
                        <input type="number" id="lado2" name="lado2" step="0.01" min="0.01" required 
                               value="<?php echo htmlspecialchars($lado2); ?>" 
                               placeholder="Ingrese la longitud del segundo lado">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="lado3">Lado 3:</label>
                    <div class="input-with-icon">
                        <span class="input-icon">🔺</span>
                        <input type="number" id="lado3" name="lado3" step="0.01" min="0.01" required 
                               value="<?php echo htmlspecialchars($lado3); ?>" 
                               placeholder="Ingrese la longitud del tercer lado">
                    </div>
                </div>
                
                <button type="submit" name="clasificar">🔍 Clasificar Triángulo</button>
            </form>
        </div>
        
        <?php if ($tipo_triangulo): ?>
            <div class="result-container <?php echo $clase_resultado; ?>">
                <div class="result-icon">
                    <?php 
                    if ($clase_resultado == 'equilatero') echo '▲';
                    elseif ($clase_resultado == 'isosceles') echo '△';
                    else echo '🔺';
                    ?>
                </div>
                <div class="result-title"><?php echo $tipo_triangulo; ?></div>
                <div class="result-subtitle">
                    <?php 
                    if ($clase_resultado == 'equilatero') {
                        echo "Todos los lados son iguales";
                    } elseif ($clase_resultado == 'isosceles') {
                        echo "Dos lados son iguales";
                    } else {
                        echo "Todos los lados son diferentes";
                    }
                    ?>
                </div>
                <div class="triangle-visual">
                    Lados: <?php echo number_format($lado1, 2); ?>, <?php echo number_format($lado2, 2); ?>, <?php echo number_format($lado3, 2); ?>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="info-box">
            <div class="info-title">💡 Información sobre triángulos</div>
            <p><strong>Equilátero:</strong> 3 lados iguales | <strong>Isósceles:</strong> 2 lados iguales | <strong>Escaleno:</strong> 0 lados iguales</p>
        </div>
        
        <div style="text-align: center;">
            <a href="dashboard.php" class="back-btn">← Volver al Dashboard</a>
        </div>
    </div>
</body>
</html>