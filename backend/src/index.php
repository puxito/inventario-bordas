<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Empresa</title>
    <link rel="icon" type="image/x-icon" href="uploads/favicon.ico">
    
    <!-- Enlace a Bootstrap CSS desde CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Estilos personalizados -->
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
        }

        body {
            color: #333;
            font-family: 'Arial', sans-serif;
            background-color: #fff6df;
        }

        .content {
            flex: 1;
            text-align: center;
            margin-top: 50px;
        }

        .btn-custom {
            background-color: #800000;
            color: white;
            font-size: 18px;
            padding: 15px 30px;
            margin: 10px;
            text-transform: uppercase;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #a52a2a;
            color: white;
            text-decoration: none;
        }

        .logo {
            position: fixed;
            top: 20px;
            left: 20px;
            width: 100px;
            height: auto;
            z-index: 1000;
        }

        h2 {
            font-size: 28px;
            color: #800000;
            font-weight: bold;
            margin-bottom: 30px;
        }

        /* Estilos responsivos */
        @media (max-width: 768px) {
            .btn-custom {
                width: 100%;
                margin: 10px 0;
            }
        }

        .footer {
            text-align: center;
            padding: 20px;
            background-color: #800000;
            color: white;
            margin-top: 30px;
            border-radius: 5px;
        }

        .footer p {
            margin: 0;
        }
    </style>
</head>
<body>

    <!-- Logo flotante en la esquina -->
    <a href="index.php"><img src="uploads/logo-bordas-FINAL-esp-color - copia.jpg" alt="Logo de la empresa" class="logo"></a>

    <div class="content">
        <div class="container">
            <h2>Gestor de Equipos y QR</h2>
            <div class="d-flex justify-content-center flex-wrap">
                <a href="/templates/equipo_crud.php" class="btn btn-custom btn-lg mx-3">Gestionar Equipos</a>
                <a href="/templates/insertar_datos.php" class="btn btn-custom btn-lg mx-3">Insertar Datos</a>
                
            </div>
        </div>
    </div>

    <!-- Pie de página con información adicional -->
    <footer class="footer">
        <p>&copy; 2024 Destilaciones Bordas Chinchurreta. Todos los derechos reservados.</p>
    </footer>

    <!-- Enlace a Bootstrap JS desde CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

</body>
</html>
