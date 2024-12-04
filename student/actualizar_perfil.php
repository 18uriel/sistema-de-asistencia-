<?php
include '../conexion.php';
session_start();

// Verifica si el usuario está logueado y es un estudiante
if (!isset($_SESSION['userId']) || $_SESSION['userType'] != 'Estudiante') {
    header('Location: ../logout.php');
    exit();
}

$userId = $_SESSION['userId']; // ID del estudiante desde la sesión

// Obtener los datos actuales del estudiante
$query = "SELECT firstName, lastName, email, phoneNo FROM tblstudent WHERE Id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc(); // Obtener los datos del estudiante
} else {
    echo "<script>alert('No se encontró información del estudiante.'); window.location.href = '../logout.php';</script>";
    exit();
}

// Procesar la actualización del perfil
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phoneNo = $_POST['phoneNo'];

    // Actualizar la información del estudiante
    $updateQuery = "UPDATE tblstudent SET firstName = ?, lastName = ?, email = ?, phoneNo = ? WHERE Id = ?";
    $updateStmt = $conexion->prepare($updateQuery);
    $updateStmt->bind_param("ssssi", $firstName, $lastName, $email, $phoneNo, $userId);

    if ($updateStmt->execute()) {
        echo "<script>alert('Perfil actualizado correctamente.'); window.location.href = 'actualizar_perfil.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar el perfil.');</script>";
    }
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

<div class="form-container">
    <h2>Actualizar Perfil</h2>
    <form method="POST">
        <label for="firstName">Nombre</label>
        <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($student['firstName']); ?>" required>

        <label for="lastName">Apellido</label>
        <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($student['lastName']); ?>" required>

        <label for="email">Correo Electrónico</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>

        <label for="phoneNo">Número de Teléfono</label>
        <input type="text" id="phoneNo" name="phoneNo" value="<?php echo htmlspecialchars($student['phoneNo']); ?>" required>

        <button type="submit">Actualizar</button>
    </form>
</div>

<style>
    /* Contenedor del formulario */
    .form-container {
        max-width: 500px;
        width: 100%;
        margin: 0 auto;
        background: #ffffff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    /* Título */
    .form-container h2 {
        text-align: center;
        font-size: 24px;
        color: #0d47a1;
        margin-bottom: 20px;
    }

    /* Etiquetas */
    label {
        display: block;
        font-size: 14px;
        color: #333;
        margin-bottom: 8px;
    }

    /* Campos de entrada */
    input {
        width: 100%;
        padding: 12px;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
        box-sizing: border-box;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    input:focus {
        border-color: #0d47a1;
        outline: none;
        box-shadow: 0 0 5px rgba(13, 71, 161, 0.2);
    }

    /* Botón */
    button {
        width: 100%;
        padding: 12px 15px;
        background-color: #0d47a1;
        color: white;
        font-size: 16px;
        font-weight: bold;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    button:hover {
        background-color: #1565c0;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Responsivo */
    @media (max-width: 768px) {
        .form-container {
            padding: 20px;
        }

        .form-container h2 {
            font-size: 20px;
        }

        input {
            font-size: 14px;
        }

        button {
            font-size: 14px;
        }
    }
</style>


</body>
</html>

