<?php
include '../conexion.php';
session_start();

// Verificar si el usuario está logueado y es un estudiante
if (!isset($_SESSION['userId']) || $_SESSION['userType'] != 'Estudiante') {
    echo "<script>alert('Sesión no válida. Redirigiendo al inicio de sesión.'); window.location.href = '../logout.php';</script>";
    exit();
}

$userId = $_SESSION['userId']; // ID del estudiante desde la sesión

// Verificar la conexión a la base de datos
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta para obtener la información del estudiante
$query = "SELECT firstName, lastName, email FROM tblstudent WHERE Id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$rs = $stmt->get_result();

if ($rs->num_rows > 0) {
    $student = $rs->fetch_assoc(); // Obtén los datos del estudiante
} else {
    echo "<script>alert('No se encontró información del estudiante.'); window.location.href = '../logout.php';</script>";
    exit();
}

// Consulta para obtener los cursos asignados al estudiante
$query = "SELECT c.name AS course_name, d.firstName AS teacher_firstname, d.lastName AS teacher_lastname, ca.semester
          FROM course_assignments ca
          JOIN tblcourse c ON ca.course_id = c.ID
          LEFT JOIN tbllecture d ON ca.docente_id = d.Id
          WHERE ca.student_id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$courses = $stmt->get_result();
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
            display: flex;
            min-height: 100vh;
        }

        /* Estilo de la barra lateral */
        .sidebar {
            width: 250px;
            background-color: #0d47a1;
            color: white;
            height: 100vh;
            padding: 20px;
            position: fixed;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar h2 {
            font-size: 20px;
            margin-bottom: 30px;
            text-align: center;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px;
            margin-bottom: 10px;
            border-radius: 5px;
            font-size: 14px;
            text-align: left;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #1565c0;
        }

        /* Contenido principal */
        .main-content {
            margin-left: 260px;
            padding: 40px;
            flex-grow: 1;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #fff;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            font-size: 24px;
            color: #333;
        }

        .header .profile {
            background-color: #0d47a1;
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 14px;
        }

        .content {
            margin-top: 20px;
            padding: 20px 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .content h2 {
            margin: 0;
            font-size: 20px;
            color: #555;
            text-align: center;
        }

        .course-card {
            background-color: #f9f9f9;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .course-card h3 {
            margin: 0 0 10px;
            color: #333;
        }

        .course-card p {
            margin: 5px 0;
            color: #555;
        }

        .course-card button {
            margin-top: 10px;
            padding: 10px 15px;
            background-color: #0d47a1;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .course-card button:hover {
            background-color: #1565c0;
        }
    </style>
</head>
<body>

<!-- Contenido Principal -->
<div class="main-content">
    <div class="content" id="content">
        <h2>Mis Cursos</h2>
        <?php
        if ($courses->num_rows > 0) {
            while ($course = $courses->fetch_assoc()) {
                echo "<div class='course-card'>
                        <h3>{$course['course_name']}</h3>
                        <p><strong>Profesor:</strong> {$course['teacher_firstname']} {$course['teacher_lastname']}</p>
                        <p><strong>Semestre:</strong> {$course['semester']}</p>
                        <button>Ver Detalles</button>
                      </div>";
            }
        } else {
            echo "<p style='text-align: center;'>No tienes cursos asignados.</p>";
        }
        ?>
    </div>
</div>

</body>
</html>



