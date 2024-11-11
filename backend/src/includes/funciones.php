<?php
// functions.php - Funciones para interactuar con la base de datos

include('db.php');

// Función para insertar un usuario
function insertUser($username, $realname, $dept) {
    global $conn;
    
    try {
        // Preparar la consulta para prevenir inyecciones SQL
        $stmt = $conn->prepare("INSERT INTO users (username, realname, dept) VALUES (?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Error preparando la consulta: " . $conn->error);
        }

        $stmt->bind_param("sss", $username, $realname, $dept);
        
        // Ejecutar la consulta y verificar el resultado
        if (!$stmt->execute()) {
            throw new Exception("Error al insertar el usuario: " . $stmt->error);
        } else {
            echo "<p class='success'>Usuario insertado correctamente.</p>";
        }
        
        $stmt->close();
    } catch (Exception $e) {
        echo "<p class='error'>" . $e->getMessage() . "</p>";
    }
}

// Función para insertar un equipo
function insertComputer($nexp, $model, $cpu, $ram, $motherboard, $storage, $so, $license, $ip, $mac, $pcname, $netuser) {
    global $conn;

    try {
        // Lista de valores válidos para 'so' para validación
        $valid_sos = ['Windows XP', 'Windows 7', 'Windows 10', 'Windows 11'];
        if (!in_array($so, $valid_sos)) {
            throw new Exception("Error: El sistema operativo especificado no es válido.");
        }

        // Preparar la consulta
        $stmt = $conn->prepare("INSERT INTO computers (nexp, model, cpu, ram, motherboard, storage, so, license, ip, mac, pcname, netuser) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Error preparando la consulta: " . $conn->error);
        }

        $stmt->bind_param("issisissssss", $nexp, $model, $cpu, $ram, $motherboard, $storage, $so, $license, $ip, $mac, $pcname, $netuser);
        
        // Ejecutar la consulta y verificar el resultado
        if (!$stmt->execute()) {
            throw new Exception("Error al insertar el equipo: " . $stmt->error);
        } else {
            echo "<p class='success'>Equipo insertado correctamente.</p>";
        }
        
        $stmt->close();
    } catch (Exception $e) {
        echo "<p class='error'>" . $e->getMessage() . "</p>";
    }
}
