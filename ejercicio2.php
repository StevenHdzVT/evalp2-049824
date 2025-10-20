<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}

// Variables para cilindro
$area_cilindro = $volumen_cilindro = "";
$radio = $altura_cilindro = "";
$error_cilindro = "";

// Variables para rectángulo
$area_rectangulo = $perimetro_rectangulo = "";
$base = $altura_rectangulo = "";
$error_rectangulo = "";

// Procesar formulario CILINDRO
if (isset($_POST['calcular_cilindro'])) {
    $radio = $_POST['radio'] ?? '';
    $altura_cilindro = $_POST['altura_cilindro'] ?? '';
    
    if (empty($radio) || empty($altura_cilindro)) {
        $error_cilindro = "Por favor, complete todos los campos del cilindro";
    } elseif (!is_numeric($radio) || !is_numeric($altura_cilindro) || $radio <= 0 || $altura_cilindro <= 0) {
        $error_cilindro = "Los valores deben ser números positivos";
    } else {
        // Cálculos del cilindro
        $area_base = M_PI * pow($radio, 2);
        $area_lateral = 2 * M_PI * $radio * $altura_cilindro;
        $area_cilindro = 2 * $area_base + $area_lateral;
        $volumen_cilindro = $area_base * $altura_cilindro;
        
        $area_cilindro = number_format($area_cilindro, 2);
        $volumen_cilindro = number_format($volumen_cilindro, 2);
    }
}

// Procesar formulario RECTÁNGULO
if (isset($_POST['calcular_rectangulo'])) {
    $base = $_POST['base'] ?? '';
    $altura_rectangulo = $_POST['altura_rectangulo'] ?? '';
    
    if (empty($base) || empty($altura_rectangulo)) {
        $error_rectangulo = "Por favor, complete todos los campos del rectángulo";
    } elseif (!is_numeric($base) || !is_numeric($altura_rectangulo) || $base <= 0 || $altura_rectangulo <= 0) {
        $error_rectangulo = "Los valores deben ser números positivos";
    } else {
        // Cálculos del rectángulo
        $area_rectangulo = $base * $altura_rectangulo;
        $perimetro_rectangulo = 2 * ($base + $altura_rectangulo);
        
        $area_rectangulo = number_format($area_rectangulo, 2);
        $perimetro_rectangulo = number_format($perimetro_rectangulo, 2);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 2: Cálculos Geométricos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #17a2b8;
            text-align: center;
            margin-bottom: 30px;
        }
        .calculators {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        .calculator {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-top: 4px solid #17a2b8;
        }
        .calculator.rectangulo {
            border-top-color: #ffc107;
        }
        h2 {
            color: #333;
            margin-top: 0;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="number"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #17a2b8;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        button.rectangulo-btn {
            background-color: #ffc107;
            color: #212529;
        }
        button:hover {
            opacity: 0.9;
        }
        .result {
            background-color: #e9f7fe;
            padding: 12px;
            border-radius: 4px;
            margin-top: 15px;
            font-size: 14px;
        }
        .result.rectangulo {
            background-color: #fff3cd;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 8px;
            border-radius: 4px;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .back-btn {
            display: inline-block;
            background-color: #6c757d;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .back-btn:hover {
            background-color: #5a6268;
        }
        @media (max-width: 768px) {
            .calculators {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Ejercicio 2: Cálculos Geométricos</h1>
        
        <div class="calculators">
            <!-- CALCULADORA DE CILINDRO -->
            <div class="calculator">
                <h2>Cálculo de Cilindro</h2>
                
                <?php if ($error_cilindro): ?>
                    <div class="error"><?php echo $error_cilindro; ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="form-group">
                        <label for="radio">Radio (cm):</label>
                        <input type="number" id="radio" name="radio" step="0.01" min="0.01" required 
                               value="<?php echo htmlspecialchars($radio); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="altura_cilindro">Altura (cm):</label>
                        <input type="number" id="altura_cilindro" name="altura_cilindro" step="0.01" min="0.01" required 
                               value="<?php echo htmlspecialchars($altura_cilindro); ?>">
                    </div>
                    
                    <button type="submit" name="calcular_cilindro">Calcular Cilindro</button>
                </form>
                
                <?php if ($area_cilindro && $volumen_cilindro): ?>
                    <div class="result">
                        <h3>Resultados del Cilindro:</h3>
                        <p><strong>Área:</strong> <?php echo $area_cilindro; ?> cm²</p>
                        <p><strong>Volumen:</strong> <?php echo $volumen_cilindro; ?> cm³</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- CALCULADORA DE RECTÁNGULO -->
            <div class="calculator rectangulo">
                <h2>Cálculo de Rectángulo</h2>
                
                <?php if ($error_rectangulo): ?>
                    <div class="error"><?php echo $error_rectangulo; ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="form-group">
                        <label for="base">Base (cm):</label>
                        <input type="number" id="base" name="base" step="0.01" min="0.01" required 
                               value="<?php echo htmlspecialchars($base); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="altura_rectangulo">Altura (cm):</label>
                        <input type="number" id="altura_rectangulo" name="altura_rectangulo" step="0.01" min="0.01" required 
                               value="<?php echo htmlspecialchars($altura_rectangulo); ?>">
                    </div>
                    
                    <button type="submit" name="calcular_rectangulo" class="rectangulo-btn">Calcular Rectángulo</button>
                </form>
                
                <?php if ($area_rectangulo && $perimetro_rectangulo): ?>
                    <div class="result rectangulo">
                        <h3>Resultados del Rectángulo:</h3>
                        <p><strong>Área:</strong> <?php echo $area_rectangulo; ?> cm²</p>
                        <p><strong>Perímetro:</strong> <?php echo $perimetro_rectangulo; ?> cm</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <a href="dashboard.php" class="back-btn">← Volver al Dashboard</a>
    </div>
</body>
</html>