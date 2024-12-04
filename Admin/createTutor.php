<?php 
include '../Includes/dbcon.php';
include '../Includes/session.php';

if (isset($_POST['submit'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $emailAddress = $_POST['emailAddress'];
    $phoneNo = $_POST['phoneNo'];
    $facultyCode = $_POST['facultyCode'];
    $password = md5($_POST['password']); // Encriptación de la contraseña
    $role = "Tutor"; // Rol fijo para tutores
    $dateCreated = date("Y-m-d H:i:s");

    // Verificar si el correo ya está registrado
    $query = "SELECT * FROM tbltutor WHERE emailAddress = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $emailAddress);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Este correo ya está registrado.');</script>";
    } else {
        // Insertar nuevo tutor
        $query = "INSERT INTO tbltutor (firstName, lastName, emailAddress, phoneNo, facultyCode, password, role, dateCreated) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssssss", $firstName, $lastName, $emailAddress, $phoneNo, $facultyCode, $password, $role, $dateCreated);

        if ($stmt->execute()) {
            echo "<script>alert('Tutor agregado exitosamente.'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('Ocurrió un error al agregar el tutor.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Tutor</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .main-container {
            max-width: 800px;
            margin: 50px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 5px;
            color: #555;
        }

        .form-group input, .form-group select {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            outline: none;
        }

        .form-group input:focus, .form-group select:focus {
            border-color: #0d47a1;
            box-shadow: 0 0 4px rgba(13, 71, 161, 0.3);
        }

        .btn-submit {
            background-color: #0d47a1;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #1565c0;
        }

        .btn-back {
            text-align: center;
            display: block;
            margin-top: 20px;
            color: #0d47a1;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
        }

        .btn-back:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <h2>Agregar Nuevo Tutor</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="firstName">Nombre:</label>
                <input type="text" id="firstName" name="firstName" placeholder="Ingrese el nombre del tutor" required>
            </div>
            <div class="form-group">
                <label for="lastName">Apellidos:</label>
                <input type="text" id="lastName" name="lastName" placeholder="Ingrese los apellidos del tutor" required>
            </div>
            <div class="form-group">
                <label for="emailAddress">Correo Electrónico:</label>
                <input type="email" id="emailAddress" name="emailAddress" placeholder="Ingrese el correo electrónico" required>
            </div>
            <div class="form-group">
                <label for="phoneNo">Número de Teléfono:</label>
                <input type="text" id="phoneNo" name="phoneNo" placeholder="Ingrese el número de teléfono" required>
            </div>
            <div class="form-group">
                <label for="facultyCode">Facultad:</label>
                <select id="facultyCode" name="facultyCode" required>
                    <option value="">Seleccione la Facultad</option>
                    <?php
                        $query = "SELECT * FROM tblfaculty";
                        $result = $conn->query($query);
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['facultyCode'] . "'>" . $row['facultyName'] . "</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" placeholder="Ingrese una contraseña" required>
            </div>
            <button type="submit" name="submit" class="btn-submit">Guardar Tutor</button>
        </form>
        <a href="index.php" class="btn-back">Volver al Dashboard</a>
    </div>
</body>
</html>