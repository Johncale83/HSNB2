<?php
session_start();
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hardware Store Nuts and Bolds</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Hardware Store Nuts and Bolds</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <?php if(isset($_SESSION['usuario_id'])): ?>
                        <?php if(isset($_SESSION['usuario_nombre'])): ?>
                            <li class="nav-item">
                                <span class="nav-link text-white">Hola  <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?> Haz iniciado sesion</span>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="cotizar.php">Cotizar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Iniciar Sesión</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="registro.php">Registrarse</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Bienvenido a nuestra Ferretería</h1>

        <div class="page-container">
            <main class="main-content2">
                <h2 class="section-title">Nuestros Productos</h2>

                <!-- Category Filter Buttons -->
                <div class="category-filter">
                    <button class="category-btn active" data-category="all">Todos</button>
                    <button class="category-btn" data-category="herramientas">Herramientas</button>
                    <button class="category-btn" data-category="electricos">Eléctricos</button>
                    <button class="category-btn" data-category="construccion">Construcción</button>
                    <button class="category-btn" data-category="pintura">Pintura</button>
                    <button class="category-btn" data-category="accesorios">Accesorios</button>
                </div>

                <!-- Products Grid -->
                <div class="products-grid">
                    <!-- Product Cards (Same as in the previous response) -->
                    <div class="product-card" data-category="herramientas">
                        <div class="product-image">
                            <img src="imagenes/martillo.png" alt="Martillo Profesional">
                            <div class="product-overlay">
                                <button class="add-to-cart" data-product-id="<?php echo $producto['id']; ?>">
                                    <i class="fas fa-cart-plus"></i>
                                    Cotizar
                                </button>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3>Martillo Profesional</h3>
                            <p class="description">Martillo de acero forjado con mango ergonómico</p>
                            <p class="price">$44.990</p>
                        </div>
                    </div>
                    <div class="product-card" data-category="herramientas">
                        <div class="product-image">
                            <img src="imagenes/destornillador.png" alt="Set Destornilladores">
                            <div class="product-overlay">
                                <button class="add-to-cart" data-product-id="<?php echo $producto['id']; ?>">
                                    <i class="fas fa-cart-plus"></i>
                                    Cotizar
                                </button>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3>Set de Destornilladores</h3>
                            <p class="description">Set 6 piezas Phillips y planos</p>
                            <p class="price">$49.990</p>
                        </div>
                    </div>

                    <div class="product-card" data-category="herramientas">
                        <div class="product-image">
                            <img src="imagenes/Kit Pinzas.png" alt="Set de Pinzas">
                            <div class="product-overlay">
                                <button class="add-to-cart" data-product-id="<?php echo $producto['id']; ?>">
                                    <i class="fas fa-cart-plus"></i>
                                    Cotizar
                                </button>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3>Kit de Pinzas</h3>
                            <p class="description">Juego de herramientas con pinzas, cortadores
                                diagonales y pinzas de punta larga, con cuchillas de corte</p>
                            <p class="price">$79.990</p>
                        </div>
                    </div>

                    <div class="product-card" data-category="electricos">
                        <div class="product-image">
                            <img src="imagenes/taladro.png" alt="Taladro Eléctrico">
                            <div class="product-overlay">
                                <button class="add-to-cart" data-product-id="<?php echo $producto['id']; ?>">
                                    <i class="fas fa-cart-plus"></i>
                                    Cotizar
                                </button>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3>Taladro Eléctrico</h3>
                            <p class="description">Taladro 750W con set de brocas</p>
                            <p class="price">$289.990</p>
                        </div>
                    </div>

                    <div class="product-card" data-category="electricos">
                        <div class="product-image">
                            <img src="imagenes/Amoladora.png" alt="Amoladora Eléctrica">
                            <div class="product-overlay">
                                <button class="add-to-cart" data-product-id="<?php echo $producto['id']; ?>">
                                    <i class="fas fa-cart-plus"></i>
                                    Cotizar
                                </button>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3>Amoladora Eléctrica</h3>
                            <p class="description">Amoladora angular sin escobillas de 4-1/2 pulgadas con interruptor deslizante</p>
                            <p class="price">$158.990</p>
                        </div>
                    </div>

                    <div class="product-card" data-category="herramientas">
                        <div class="product-image">
                            <img src="imagenes/llaves.png" alt="Set de Llaves">
                            <div class="product-overlay">
                                <button class="add-to-cart" data-product-id="<?php echo $producto['id']; ?>">
                                    <i class="fas fa-cart-plus"></i>
                                    Cotizar
                                </button>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3>Set de Llaves Combinadas</h3>
                            <p class="description">Juego 12 llaves combinadas</p>
                            <p class="price">$145.990</p>
                        </div>
                    </div>

                    <div class="product-card" data-category="construccion">
                        <div class="product-image">
                            <img src="imagenes/perfiles.png" alt="perfiles">
                            <div class="product-overlay">
                                <button class="add-to-cart" data-product-id="<?php echo $producto['id']; ?>">
                                    <i class="fas fa-cart-plus"></i>
                                    Cotizar
                                </button>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3>Perfiles Latoneria</h3>
                            <p class="description">Perfiles ideales para marcos de puertas y ventanas</p>
                            <p class="price">$129.990</p>
                        </div>
                    </div>

                    <div class="product-card" data-category="pintura">
                        <div class="product-image">
                            <img src="imagenes/pistolapintura.png" alt=" pistola para Pintura">
                            <div class="product-overlay">
                                <button class="add-to-cart" data-product-id="<?php echo $producto['id']; ?>">
                                    <i class="fas fa-cart-plus"></i>
                                    Cotizar
                                </button>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3>Pistola para Pintura </h3>
                            <p class="description">Pistola pulverizadora HVLP: alta presión</p>
                            <p class="price">$158.990</p>
                        </div>
                    </div>

                    <div class="product-card" data-category="pintura">
                        <div class="product-image">
                            <img src="imagenes/Pintura Interiores.png" alt=" Pintura alta cobertura">
                            <div class="product-overlay">
                                <button class="add-to-cart" data-product-id="<?php echo $producto['id']; ?>">
                                    <i class="fas fa-cart-plus"></i>
                                    Cotizar
                                </button>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3>Pintura alta cobertura</h3>
                            <p class="description">Pintura 5 Galones Pro Alta Cobertura Blanco Precio Especial</p>
                            <p class="price">$229.990</p>
                        </div>
                    </div>

                    <div class="product-card" data-category="electricos">
                        <div class="product-image">
                            <img src="imagenes/soldadura.png" alt="Soldadura Electrodos">
                            <div class="product-overlay">
                                <button class="add-to-cart" data-product-id="<?php echo $producto['id']; ?>">
                                    <i class="fas fa-cart-plus"></i>
                                    Cotizar
                                </button>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3>Soldadura Electrodos</h3>
                            <p class="description">Soldadura de Electrodos Profesional</p>
                            <p class="price">$249.990</p>
                        </div>
                    </div>

                    <div class="product-card" data-category="accesorios">
                        <div class="product-image">
                            <img src="imagenes/anticorrosivo.png" alt="Anticorrosivo">
                            <div class="product-overlay">
                                <button class="add-to-cart" data-product-id="<?php echo $producto['id']; ?>">
                                    <i class="fas fa-cart-plus"></i>
                                    Cotizar
                                </button>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3> Anticorrosivo</h3>
                            <p class="description">Inhibidor de Corrosión Tipo 1 - Acabado Mate</p>
                            <p class="price">$65.000</p>
                        </div>
                    </div>

                    <div class="product-card" data-category="construccion">
                        <div class="product-image">
                            <img src="imagenes/cemento.png" alt="Cemento">
                            <div class="product-overlay">
                                <button class="add-to-cart" data-product-id="<?php echo $producto['id']; ?>">
                                    <i class="fas fa-cart-plus"></i>
                                    Cotizar
                                </button>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3>Cemento Alion</h3>
                            <p class="description">Cemento Gris Alion Uso General 50kg</p>
                            <p class="price">$30.500</p>
                        </div>
                    </div>

                    <div class="product-card" data-category="electricos">
                        <div class="product-image">
                            <img src="imagenes/soldador.png" alt="Soldador Eléctrico">
                            <div class="product-overlay">
                                <button class="add-to-cart" data-product-id="<?php echo $producto['id']; ?>">
                                    <i class="fas fa-cart-plus"></i>
                                    Cotizar
                                </button>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3>Soldador Eléctrico</h3>
                            <p class="description">Soldador 200W con accesorios</p>
                            <p class="price">$429.310</p>
                        </div>
                    </div>

                    <div class="product-card" data-category="construccion">
                        <div class="product-image">
                            <img src="imagenes/ladrillo.png" alt="Ladrillo">
                            <div class="product-overlay">
                                <button class="add-to-cart" data-product-id="<?php echo $producto['id']; ?>">
                                    <i class="fas fa-cart-plus"></i>
                                    Cotizar
                                </button>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3>Ladrillo Comun</h3>
                            <p class="description">Ladrillos rojos industriales de arcilla rectangular</p>
                            <p class="price">$2.310</p>
                        </div>
                    </div>

                    <div class="product-card" data-category="pintura">
                        <div class="product-image">
                            <img src="imagenes/pinturauto.png" alt="Pintura Automotriz">
                            <div class="product-overlay">
                                <button class="add-to-cart" data-product-id="<?php echo $producto['id']; ?>">
                                    <i class="fas fa-cart-plus"></i>
                                    Cotizar
                                </button>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3>Pintura Automotriz</h3>
                            <p class="description">Pintura mas barniz de alta covertura</p>
                            <p class="price">$29.310</p>
                        </div>
                    </div>
                </div>
            </main>

            <aside>
                <!-- Customer Opinions Section -->
                <div class="aside-section">
                    <h3>Opiniones de Clientes</h3>
                    <div class="customer-review">
                        <p>"Excelente servicio y productos de alta calidad. Muy recomendado!"</p>
                        <small>- María García</small>
                    </div>
                    <div class="customer-review">
                        <p>"Los mejores precios en herramientas profesionales."</p>
                        <small>- Juan Pérez</small>
                    </div>
                </div>

                <!-- Promotions Section -->
                <div class="aside-section">
                    <h3>Promociones</h3>
                    <div class="promotion-card">
                        <h4>¡Oferta Especial!</h4>
                        <p>20% de descuento en herramientas eléctricas</p>
                        <small>Válido hasta: 31/12/2024</small>
                    </div>
                    <div class="promotion-card">
                        <h4>2x1</h4>
                        <p>En pinturas anticorrosivas</p>
                        <small>Válido hasta agotar stock</small>
                    </div>
                </div>

                <!-- News Section -->
                <div class="aside-section">
                    <h3>Noticias</h3>
                    <div class="news-item">
                        <p>Nuevos productos de seguridad industrial disponibles</p>
                        <small>15/11/2024</small>
                    </div>
                    <div class="news-item">
                        <p>Próximo taller gratuito de bricolaje</p>
                        <small>10/11/2024</small>
                    </div>
                    <div class="news-item">
                        <p>Horario especial en días festivos</p>
                        <small>05/11/2024</small>
                    </div>
                </div>
            </aside>
            
            <div>
                <footer class="footer">
                    <div class="footer-content">
                        <p>Desarrollo @JhonCalentura</p>
                        <p>Universidad Nacional Abierta y a Distancia UNAD</p>
                        
                        <div class="social-icons">
                            <a href="#" target="_blank" title="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" target="_blank" title="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" target="_blank" title="WhatsApp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <a href="#" target="_blank" title="LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <!-- Scroll to Top Button -->
    <button id="scrollToTopBtn" title="Scroll to Top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script>
    // Product Add to Cart Functionality
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const productId = this.getAttribute('data-product-id');
            
            fetch('traercotizacion.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `producto_id=${productId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    alert(data.error || 'Error al agregar el producto');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al procesar la solicitud');
            });
        });
    });

    // Scroll to Top Functionality
    document.addEventListener('DOMContentLoaded', function() {
        const scrollToTopBtn = document.getElementById('scrollToTopBtn');

        // Show/hide scroll to top button
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                scrollToTopBtn.classList.add('show');
            } else {
                scrollToTopBtn.classList.remove('show');
            }
        });

        // Smooth scroll to top when button is clicked
        scrollToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    });

    // Category Filtering
    document.addEventListener('DOMContentLoaded', function() {
        const categoryButtons = document.querySelectorAll('.category-btn');
        const productCards = document.querySelectorAll('.product-card');

        categoryButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                categoryButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');

                // Get the selected category
                const category = this.getAttribute('data-category');

                // Filter products
                productCards.forEach(card => {
                    if (category === 'all' || card.getAttribute('data-category') === category) {
                        card.classList.remove('hidden');
                    } else {
                        card.classList.add('hidden');
                    }
                });
            });
        });
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>