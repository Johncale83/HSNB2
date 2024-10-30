// Verificar si el usuario está logueado y tiene permisos de administrador
// (Deberías agregar un campo 'es_admin' en la tabla usuarios)
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Procesar el formulario de agregar/editar producto
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $descripcion = $conn->real_escape_string($_POST['descripcion']);
    $precio = floatval($_POST['precio']);
    $stock = intval($_POST['stock']);
    
    if (isset($_POST['id'])) {
        // Actualizar producto existente
        $id = intval($_POST['id']);
        $sql = "UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, stock = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdii", $nombre, $descripcion, $precio, $stock, $id);
    } else {
        // Insertar nuevo producto
        $sql = "INSERT INTO productos (nombre, descripcion, precio, stock) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdi", $nombre, $descripcion, $precio, $stock);
    }
    
    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "Producto guardado exitosamente.";
    } else {
        $_SESSION['error'] = "Error al guardar el producto: " . $conn->error;
    }
    
    header("Location: admin_productos.php");
    exit();
}

// Eliminar producto
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $sql = "DELETE FROM productos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "Producto eliminado exitosamente.";
    } else {
        $_SESSION['error'] = "Error al eliminar el producto: " . $conn->error;
    }
    
    header("Location: admin_productos.php");
    exit();
}

// Obtener lista de productos
$sql = "SELECT * FROM productos ORDER BY nombre";
$productos = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar Productos - Ferretería</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Administrar Productos</h2>
    
    <?php if(isset($_SESSION['mensaje'])): ?>
        <div class="alert alert-success">
            <?php 
            echo $_SESSION['mensaje']; 
            unset($_SESSION['mensaje']);
            ?>
        </div>
    <?php endif; ?>
    
    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php 
            echo $_SESSION['error']; 
            unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>
    
    <!-- Formulario para agregar/editar producto -->
    <div class="card mb-4">
        <div class="card-body">
            <h3 class="card-title">Agregar Nuevo Producto</h3>
            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label">Nombre del Producto</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Precio</label>
                    <input type="number" name="precio" class="form-control" step="0.01" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Stock</label>
                    <input type="number" name="stock" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Guardar Producto</button>
            </form>
        </div>
    </div>
    
    <!-- Lista de productos -->
    <h3>Productos Existentes</h3>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($producto = $productos->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $producto['id']; ?></td>
                    <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($producto['descripcion']); ?></td>
                    <td>$<?php echo number_format($producto['precio'], 2); ?></td>
                    <td><?php echo $producto['stock']; ?></td>
                    <td>
                        <button class="btn btn-sm btn-primary" 
                                onclick="editarProducto(<?php echo htmlspecialchars(json_encode($producto)); ?>)">
                            Editar
                        </button>
                        <a href="?eliminar=<?php echo $producto['id']; ?>" 
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('¿Está seguro de eliminar este producto?')">
                            Eliminar
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function editarProducto(producto) {
    // Rellenar el formulario con los datos del producto
    const form = document.querySelector('form');
    form.nombre.value = producto.nombre;
    form.descripcion.value = producto.descripcion;
    form.precio.value = producto.precio;
    form.stock.value = producto.stock;
    
    // Agregar campo oculto para el ID
    let idInput = form.querySelector('input[name="id"]');
    if (!idInput) {
        idInput = document.createElement('input');
        idInput.type = 'hidden';
        idInput.name = 'id';
        form.appendChild(idInput);
    }
    idInput.value = producto.id;
    
    // Cambiar el título del formulario
    form.closest('.card').querySelector('.card-title').textContent = 'Editar Producto';
    
    // Hacer scroll al formulario
    form.scrollIntoView({ behavior: 'smooth' });
}
</script>
</body>
</html>