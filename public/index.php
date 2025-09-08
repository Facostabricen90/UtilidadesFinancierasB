<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\Controllers\CalculadoraController;

$controller = new CalculadoraController();
$resultado = null;
$error = null;
$calculoPrevio = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'interes':
                $controller->interesCompuesto();
                $calculoPrevio = ['tipo' => 'interes', 'datos' => $_POST];
                break;
            case 'salario':
                $controller->salarioNeto();
                $calculoPrevio = ['tipo' => 'salario', 'datos' => $_POST];
                break;
            case 'pdf-interes':
                $controller->generarPdfInteres();
                exit;
            case 'enviar-salario':
                $controller->enviarCorreoSalario();
                $controller->salarioNeto();
                $calculoPrevio = ['tipo' => 'salario', 'datos' => $_POST];
                break;
        }
        $resultado = $controller->getResultado();
        $error = $controller->getError();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utilidades Financieras</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="index.php">Utilidades Financieras</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="PrimerEjercicio.php">Análisis de Salarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="SegundoEjercicio.php">Análisis de Ventas</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
     <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h1 class="card-title text-center text-primary mb-4">Calculadoras Financieras</h1>

                        <?php if ($controller->mensajeCorreo): ?>
                            <div class="alert alert-info text-center"><?php echo htmlspecialchars($controller->mensajeCorreo); ?></div>
                        <?php endif; ?>
                        
                        <?php if ($error): ?>
                            <div class="alert alert-danger text-center"><?php echo htmlspecialchars($error); ?></div>
                        <?php elseif ($resultado !== null): ?>
                            <div class="alert alert-success text-center">
                                El resultado es: <strong>$ <?php echo number_format($resultado, 2, ',', '.'); ?></strong>
                            </div>

                            <div class="card mt-3 p-3 bg-light border">
                                <h5 class="card-title mb-3">Acciones Adicionales</h5>
                                <?php if ($calculoPrevio['tipo'] === 'interes'): ?>
                                    <form action="index.php" method="post" target="_blank">
                                        <input type="hidden" name="action" value="pdf-interes">
                                        <input type="hidden" name="capital" value="<?php echo htmlspecialchars($calculoPrevio['datos']['capital']); ?>">
                                        <input type="hidden" name="tasa" value="<?php echo htmlspecialchars($calculoPrevio['datos']['tasa']); ?>">
                                        <input type="hidden" name="anios" value="<?php echo htmlspecialchars($calculoPrevio['datos']['anios']); ?>">
                                        <input type="hidden" name="resultado" value="<?php echo htmlspecialchars($resultado); ?>">
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-secondary"><i class="bi bi-file-earmark-pdf"></i> Descargar Resultado en PDF</button>
                                        </div>
                                    </form>
                                <?php elseif ($calculoPrevio['tipo'] === 'salario'): ?>
                                     <form action="index.php" method="post">
                                        <input type="hidden" name="action" value="enviar-salario">
                                        <input type="hidden" name="salarioBruto" value="<?php echo htmlspecialchars($calculoPrevio['datos']['salarioBruto']); ?>">
                                        <input type="hidden" name="salarioNeto" value="<?php echo htmlspecialchars($resultado); ?>">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                            <input type="email" name="email" class="form-control" placeholder="tu.correo@ejemplo.com" required>
                                            <button type="submit" class="btn btn-secondary">Enviar por Correo</button>
                                        </div>
                                    </form>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        <hr class="my-4">

                        <h2 class="text-primary h4">Calculadora de Interés Compuesto</h2>
                        <form action="index.php" method="post" class="mb-4">
                            <input type="hidden" name="action" value="interes">
                            
                            <div class="mb-3">
                                <label for="capital" class="form-label">Capital Inicial ($):</label>
                                <input type="number" class="form-control" id="capital" name="capital" step="0.01" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="tasa" class="form-label">Tasa de Interés Anual (%):</label>
                                <input type="number" class="form-control" id="tasa" name="tasa" step="0.01" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="anios" class="form-label">Número de Años:</label>
                                <input type="number" class="form-control" id="anios" name="anios" required>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Calcular Interés</button>
                            </div>
                        </form>

                        <hr class="my-4">

                        <h2 class="text-primary h4">Calculadora de Salario Neto (Colombia)</h2>
                        <form action="index.php" method="post">
                            <input type="hidden" name="action" value="salario">
                            
                            <div class="mb-3">
                                <label for="salarioBruto" class="form-label">Salario Bruto Mensual ($):</label>
                                <input type="number" class="form-control" id="salarioBruto" name="salarioBruto" step="0.01" required>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Calcular Salario Neto</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>