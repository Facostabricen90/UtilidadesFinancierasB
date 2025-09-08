<?php
$Ventas = [
    'V001' => ['ID' => 'V001', 'cliente' => 'Cliente A', 'producto' => 'Laptop', 'cantidad' => 2, 'precio_unitario' => 1200, 'fecha' => '2025-01-15'],
    'V002' => ['ID' => 'V002', 'cliente' => 'Cliente B', 'producto' => 'Mouse', 'cantidad' => 5, 'precio_unitario' => 25, 'fecha' => '2025-01-16'],
    'V003' => ['ID' => 'V003', 'cliente' => 'Cliente A', 'producto' => 'Teclado', 'cantidad' => 3, 'precio_unitario' => 50, 'fecha' => '2025-01-17'],
    'V004' => ['ID' => 'V004', 'cliente' => 'Cliente C', 'producto' => 'Laptop', 'cantidad' => 1, 'precio_unitario' => 1250, 'fecha' => '2025-01-18'],
    'V005' => ['ID' => 'V005', 'cliente' => 'Cliente B', 'producto' => 'Monitor', 'cantidad' => 2, 'precio_unitario' => 300, 'fecha' => '2025-01-19'],
    'V006' => ['ID' => 'V006', 'cliente' => 'Cliente A', 'producto' => 'Mouse', 'cantidad' => 4, 'precio_unitario' => 25, 'fecha' => '2025-01-20'],
];


$totalVentas = count($Ventas);

$gastoPorCliente = [];
foreach ($Ventas as $venta) {
    $cliente = $venta['cliente'];
    $totalGasto = $venta['cantidad'] * $venta['precio_unitario'];

    if (!isset($gastoPorCliente[$cliente])) {
        $gastoPorCliente[$cliente] = 0;
    }
    $gastoPorCliente[$cliente] += $totalGasto;
}

arsort($gastoPorCliente);
$clienteTop = key($gastoPorCliente);
$gastoTop = current($gastoPorCliente);

$unidadesPorProducto = [];
$ventasPorProducto = [];
foreach ($Ventas as $venta) {
    $producto = $venta['producto'];
    $cantidad = $venta['cantidad'];
    $total = $cantidad * $venta['precio_unitario'];

    if (!isset($unidadesPorProducto[$producto])) {
        $unidadesPorProducto[$producto] = 0;
        $ventasPorProducto[$producto] = 0;
    }
    $unidadesPorProducto[$producto] += $cantidad;
    $ventasPorProducto[$producto] += $total;
}

arsort($unidadesPorProducto);
$productoMasVendido = key($unidadesPorProducto);
$unidadesVendidas = current($unidadesPorProducto);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Análisis de Ventas - Utilidades Financieras</title>
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
                        <a class="nav-link" href="PrimerEjercicio.php">Análisis de Salarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="SegundoEjercicio.php">Análisis de Ventas</a>
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
                        <h1 class="card-title text-center text-primary mb-4">Análisis de Ventas</h1>
                        
                        <h3 class="text-primary">Total de Ventas Realizadas</h3>
                        <div class="alert alert-info mb-4">
                            Se han realizado <strong><?php echo $totalVentas; ?></strong> ventas en total.
                        </div>
                        
                        <h3 class="text-primary">Cliente que Más Ha Gastado</h3>
                        <div class="alert alert-success mb-4">
                            <strong><?php echo htmlspecialchars($clienteTop); ?></strong> con un gasto total de $<?php echo number_format($gastoTop, 2); ?>
                        </div>
                        
                        <h3 class="text-primary">Productos Vendidos</h3>
                        <div class="table-responsive mb-4">
                            <table class="table table-striped">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Producto</th>
                                        <th>Unidades Vendidas</th>
                                        <th>Total Ventas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($unidadesPorProducto as $producto => $unidades): ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($producto); ?></strong></td>
                                        <td><?php echo $unidades; ?></td>
                                        <td>$<?php echo number_format($ventasPorProducto[$producto], 2); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <h3 class="text-primary">Producto Más Vendido</h3>
                        <div class="alert alert-warning">
                            <strong><?php echo htmlspecialchars($productoMasVendido); ?></strong> con <?php echo $unidadesVendidas; ?> unidades vendidas
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