<?php
// index.php - Interfaz para insertar usuarios y equipos

include('includes/funciones.php');

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

// Obtener la lista de usuarios para el desplegable
$users = getUsers();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Inserción</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>

    <h1>Formulario de Inserción de Usuario y Equipo</h1>

    <!-- Formulario para insertar un usuario -->
    <h2>Insertar Usuario</h2>
    <form method="POST" class="form-container">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        
        <label for="realname">Real Name:</label>
        <input type="text" id="realname" name="realname" required>
        
        <label for="dept">Department:</label>
        <select id="dept" name="dept" required>
            <option value="general">General</option>
            <option value="ddf">DDF</option>
            <option value="ff">FF</option>
            <option value="flav">FLAV</option>
        </select>
        
        <button type="submit" name="insertUser">Insertar Usuario</button>
    </form>

    <!-- Formulario para insertar un equipo -->
    <h2>Insertar Equipo</h2>
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

</body>
</html>
