<?php
include '../conexion.php';
session_start();

// Verificar si el usuario es tutor
if (!isset($_SESSION['userId']) || $_SESSION['userType'] != 'Tutor') {
    header('Location: ../logout.php');
    exit();
}

$tutorId = $_SESSION['userId'];

// Obtener las asistencias de los estudiantes asignados al tutor
$query = "SELECT s.firstName, s.lastName, a.dateMarked, a.attendanceStatus, c.name AS course_name
          FROM tutor_students ts
          JOIN tblattendance a ON ts.student_id = a.studentRegistrationNumber
          JOIN tblstudent s ON ts.student_id = s.Id
          JOIN tblcourse c ON ts.course_id = c.ID
          WHERE ts.tutor_id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $tutorId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Asistencias</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        .container { max-width: 1000px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #0d47a1; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
    </style>
</head>
<body>
<div class="container">
    <h2>Asistencias de Estudiantes</h2>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Curso</th>
                <th>Fecha</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['firstName'] . " " . $row['lastName']; ?></td>
                    <td><?php echo $row['course_name']; ?></td>
                    <td><?php echo $row['dateMarked']; ?></td>
                    <td><?php echo $row['attendanceStatus']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
