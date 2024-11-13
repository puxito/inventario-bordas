<?php
// equipo_crud.php - Listado de equipos con opciones para ver, editar y eliminar

include('../includes/funciones.php');

// Ordenación
$order_by = $_GET['order_by'] ?? 'nexp';
$order_dir = $_GET['order_dir'] ?? 'asc';
$equipos = getEquipos($order_by, $order_dir);
$new_order_dir = $order_dir === 'asc' ? 'desc' : 'asc';

// Mensaje de retroalimentación


// Si se envía el formulario de actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['updateComputer'])) {
        updateComputer(
            $_POST['nexp'],
            $_POST['model'],
            $_POST['cpu'],
            $_POST['ram'],
            $_POST['motherboard'],
            $_POST['storage'],
            $_POST['so'],
            $_POST['license'],
            $_POST['ip'],
            $_POST['mac'],
            $_POST['pcname'],
            $_POST['netuser']
        );
        $message = 'Equipo actualizado correctamente.';
    } elseif (isset($_POST['deleteComputer'])) {
        deleteComputer($_POST['nexp']); // Usamos nexp como identificador
        $message = 'Equipo eliminado correctamente.';
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Equipos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Responsive and styled with chosen color patterns */

        body {
            background-color: #fff6df;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }

        h2 {
            color: #800000;
        }

        .table {
            border: 1px solid #800000;
            border-radius: 8px;
        }

        .table img {
            width: 20px;
        }

        .table th {
            background-color: #800000;
            color: #ffffff;
            cursor: pointer;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f2f2f2;
        }

        .table-hover tbody tr:hover {
            background-color: #d9e2f3;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-warning {
            background-color: #ffca2c;
            color: #343a40;
            border: none;
        }

        .btn-danger {
            background-color: #e3342f;
            border: none;
        }

        .btn-info {
            background-color: #17a2b8;
            border: none;
            color: #ffffff;
        }

        .collapse {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 15px;
            margin-top: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .logo {
            position: fixed;
            top: 20px;
            left: 20px;
            width: 100px;
            height: auto;
            z-index: 1000;
        }

        @media (max-width: 768px) {
            .logo {
                width: 80px;
            }

            .container {
                padding: 10px;
            }

            .table {
                font-size: 0.9em;
            }

            .btn {
                font-size: 0.85em;
            }
        }

        /* Mensaje emergente estilizado */
        #message {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 999;
            width: auto;
            max-width: 300px;
            padding: 15px;
            font-size: 16px;
            border-radius: 5px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            transition: opacity 0.5s ease-in-out;
        }
    </style>
</head>

<body>
    <!-- Mensaje emergente -->
    <div id="message" class="alert alert-info d-none" role="alert">
        Acción realizada correctamente.
    </div>

    <a href="../index.php"><img src="../uploads/logo-bordas-FINAL-esp-color - copia.jpg" alt="Logo de la empresa" class="logo"></a>
    <div class="container mt-4">
        <h2 class="mb-4 text-center"><b>Listado de Equipos</b></h2>
        <button id="reload" class="btn btn-info mb-3">Recargar</button>

        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th><a href="?order_by=nexp&order_dir=<?= $new_order_dir ?>" class="text-light">Número de Expediente</a></th>
                    <th><a href="?order_by=pcname&order_dir=<?= $new_order_dir ?>" class="text-light">Nombre del Equipo</a></th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($equipos as $equipo): ?>
                    <tr>
                        <td><?= htmlspecialchars($equipo['nexp'] ?? '') ?></td>
                        <td><?= htmlspecialchars($equipo['pcname'] ?? '') ?></td>
                        <td>
                            <!-- Botón para mostrar detalles y opciones de editar/eliminar -->
                            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#details-<?= htmlspecialchars($equipo['nexp'] ?? 'unknown') ?>">
                                <img src="../uploads/pencil.png" alt="Edit">
                            </button>
                            
                                <a href="equipo_detalle.php?nexp=<?= urlencode($equipo['nexp']) ?>" class="btn btn-eye">
                                    <img src="../uploads/eye.png" alt="Details">
                                </a>
                            
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <!-- Contenedor colapsable con clase 'collapse' dentro de un td -->
                            <div id="details-<?= htmlspecialchars($equipo['nexp'] ?? 'unknown') ?>" class="collapse">
                                <form method="POST" class="border p-4 bg-light rounded shadow-sm">
                                    <input type="hidden" name="nexp" value="<?= htmlspecialchars($equipo['nexp'] ?? '') ?>">

                                    <!-- Campos del formulario con clases de Bootstrap -->
                                    <div class="mb-3">
                                        <label for="model" class="form-label">Modelo:</label>
                                        <input type="text" class="form-control" name="model" value="<?= htmlspecialchars($equipo['model'] ?? '') ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="cpu" class="form-label">CPU:</label>
                                        <input type="text" class="form-control" name="cpu" value="<?= htmlspecialchars($equipo['cpu'] ?? '') ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="ram" class="form-label">RAM:</label>
                                        <input type="number" class="form-control" name="ram" value="<?= htmlspecialchars($equipo['ram'] ?? '') ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="motherboard" class="form-label">Motherboard:</label>
                                        <input type="text" class="form-control" name="motherboard" value="<?= htmlspecialchars($equipo['motherboard'] ?? '') ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="storage" class="form-label">Storage:</label>
                                        <input type="number" class="form-control" name="storage" value="<?= htmlspecialchars($equipo['storage'] ?? '') ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="so" class="form-label">SO:</label>
                                        <input type="text" class="form-control" name="so" value="<?= htmlspecialchars($equipo['so'] ?? '') ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="license" class="form-label">Licencia:</label>
                                        <input type="text" class="form-control" name="license" value="<?= htmlspecialchars($equipo['license'] ?? '') ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="ip" class="form-label">IP:</label>
                                        <input type="text" class="form-control" name="ip" value="<?= htmlspecialchars($equipo['ip'] ?? '') ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="mac" class="form-label">MAC:</label>
                                        <input type="text" class="form-control" name="mac" value="<?= htmlspecialchars($equipo['mac'] ?? '') ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="pcname" class="form-label">Nombre del Equipo:</label>
                                        <input type="text" class="form-control" name="pcname" value="<?= htmlspecialchars($equipo['pcname'] ?? '') ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="netuser" class="form-label">Usuario de red:</label>
                                        <input type="text" class="form-control" name="netuser" value="<?= htmlspecialchars($equipo['netuser'] ?? '') ?>">
                                    </div>

                                    <button type="submit" name="updateComputer" class="btn btn-warning">Actualizar equipo</button>
                                    <button type="submit" name="deleteComputer" class="btn btn-danger">Eliminar equipo</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById("reload").addEventListener("click", function() {
            location.reload();
        });

        // Muestra el mensaje emergente después de una acción
        <?php if ($message): ?>
            const messageElement = document.getElementById("message");
            messageElement.textContent = '<?= $message ?>';
            messageElement.classList.remove("d-none");

            // Después de 3 segundos, ocultamos el mensaje
            setTimeout(function() {
                messageElement.classList.add("d-none");
            }, 3000);
        <?php endif; ?>
    </script>
</body>

</html>