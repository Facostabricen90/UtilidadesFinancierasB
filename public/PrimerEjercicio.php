<?php
$empleados = [
    ['nombre' => 'Juan Pérez', 'salario' => 2500, 'departamento' => 'Ventas'],
    ['nombre' => 'Ana Gómez', 'salario' => 3000, 'departamento' => 'Ventas'],
    ['nombre' => 'Luis Ramos', 'salario' => 3200, 'departamento' => 'Ventas'],
    ['nombre' => 'María Solano', 'salario' => 4000, 'departamento' => 'IT'],
    ['nombre' => 'Carlos Lima', 'salario' => 3800, 'departamento' => 'IT'],
    ['nombre' => 'Sofía Torres', 'salario' => 4500, 'departamento' => 'IT'],
    ['nombre' => 'Pedro Marín', 'salario' => 2200, 'departamento' => 'Marketing'],
    ['nombre' => 'Lucía Fernández', 'salario' => 2400, 'departamento' => 'Marketing'],
];

$salariosPorDepto = [];
$empleadosPorDepto = [];

foreach ($empleados as $empleado) {
    $depto = $empleado['departamento'];
    $salario = $empleado['salario'];

    if (!isset($salariosPorDepto[$depto])) {
        $salariosPorDepto[$depto] = 0;
        $empleadosPorDepto[$depto] = 0;
    }

    $salariosPorDepto[$depto] += $salario;
    $empleadosPorDepto[$depto]++;
}

$promedios = [];
foreach ($salariosPorDepto as $depto => $totalSalario) {
    $promedio = $totalSalario / $empleadosPorDepto[$depto];
    $promedios[$depto] = $promedio;
}

$deptoMasAlto = '';
$promedioMasAlto = 0;
foreach ($promedios as $depto => $promedio) {
    if ($promedio > $promedioMasAlto) {
        $promedioMasAlto = $promedio;
        $deptoMasAlto = $depto;
    }
}

$empleadosSobrePromedio = [];
foreach ($empleados as $empleado) {
    $depto = $empleado['departamento'];
    $salario = $empleado['salario'];
    
    if ($salario > $promedios[$depto]) {
        $empleadosSobrePromedio[] = [
            'nombre' => $empleado['nombre'],
            'salario' => $salario,
            'departamento' => $depto,
            'promedio_depto' => $promedios[$depto]
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Análisis de Salarios - Utilidades Financieras</title>
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
                        <a class="nav-link" href="index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="PrimerEjercicio.php">Análisis de Salarios</a>
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
                <div class="card shadow">
                    <div class="card-body">
                        <h1 class="card-title text-center text-primary mb-4">Análisis de Salarios</h1>
                        
                        <h3 class="text-primary">Promedio de Salarios por Departamento</h3>
                        <div class="table-responsive mb-4">
                            <table class="table table-striped">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Departamento</th>
                                        <th>Promedio de Salario</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($promedios as $depto => $promedio): ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($depto); ?></strong></td>
                                        <td>$<?php echo number_format($promedio, 2); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <h3 class="text-primary">Departamento con Salario Promedio Más Alto</h3>
                        <div class="alert alert-info mb-4">
                            <strong><?php echo htmlspecialchars($deptoMasAlto); ?></strong> con un promedio de $<?php echo number_format($promedioMasAlto, 2); ?>
                        </div>
                        
                        <h3 class="text-primary">Empleados que Ganan por Encima del Promedio de su Departamento</h3>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Departamento</th>
                                        <th>Salario</th>
                                        <th>Promedio Depto.</th>
                                        <th>Diferencia</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($empleadosSobrePromedio as $emp): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($emp['nombre']); ?></td>
                                        <td><?php echo htmlspecialchars($emp['departamento']); ?></td>
                                        <td>$<?php echo number_format($emp['salario'], 2); ?></td>
                                        <td>$<?php echo number_format($emp['promedio_depto'], 2); ?></td>
                                        <td>$<?php echo number_format($emp['salario'] - $emp['promedio_depto'], 2); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>