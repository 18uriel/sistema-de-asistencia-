<?php
include '../conexion.php';
session_start();

// Verifica si el usuario está logueado y es un estudiante
if (!isset($_SESSION['userId']) || $_SESSION['userType'] != 'Estudiante') {
    header('Location: ../logout.php');
    exit();
}

$userId = $_SESSION['userId']; // ID del estudiante desde la sesión

// Obtener el número de registro del estudiante desde la tabla tblstudent
$query = "SELECT registrationNumber FROM tblstudent WHERE Id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
    $registrationNumber = $student['registrationNumber']; // Usar 'registrationNumber' como identificador para vincular asistencias
} else {
    echo "<script>alert('No se encontró información del estudiante.'); window.location.href = '../logout.php';</script>";
    exit();
}

// Obtener las asistencias del estudiante
$query = "SELECT course, attendanceStatus, dateMarked, unit 
          FROM tblattendance 
          WHERE studentRegistrationNumber = ?
          ORDER BY dateMarked DESC";
$stmt = $conexion->prepare($query);
$stmt->bind_param("s", $registrationNumber); // Usar 'registrationNumber' para buscar registros en tblattendance
$stmt->execute();
$attendance = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Estudiante</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* Configuración general */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            color: white;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        table th {
            background-color: #0d47a1;
            color: white;
        }

        .status-presente {
            color: red;
            font-weight: bold;
        }

        .status-ausente {
            color: green;
            font-weight: bold;
        }

        .btn-back {
            display: inline-block;
            background-color: #0d47a1;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn-back:hover {
            background-color: #1565c0;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Mis Asistencias</h2>
    <table>
        <thead>
            <tr>
                <th>Curso</th>
                <th>Estado de Asistencia</th>
                <th>Fecha</th>
                <th>Unidad</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Mostrar las asistencias del estudiante
            if ($attendance->num_rows > 0) {
                while ($row = $attendance->fetch_assoc()) {
                    $statusClass = $row['attendanceStatus'] == 'Presente' ? 'status-presente' : 'status-ausente';
                    echo "<tr>
                            <td>{$row['course']}</td>
                            <td class='{$statusClass}'>{$row['attendanceStatus']}</td>
                            <td>{$row['dateMarked']}</td>
                            <td>{$row['unit']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4' style='text-align: center;'>No tienes asistencias registradas.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <a href="dash_student.php" class="btn-back">Volver al Dashboard</a>
</div>
</body>
</html>






