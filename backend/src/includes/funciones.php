<?php
// funciones.php - Funciones para interactuar con la base de datos

include('db.php');

// Función para insertar un usuario
function insertUser($username, $realname, $dept)
{
    global $conn;

    try {
        $stmt = $conn->prepare("INSERT INTO users (username, realname, dept) VALUES (?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Error preparando la consulta: " . $conn->error);
        }

        $stmt->bind_param("sss", $username, $realname, $dept);
        $stmt->execute(); // Ejecutar la consulta
        $stmt->close();
    } catch (Exception $e) {
        echo "<p class='error'>" . $e->getMessage() . "</p>";
    }
}

// Función para insertar un equipo
function insertComputer($nexp, $model, $cpu, $ram, $motherboard, $storage, $so, $license, $ip, $mac, $pcname, $netuser)
{
    global $conn;

    try {
        $valid_sos = ['Windows XP', 'Windows 7', 'Windows 10', 'Windows 11'];
        if (!in_array($so, $valid_sos)) {
            throw new Exception("Error: El sistema operativo especificado no es válido.");
        }

        $stmt = $conn->prepare("INSERT INTO computers (nexp, model, cpu, ram, motherboard, storage, so, license, ip, mac, pcname, netuser) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Error preparando la consulta: " . $conn->error);
        }

        $stmt->bind_param("issisissssss", $nexp, $model, $cpu, $ram, $motherboard, $storage, $so, $license, $ip, $mac, $pcname, $netuser);
        $stmt->execute(); // Ejecutar la consulta
        $stmt->close();
    } catch (Exception $e) {
        echo "<p class='error'>" . $e->getMessage() . "</p>";
    }
}

// Función para obtener todos los usuarios
function getUsers()
{
    global $conn;
    $users = [];

    $result = $conn->query("SELECT username FROM users");
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row['username'];
        }
    }
    return $users;
}

// Función para obtener todos los equipos, con opción de ordenarlos
function getEquipos($order_by = 'nexp', $order_dir = 'ASC')
{
    global $conn;
    $equipos = [];

    $allowedColumns = ['nexp', 'pcname'];
    $order_by = in_array($order_by, $allowedColumns) ? $order_by : 'nexp';
    $order_dir = strtoupper($order_dir) === 'DESC' ? 'DESC' : 'ASC';

    $stmt = $conn->prepare("SELECT * FROM computers ORDER BY $order_by $order_dir");
    if (!$stmt) {
        throw new Exception("Error preparando la consulta: " . $conn->error);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $equipos[] = $row;
        }
    }

    $stmt->close();
    return $equipos;
}

// Función para obtener los detalles de un solo equipo
function getComputerDetails($nexp)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM computers WHERE nexp = ?");

    if (!$stmt) {
        throw new Exception("Error preparando la consulta: " . $conn->error);
    }

    $stmt->bind_param("i", $nexp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $stmt->close();
        return $result->fetch_assoc(); // Devuelve solo un equipo
    }

    $stmt->close();
    return null; // No se encontró el equipo
}

// Función para obtener los detalles de un usuario por su 'netuser'
function getUsuarioByNetuser($netuser)
{
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    if (!$stmt) {
        throw new Exception("Error preparando la consulta: " . $conn->error);
    }

    $stmt->bind_param("s", $netuser);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc(); // Devuelve solo el usuario
        $stmt->close();
        return $user;
    }

    $stmt->close();
    return null; // No se encontró el usuario
}

// Función para actualizar un equipo
function updateComputer($nexp, $model, $cpu, $ram, $motherboard, $storage, $so, $license, $ip, $mac, $pcname, $netuser)
{
    global $conn;

    try {
        // Obtener los datos actuales del equipo
        $stmt = $conn->prepare("SELECT * FROM computers WHERE nexp = ?");
        $stmt->bind_param("i", $nexp);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        // Verificar qué campos han sido modificados y actualizar solo esos
        $updateFields = [];
        $params = [];

        if ($model != $row['model']) {
            $updateFields[] = "model = ?";
            $params[] = $model;
        }
        if ($cpu != $row['cpu']) {
            $updateFields[] = "cpu = ?";
            $params[] = $cpu;
        }
        if ($ram != $row['ram']) {
            $updateFields[] = "ram = ?";
            $params[] = $ram;
        }
        if ($motherboard != $row['motherboard']) {
            $updateFields[] = "motherboard = ?";
            $params[] = $motherboard;
        }
        if ($storage != $row['storage']) {
            $updateFields[] = "storage = ?";
            $params[] = $storage;
        }
        if ($so != $row['so']) {
            $updateFields[] = "so = ?";
            $params[] = $so;
        }
        if ($license != $row['license']) {
            $updateFields[] = "license = ?";
            $params[] = $license;
        }
        if ($ip != $row['ip']) {
            $updateFields[] = "ip = ?";
            $params[] = $ip;
        }
        if ($mac != $row['mac']) {
            $updateFields[] = "mac = ?";
            $params[] = $mac;
        }
        if ($pcname != $row['pcname']) {
            $updateFields[] = "pcname = ?";
            $params[] = $pcname;
        }
        if ($netuser != $row['netuser']) {
            $updateFields[] = "netuser = ?";
            $params[] = $netuser;
        }

        if (count($updateFields) > 0) {
            $sql = "UPDATE computers SET " . implode(', ', $updateFields) . " WHERE nexp = ?";
            $params[] = $nexp;

            $stmt = $conn->prepare($sql);
            $types = str_repeat("s", count($params) - 1) . "i";
            $stmt->bind_param($types, ...$params);
            $stmt->execute(); // Ejecutar la consulta
            $stmt->close();
        }
    } catch (Exception $e) {
        echo "<p class='error'>" . $e->getMessage() . "</p>";
    }
}

// Función para eliminar un equipo
function deleteComputer($nexp)
{
    global $conn;

    try {
        $stmt = $conn->prepare("DELETE FROM computers WHERE nexp = ?");
        if (!$stmt) {
            throw new Exception("Error preparando la consulta: " . $conn->error);
        }

        $stmt->bind_param("i", $nexp);

        if (!$stmt->execute()) {
            throw new Exception("Error al eliminar el equipo: " . $stmt->error);
        } else {
            echo "<p class='success'>Equipo eliminado correctamente.</p>";
        }

        $stmt->close();
    } catch (Exception $e) {
        echo "<p class='error'>" . $e->getMessage() . "</p>";
    }
}
