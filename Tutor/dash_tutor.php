<?php
include '../conexion.php';
session_start();

// Verificar si el usuario está logueado y es un tutor
if (!isset($_SESSION['userId']) || $_SESSION['userType'] != 'Tutor') {
    header('Location: ../logout.php');
    exit();
}

$userId = $_SESSION['userId']; // ID del tutor desde la sesión

// Obtener información del tutor desde tbllecture
$query = "SELECT firstName, lastName, emailAddress FROM tbltutor WHERE Id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $tutor = $result->fetch_assoc();
} else {
    echo "<script>alert('No se encontró información del tutor.'); window.location.href = '../logout.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Tutor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .sidebar {
            width: 250px;
            background-color: #0d47a1;
            color: white;
            position: fixed;
            height: 100%;
            padding: 20px;
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 20px;
        }
        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            margin: 15px 0;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .sidebar a:hover {
            background-color: #1565c0;
        }
        .main-content {
            margin-left: 270px;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #fff;
            border-radius: 8px;
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
        }
        .content {
            margin-top: 20px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .content h2 {
            margin: 0 0 20px;
            font-size: 20px;
            color: #555;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Dashboard Tutor</h2>
    <a href="asignar_estudiantes.php"><i class="fas fa-users"></i> Asignar Estudiantes</a>
    <a href="ver_asistencias.php"><i class="fas fa-calendar-check"></i> Ver Asistencias</a>
    <a href="editar_perfil.php"><i class="fas fa-user-edit"></i> Editar Perfil</a>
    <a href="../logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
</div>

<div class="main-content">
    <div class="header">
        <h1>Bienvenido, <?php echo htmlspecialchars($tutor['firstName']); ?></h1>
        <div class="profile"><?php echo htmlspecialchars($tutor['firstName'] . ' ' . $tutor['lastName']); ?></div>
    </div>
    <div class="content">
        <h2>Seleccione una opción del menú para comenzar</h2>
        <p>Como tutor, puedes asignar estudiantes a tus cursos, revisar las asistencias y gestionar tu perfil.</p>
    </div>
</div>

</body>
</html>

