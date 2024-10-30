<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$cotizacion_id = intval($_GET['id']);

// Obtener datos de la cotización
$sql = "SELECT c.*, u.nombre as nombre_usuario, u.tipo_cliente 
        FROM cotizaciones c 
        JOIN usuarios u ON c.usuario_id = u.id 
        WHERE c.id = ? AND c.usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $cotizacion_id, $_SESSION['usuario_id']);
$stmt->execute();
$cotizacion = $stmt->get_result()->fetch_assoc();

if (!$cotizacion) {
    header("Location: index.php");
    exit();
}

// Obtener items de la cotización
$sql = "SELECT ci.*, p.nombre as nombre_producto 
        FROM cotizacion_items ci 
        JOIN productos p ON ci.producto_id = p.id 
        WHERE ci.cotizacion_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cotizacion_id);
$stmt->execute();
$items = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Cotización - Ferretería</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">Cotización #<?php echo $cotizacion['id']; ?></h3>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <h6 class="mb-3">Datos del Cliente:</h6>
                            <div>
                                <strong>Nombre:</strong> <?php echo htmlspecialchars($cotizacion['nombre_usuario']); ?><br>
                                <strong>Tipo de Cliente:</strong> <?php echo ucfirst($cotizacion['tipo_cliente']); ?><br>
                                <strong>Fecha:</strong> <?php echo date('d/m/Y H:i', strtotime($cotizacion['fecha'])); ?>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($item = $items->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['nombre_producto']); ?></td>
                                    <td><?php echo $item['cantidad']; ?></td>
                                    <td>$<?php echo number_format($item['precio_unitario'], 2); ?></td>
                                    <td>$<?php echo number_format($item['subtotal'], 2); ?></td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                    <td>$<?php echo number_format($cotizacion['total'], 2); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Descuento:</strong></td>
                                    <td>$<?php echo number_format($cotizacion['descuento'], 2); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total Final:</strong></td>
                                    <td><strong>$<?php echo number_format($cotizacion['total_final'], 2); ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <p class="text-muted">
                                Nota: Esta cotización es válida por 15 días a partir de su emisión.
                            </p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="cotizar.php" class="btn btn-secondary">Nueva Cotización</a>
                        <button onclick="window.print()" class="btn btn-primary">Imprimir Cotización</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style media="print">
    .btn { display: none; }
    @page { margin: 2cm; }
</style>
</body>
</html>