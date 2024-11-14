<?php
include('../includes/funciones.php');

// Insertar un usuario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insertUser'])) {
    $username = $_POST['username'];
    $realname = $_POST['realname'];
    $dept = $_POST['dept'];

    insertUser($username, $realname, $dept);
}

// Insertar un equipo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insertComputer'])) {
    $nexp = $_POST['nexp'];
    $model = $_POST['model'];
    $cpu = $_POST['cpu'];
    $ram = $_POST['ram'];
    $motherboard = $_POST['motherboard'];
    $storage = $_POST['storage'];
    $so = $_POST['so'];
    $license = $_POST['license'];
    $ip = $_POST['ip'];
    $mac = $_POST['mac'];
    $pcname = $_POST['pcname'];
    $netuser = $_POST['netuser'];

    insertComputer($nexp, $model, $cpu, $ram, $motherboard, $storage, $so, $license, $ip, $mac, $pcname, $netuser);
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['uploadCSV'])) {
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
        $csvFilePath = $_FILES['csv_file']['tmp_name'];
        
        // Llama a la función para insertar usuarios desde el archivo CSV
        insertUsersFromCSV($csvFilePath);
        
        // Mensaje de confirmación
        $message = "Usuarios insertados desde el archivo CSV exitosamente.";
    } else {
        $message = "Error al cargar el archivo CSV.";
    }
}

// Obtener la lista de usuarios para el desplegable
$users = getUsers();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Inserción</title>
    <link rel="icon" type="image/x-ico" href="../uploads/LOGO-BORDAS-ICO.ico">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            color: #800000;
            background-color: #fff6df;
            font-family: Arial, sans-serif;
            padding: 30px;
        }

        h1,
        h2 {
            text-align: center;
            color: #800000;
        }

        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .form-container label {
            font-weight: bold;
            color: #555;
        }

        .form-container input,
        .form-container select,
        .form-container button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-container button {
            background-color: #800000;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .form-container button:hover {
            background-color: #a52a2a;
        }

        .form-container select {
            background-color: #f9f9f9;
        }

        .form-container input:focus,
        .form-container select:focus {
            border-color: #800000;
            outline: none;
        }




        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        /* Estilo para el logo flotante en una esquina */
        .logo {
            position: fixed;
            top: 20px;
            left: 20px;
            width: 100px;
            height: auto;
            z-index: 1000;
        }

        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <!-- Logo flotante en la esquina -->
    <a href="../index.php"><img src="../uploads/logo-bordas-FINAL-esp-color - copia.jpg" alt="Logo de la empresa" class="logo"></a>

    <div class="container">

        <!-- Formulario para insertar un usuario -->
        <h2><b>Insertar Usuario</b></h2>
        <form method="POST" class="form-container">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="realname">Real Name:</label>
            <input type="text" id="realname" name="realname" required>

            <label for="dept">Department:</label>
            <select id="dept" name="dept" required>
                <option value="staff">STAFF</option>
                <option value="ddf">DDF</option>
                <option value="f&f">F&F</option>
                <option value="fla">FLA</option>
            </select>

            <button type="submit" name="insertUser">Insertar Usuario</button>
        </form>
        <h2><b>Insertar Usuarios desde CSV</b></h2>
        <form method="POST" class="form-container" enctype="multipart/form-data">
            <label for="csv_file">Selecciona un archivo CSV:</label>
            <input type="file" id="csv_file" name="csv_file" accept=".csv" required>

            <button type="submit" name="uploadCSV">Insertar Usuarios desde CSV</button>
        </form>

        <!-- Formulario para insertar un equipo -->
        <h2><b>Insertar Equipo</b></h2>
        <form method="POST" class="form-container">
            <label for="nexp">NºEXP:</label>
            <input type="number" id="nexp" name="nexp" required>

            <label for="model">Model:</label>
            <input type="text" id="model" name="model" required>

            <label for="cpu">CPU:</label>
            <input type="text" id="cpu" name="cpu" required>

            <label for="ram">RAM:</label>
            <input type="number" id="ram" name="ram" required>

            <label for="motherboard">Motherboard:</label>
            <input type="text" id="motherboard" name="motherboard" required>

            <label for="storage">Storage:</label>
            <input type="number" id="storage" name="storage" required>

            <label for="so">Operating System:</label>
            <select id="so" name="so" required>
                <option value="Windows XP">Windows XP</option>
                <option value="Windows 7">Windows 7</option>
                <option value="Windows 10">Windows 10</option>
                <option value="Windows 11">Windows 11</option>
            </select>

            <label for="license">License:</label>
            <input type="text" id="license" name="license" required>

            <label for="ip">IP Address:</label>
            <input type="text" id="ip" name="ip" required>

            <label for="mac">MAC Address:</label>
            <input type="text" id="mac" name="mac" required>

            <label for="pcname">PC Name:</label>
            <input type="text" id="pcname" name="pcname" required>

            <label for="netuser">Net User (Username):</label>
            <select id="netuser" name="netuser" required>
                <option value="" disabled selected>Seleccionar Usuario</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?= htmlspecialchars($user) ?>"><?= htmlspecialchars($user) ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit" name="insertComputer">Insertar Equipo</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybBogGzC7GoouOY1D9HfqF5zsXY1wA03GzHN3k5/u6pD6L6L3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Wn1qWmQNAhD2F3cZ1IRamPpBJoA7Ai1sgFHSk0HsPq4s5p" crossorigin="anonymous"></script>
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