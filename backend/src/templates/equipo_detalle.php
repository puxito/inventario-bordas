<?php
// equipo_detalles.php - Mostrar detalles de un equipo y su usuario asociado

include('../includes/funciones.php');

// Obtener el 'nexp' de la URL
$nexp = $_GET['nexp'] ?? null;
$equipo = getComputerDetails($nexp);
$usuario = getUsuarioByNetuser($equipo['netuser'] ?? ''); // Obtener usuario por netuser

// Si el equipo no existe o no se encuentra, redirigir a la página principal
if (!$equipo) {
    header('Location: equipo_crud.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Equipo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
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

    body {
        color: #800000;
        background-color: #fff6df;
    }

    label {
        font-weight: bold;
    }

    ;
</style>

<body>
    <div class="container mt-4">

        <div class="container mt-4" id="contenidoPDF">
            <h2 class="mb-4 text-center"><b>Detalles del Equipo: <?= htmlspecialchars($equipo['pcname'] ?? '') ?></b></h2>
            <h3 class="mb-4 text-center"><b>Número de Expediente: <?= htmlspecialchars(string: $equipo['nexp'] ?? '') ?></b></h3>
            <br>
            <div class="row">
                <!-- Columna para información del equipo -->
                <div class="col-md-6">
                    <h3>Información del Equipo</h3>
                    <div class="card p-3 mb-3">
                        <div class="mb-3">
                            <label for="pcname" class="form-label">Nombre del Equipo:</label>
                            <input type="text" class="form-control" id="pcname" name="pcname" value="<?= htmlspecialchars($equipo['pcname'] ?? '') ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="nexp" class="form-label">Número de Expediente:</label>
                            <input type="text" class="form-control" id="nexp" name="nexp" value="<?= htmlspecialchars($equipo['nexp'] ?? '') ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="model" class="form-label">Modelo:</label>
                            <input type="text" class="form-control" id="model" name="model" value="<?= htmlspecialchars($equipo['model'] ?? '') ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="cpu" class="form-label">CPU:</label>
                            <input type="text" class="form-control" id="cpu" name="cpu" value="<?= htmlspecialchars($equipo['cpu'] ?? '') ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="ram" class="form-label">RAM (MB):</label>
                            <input type="text" class="form-control" id="ram" name="ram" value="<?= htmlspecialchars($equipo['ram'] ?? '') ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="motherboard" class="form-label">Placa Base:</label>
                            <input type="text" class="form-control" id="motherboard" name="motherboard" value="<?= htmlspecialchars($equipo['motherboard'] ?? '') ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="storage" class="form-label">Almacenamiento (GB):</label>
                            <input type="text" class="form-control" id="storage" name="storage" value="<?= htmlspecialchars($equipo['storage'] ?? '') ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="so" class="form-label">Sistema Operativo:</label>
                            <input type="text" class="form-control" id="so" name="so" value="<?= htmlspecialchars($equipo['so'] ?? '') ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="license" class="form-label">Licencia:</label>
                            <input type="text" class="form-control" id="license" name="license" value="<?= htmlspecialchars($equipo['license'] ?? '') ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="ip" class="form-label">IP:</label>
                            <input type="text" class="form-control" id="ip" name="ip" value="<?= htmlspecialchars($equipo['ip'] ?? '') ?>" readonly>
                        </div>
                    </div>
                </div>

                <!-- Columna para información del usuario -->
                <div class="col-md-6">
                    <h3>Información del Usuario</h3>
                    <div class="card p-3 mb-3">
                        <div class="mb-3">
                            <label for="netuser" class="form-label">Usuario de Red:</label>
                            <input type="text" class="form-control" id="netuser" name="netuser" value="<?= htmlspecialchars($usuario['username'] ?? 'Usuario no encontrado') ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="realname" class="form-label">Nombre Real:</label>
                            <input type="text" class="form-control" id="realname" name="realname" value="<?= htmlspecialchars($usuario['realname'] ?? 'No disponible') ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="dept" class="form-label">División:</label>
                            <input type="text" class="form-control" id="dept" name="dept" value="<?= htmlspecialchars($usuario['dept'] ?? 'No disponible') ?>" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button onclick="generarPDF()" class="btn btn-primary mb-3 float-end">Exportar a PDF</button>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
    <script>
        // Función para exportar el contenido a PDF
        function generarPDF() {
            const contenido = document.getElementById('contenidoPDF').cloneNode(true); // Clonar el contenido original

            // Obtener datos dinámicos
            const nexp = document.getElementById('nexp').value;
            const pcname = document.getElementById('pcname').value;

            // Crear un subtítulo dinámico
            const subtitulo = document.createElement('h4');
            subtitulo.textContent = `Nº Expediente: ${nexp}`;
            subtitulo.style.textAlign = 'center';
            subtitulo.style.marginBottom = '20px';
            subtitulo.classList.add('solo-pdf'); // Clase para controlar su visibilidad

            // Insertar el subtítulo al inicio del contenido clonado
            contenido.insertBefore(subtitulo, contenido.firstChild);

            // Añadir estilos para que la clase "solo-pdf" no se muestre en la vista web
            const estiloSoloPDF = document.createElement('style');
            estiloSoloPDF.textContent = `
            .solo-pdf { display: block; }
        `;
            contenido.appendChild(estiloSoloPDF);

            // Configurar el nombre del archivo
            const filename = `${nexp}-${pcname}.pdf`;

            // Configuración y generación del PDF
            html2pdf()
                .set({
                    margin: 0,
                    filename: filename,
                    image: {
                        type: 'jpeg',
                        quality: 1
                    },
                    html2canvas: {
                        scale: 0.6
                    },
                    jsPDF: {
                        unit: 'in',
                        format: 'a4',
                        orientation: 'portrait'
                    }
                })
                .from(contenido)
                .save();
        }
    </script>
</body>

</html>