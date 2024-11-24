<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO usuarios (nombre, email, password) VALUES ('$nombre', '$email', '$password')";
    
    if ($conn->query($sql)) {
        $_SESSION['mensaje'] = "Registro exitoso. Por favor inicia sesión.";
        header("Location: login.php");
        exit();
    } else {
        $error = "Error al registrar: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Ferretería</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="register-styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="register-container">
            <div class="register-header">
                <img src="imagenes/logo.png" alt="Logo Ferretería" class="logo">
                <h2>Registro de Usuario</h2>
            </div>
            
            <?php if(isset($error)): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label class="form-label">Nombre</label>
                    <div class="position-relative">
                        <input type="text" name="nombre" class="form-control" required>
                        <i class="fas fa-user input-icon"></i>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <div class="position-relative">
                        <input type="email" name="email" class="form-control" required>
                        <i class="fas fa-envelope input-icon"></i>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Contraseña</label>
                    <div class="position-relative">
                        <input type="password" name="password" class="form-control" required>
                        <i class="fas fa-eye password-toggle"></i>
                    </div>
                    <div class="password-requirements">
                        <p><i class="fas fa-info-circle"></i> La contraseña debe contener al menos:</p>
                        <ul>
                            <li>8 caracteres</li>
                            <li>Una letra mayúscula</li>
                            <li>Un número</li>
                        </ul>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Registrarse
                </button>
                
                <a href="index.php" class="btn-return">
                    <i class="fas fa-home"></i> Volver a la Página Principal
                </a>
            </form>
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.querySelector('.password-toggle').addEventListener('click', function() {
            const passwordInput = document.querySelector('input[name="password"]');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>