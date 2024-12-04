<?php
include '../conexion.php';
session_start();

// Verifica si el usuario está logueado y es un estudiante
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
    </style>
    <script>
        // Función para cargar contenido dinámico
        function loadContent(url) {
            const content = document.getElementById('content');
            fetch(url)
                .then(response => response.text())
                .then(data => content.innerHTML = data)
                .catch(error => content.innerHTML = '<p>Error al cargar contenido.</p>');
        }
    </script>
</head>
<body>

<!-- Barra Lateral -->
<div class="sidebar">
    <div>
        <h2>Dashboard Estudiante</h2>
        <a onclick="loadContent('mis_cursos.php')"><i class="fas fa-book"></i> Mis Cursos</a>
        <a onclick="loadContent('asistencia.php')"><i class="fas fa-calendar-check"></i> Asistencia</a>
        <a onclick="loadContent('actualizar_perfil.php')"><i class="fas fa-user-edit"></i> Actualizar Perfil</a>
    </div>
    <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
</div>

<!-- Contenido Principal -->
<div class="main-content">
    <div class="header">
        <h1>Bienvenido, <?php echo htmlspecialchars($student['firstName']); ?></h1>
        <div class="profile"><?php echo htmlspecialchars($student['firstName'] . ' ' . $student['lastName']); ?></div>
    </div>
    <div class="content" id="content">
        <h2>Selecciona una opción del menú para comenzar</h2>
    </div>
</div>

</body>
</html>









