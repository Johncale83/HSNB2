<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Obtener productos para el selector
$sql = "SELECT * FROM productos";
$productos = $conn->query($sql);

function calcularDescuento($total, $tipo_cliente) {
    $descuento = 0;
    
    switch($tipo_cliente) {
        case 'permanente':
            $descuento = 0.10;
            break;
        case 'periodico':
            $descuento = 0.05;
            break;
        case 'casual':
            $descuento = 0.02;
            break;
    }
    
    if ($total > 100000) {
        $descuento += 0.02;
    }
    
    return $descuento;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productos_seleccionados = $_POST['productos'] ?? [];
    $cantidades = $_POST['cantidades'] ?? [];
    
    $total = 0;
    foreach ($productos_seleccionados as $index => $producto_id) {
        $sql = "SELECT precio FROM productos WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $producto_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $producto = $result->fetch_assoc();
        
        $total += $producto['precio'] * $cantidades[$index];
    }
    
    $descuento = calcularDescuento($total, $_SESSION['usuario_tipo']);
    $monto_descuento = $total * $descuento;
    $total_final = $total - $monto_descuento;
    
    // Guardar cotización
    $sql = "INSERT INTO cotizaciones (usuario_id, total, descuento, total_final) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iddd", $_SESSION['usuario_id'], $total, $monto_descuento, $total_final);
    $stmt->execute();
    
    $cotizacion_id = $conn->insert_id;
    
    foreach ($productos_seleccionados as $index => $producto_id) {
        $sql = "SELECT precio FROM productos WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $producto_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $producto = $result->fetch_assoc();
        
        $cantidad = $cantidades[$index];
        $precio_unitario = $producto['precio'];
        $subtotal = $precio_unitario * $cantidad;
        
        $sql = "INSERT INTO cotizacion_items (cotizacion_id, producto_id, cantidad, precio_unitario, subtotal) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiidd", $cotizacion_id, $producto_id, $cantidad, $precio_unitario, $subtotal);
        $stmt->execute();
    }
    
    // Limpiar productos de la sesión
    unset($_SESSION['productos_cotizacion']);
    
    $_SESSION['mensaje'] = "Cotización generada exitosamente";
    header("Location: ver_cotizacion.php?id=" . $cotizacion_id);
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cotizar - Ferretería</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="cotizar-styles.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Generar Cotización</h2>
    <form method="POST" action="" id="formCotizacion">
        <div id="productosContainer">
            <?php
            // Mostrar productos preseleccionados
            if (isset($_SESSION['productos_cotizacion']) && !empty($_SESSION['productos_cotizacion'])) {
                foreach ($_SESSION['productos_cotizacion'] as $prod_id => $producto) {
                    ?>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <select name="productos[]" class="form-select" required>
                                <option value="">Seleccione un producto</option>
                                <?php 
                                $productos->data_seek(0);
                                while($prod = $productos->fetch_assoc()): 
                                    $selected = ($prod['id'] == $prod_id) ? 'selected' : '';
                                ?>
                                    <option value="<?php echo $prod['id']; ?>" 
                                            data-precio="<?php echo $prod['precio']; ?>"
                                            <?php echo $selected; ?>>
                                        <?php echo $prod['nombre']; ?> - $<?php echo number_format($prod['precio'], 2); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="number" name="cantidades[]" class="form-control" 
                                value="<?php echo $producto['cantidad']; ?>"
                                placeholder="Cantidad" min="1" required>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger" onclick="eliminarProducto(this)">
                                Eliminar
                            </button>
                        </div>
                    </div>
                    <?php
                }
            } else {
                // Mostrar una fila vacía si no hay productos preseleccionados
                ?>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <select name="productos[]" class="form-select" required>
                            <option value="">Seleccione un producto</option>
                            <?php 
                            $productos->data_seek(0);
                            while($producto = $productos->fetch_assoc()): ?>
                                <option value="<?php echo $producto['id']; ?>" 
                                        data-precio="<?php echo $producto['precio']; ?>">
                                    <?php echo $producto['nombre']; ?> - $<?php echo number_format($producto['precio'], 2); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="number" name="cantidades[]" class="form-control" 
                            placeholder="Cantidad" min="1" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger" onclick="eliminarProducto(this)">
                            Eliminar
                        </button>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <button type="button" class="btn btn-secondary mb-3" onclick="agregarProducto()">
            Agregar otro producto
        </button>
        <button type="submit" class="btn btn-primary">Generar Cotización</button>

        <a href="index.php" class="btn-return">
            <i class="fas fa-home"></i> Volver a la Página Principal
        </a>

    </form>
</div>

<script>
function agregarProducto() {
    const container = document.getElementById('productosContainer');
    const productoHTML = container.children[0].cloneNode(true);
    productoHTML.querySelectorAll('input, select').forEach(input => {
        input.value = '';
    });
    container.appendChild(productoHTML);
}

function eliminarProducto(boton) {
    const fila = boton.closest('.row');
    if (document.querySelectorAll('#productosContainer .row').length > 1) {
        fila.remove();
    } else {
        fila.querySelectorAll('input, select').forEach(input => {
            input.value = '';
        });
    }
}
</script>
</body>
</html>