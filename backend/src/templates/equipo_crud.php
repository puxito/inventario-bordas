<?php
// equipo_crud.php - Listado de equipos con opciones para ver, editar y eliminar

include('../includes/funciones.php');

$equipos = getEquipos();

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
    } elseif (isset($_POST['deleteComputer'])) {
        deleteComputer($_POST['nexp']); // Usamos nexp como identificador
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
</head>
<style>
    .logo {
            position: fixed;
            top: 20px;
            left: 20px;
            width: 100px;
            height: auto;
            z-index: 1000;
        }
</style>
<body>
    <a href="index.php"><img src="../uploads/logo-bordas-FINAL-esp-color - copia.jpg" alt="Logo de la empresa" class="logo"></a>
    <div class="container mt-4">
        <h2 class="mb-4 text-center">Listado de Equipos</h2>
        <button id="reload" class="btn btn-info mb-3">Recargar</button>

        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Número de Expediente</th>
                    <th>Nombre del Equipo</th>
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
                                Ver detalles
                            </button>
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
                                        <label for="nexp" class="form-label">Nº Exp:</label>
                                        <input type="number" class="form-control" name="nexp" value="<?= htmlspecialchars($equipo['nexp'] ?? '') ?>" required readonly>
                                    </div>

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
                                        <label for="pcname" class="form-label">Nombre del equipo:</label>
                                        <input type="text" class="form-control" name="pcname" value="<?= htmlspecialchars($equipo['pcname'] ?? '') ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="netuser" class="form-label">Usuario de red:</label>
                                        <input type="text" class="form-control" name="netuser" value="<?= htmlspecialchars($equipo['netuser'] ?? '') ?>">
                                    </div>

                                    <!-- Botones de acción dentro del formulario -->
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" name="updateComputer" class="btn btn-warning mt-3 me-2">Actualizar</button>
                                        <button type="submit" name="deleteComputer" class="btn btn-danger mt-3">Eliminar</button>
                                    </div>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        const reload = document.getElementById("reload");

        reload.addEventListener("click", (_) => {
            // el _ es para indicar la ausencia de parametros
            location.reload();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>