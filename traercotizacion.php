<?php
session_start();
require_once 'config.php';

// Habilitar reporte de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Función para registrar errores
function logError($error) {
    error_log("Error en traercotizacion.php: " . $error);
}

try {
    // Verificar si el usuario está logueado
    if (!isset($_SESSION['usuario_id'])) {
        throw new Exception('Usuario no autenticado');
    }

    // Verificar si la solicitud es POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido');
    }

    // Verificar si se recibió el ID del producto
    if (!isset($_POST['producto_id'])) {
        throw new Exception('ID de producto no proporcionado');
    }

    $producto_id = intval($_POST['producto_id']);

    // Verificar conexión a la base de datos
    if (!$conn) {
        throw new Exception('Error de conexión a la base de datos');
    }

    // Obtener información del producto
    $sql = "SELECT id, nombre, precio FROM productos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception('Error al preparar la consulta: ' . $conn->error);
    }

    $stmt->bind_param("i", $producto_id);
    
    if (!$stmt->execute()) {
        throw new Exception('Error al ejecutar la consulta: ' . $stmt->error);
    }

    $resultado = $stmt->get_result();
    
    if (!$resultado) {
        throw new Exception('Error al obtener resultados: ' . $stmt->error);
    }

    $producto = $resultado->fetch_assoc();

    if (!$producto) {
        throw new Exception('Producto no encontrado');
    }

    // Inicializar el array de productos en la sesión si no existe
    if (!isset($_SESSION['productos_cotizacion'])) {
        $_SESSION['productos_cotizacion'] = [];
    }

    // Agregar el producto al array de la sesión
    $_SESSION['productos_cotizacion'][$producto_id] = [
        'nombre' => $producto['nombre'],
        'precio' => $producto['precio'],
        'cantidad' => 1
    ];

    // Enviar respuesta exitosa
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'mensaje' => 'Producto agregado a la cotización',
        'redirect' => 'cotizar.php'
    ]);

} catch (Exception $e) {
    // Registrar el error
    logError($e->getMessage());
    
    // Enviar respuesta de error
    header('Content-Type: application/json');
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>