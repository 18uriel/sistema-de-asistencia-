<?php 
include '../Includes/dbcon.php';
include '../Includes/session.php';

error_reporting(0); // Ocultar errores

function getFacultyNames($conn) {
    $sql = "SELECT facultyCode, facultyName FROM tblfaculty";
    $result = $conn->query($sql);

    $facultyNames = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $facultyNames[] = $row;
        }
    }

    return $facultyNames;
}

// Eliminar Docente o Tutor
if (isset($_POST['deleteUser'])) {
    $userId = $_POST['userId'];
    $table = $_POST['userType'] === 'Docente' ? 'tbllecture' : 'tbltutor';
    $deleteQuery = "DELETE FROM $table WHERE Id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $userId);
    if ($stmt->execute()) {
        echo "<script>
            alert('Usuario eliminado correctamente.');
            window.location.href = 'createLecture.php'; // Redirigir al dashboard
        </script>";
    } else {
        echo "<script>alert('Error al eliminar el usuario.');</script>";
    }
}

// Actualizar Docente o Tutor
if (isset($_POST['updateUser'])) {
    $userId = $_POST['userId'];
    $firstName = $_POST['firstName'];
    $email = $_POST['email'];
    $phoneNo = $_POST['phoneNo'];
    $table = $_POST['userType'] === 'Docente' ? 'tbllecture' : 'tbltutor';
    $updateQuery = "UPDATE $table SET firstName = ?, emailAddress = ?, phoneNo = ? WHERE Id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("sssi", $firstName, $email, $phoneNo, $userId);
    if ($stmt->execute()) {
        echo "<script>
            alert('Usuario actualizado correctamente.');
            window.location.href = 'createLecture.php'; // Redirigir al dashboard
        </script>";
    } else {
        echo "<script>alert('Error al actualizar el usuario.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="img/logo/attnlg.png" rel="icon">
  <title>AMS - Dashboard</title>
  <link rel="stylesheet" href="css/styles.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css" rel="stylesheet">
  <style>
    /* Estilo general */
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f4f6f9;
      margin: 0;
      padding: 0;
      color: #333;
    }

    .main {
      display: flex;
      min-height: 100vh;
      justify-content: center;
      padding: 20px;
    }

    .main--content {
      width: 100%;
      max-width: 1250px;
      background-color: #fff;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .title h2 {
      font-size: 24px;
      margin-bottom: 15px;
      color: #34495E;
    }

    .dropdown {
      padding: 6px;
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-size: 13px;
      outline: none;
    }

    .dropdown:focus {
      border-color: #0056B3;
    }

    /* Cards */
    .cards {
      display: flex;
      gap: 20px;
      margin-top: 30px;
      justify-content: space-between;
      flex-wrap: wrap;
    }

    .card {
      background: #fff;
      flex: 1 1 30%;
      min-width: 280px;
      padding: 15px;
      border-radius: 8px;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
      text-align: center;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: translateY(-6px);
      box-shadow: 0 5px 12px rgba(0, 0, 0, 0.12);
    }

    .card--data {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 15px;
    }

    .card--title {
      font-size: 16px;
      color: #0056B3;
    }

    .card--content h1 {
      font-size: 32px;
      color: #2C3E50;
    }

    .card--icon--lg {
      font-size: 28px;
      color: #0056B3;
    }

    /* Tabla */
    .table-container {
      margin-top: 30px;
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
    }

    .table-container table {
      width: 100%;
      border-collapse: collapse;
    }

    .table-container th,
    .table-container td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    .table-container th {
      background-color: #0056B3;
      color: white;
    }

    .table-container tr:hover {
      background-color: #f9f9f9;
    }

    .table-container .title {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    /* Botón de agregar */
    .add {
      background-color: #0056B3;
      color: white;
      padding: 8px 16px;
      font-size: 14px;
      border-radius: 4px;
      text-align: center;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .add:hover {
      background-color: #337AB7;
    }

    /* Íconos de editar y eliminar */
    .edit,
    .delete {
      font-size: 18px;
      color: #0056B3;
      cursor: pointer;
      margin-right: 12px;
    }

    .edit:hover {
      color: #27AE60;
    }

    .delete:hover {
      color: #E74C3C;
    }
</style>

</head>
<body>
<?php include "Includes/topbar.php";?>
<section class="main">
    <?php include "Includes/sidebar.php";?>
    <div class="main--content">
        <!-- Sección de Docentes -->
        <div class="table-container">
            <a href="#add-form" style="text-decoration:none;">
                <div class="title" id="addLecture">
                    <h2 class="section--title">Docentes</h2>
                    <button class="add"><i class="ri-add-line"></i>Agregar Docente</button>
                </div>
            </a>
            <div class="table">
                <table>
                    <thead>
                        <tr>
                            <th>Nombres y Apellidos</th>
                            <th>Email</th>
                            <th>Número de celular</th>
                            <th>Semestre - Salón</th>
                            <th>Fecha de registro</th>
                            <th>Configuraciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM tbllecture";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["firstName"] . "</td>";
                                echo "<td>" . $row["emailAddress"] . "</td>";
                                echo "<td>" . $row["phoneNo"] . "</td>";
                                echo "<td>" . $row["facultyCode"] . "</td>";
                                echo "<td>" . $row["dateCreated"] . "</td>";
                                echo "<td>
                                    <button type='button' class='edit-btn' onclick='openEditForm(" . $row['Id'] . ", \"" . $row['firstName'] . "\", \"" . $row['emailAddress'] . "\", \"" . $row['phoneNo'] . "\", \"Docente\")'>
                                        <i class='ri-edit-line'></i>
                                    </button>
                                    <form method='POST' style='display:inline;'>
                                        <input type='hidden' name='userId' value='" . $row['Id'] . "'>
                                        <input type='hidden' name='userType' value='Docente'>
                                        <button type='submit' name='deleteUser' onclick='return confirm(\"¿Seguro que deseas eliminar este docente?\");'>
                                            <i class='ri-delete-bin-line'></i>
                                        </button>
                                    </form>
                                  </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No records found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sección de Tutores -->
        <div class="table-container">
            <a href="#add-form" style="text-decoration:none;">
                <div class="title" id="addTutor">
                    <h2 class="section--title">Tutores</h2>
                    <button class="add"><i class="ri-add-line"></i>Agregar Tutor</button>
                </div>
            </a>
            <div class="table">
                <table>
                    <thead>
                        <tr>
                            <th>Nombres y Apellidos</th>
                            <th>Email</th>
                            <th>Número de celular</th>
                            <th>Semestre - Salón</th>
                            <th>Fecha de registro</th>
                            <th>Configuraciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM tbltutor";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["firstName"] . "</td>";
                                echo "<td>" . $row["emailAddress"] . "</td>";
                                echo "<td>" . $row["phoneNo"] . "</td>";
                                echo "<td>" . $row["facultyCode"] . "</td>";
                                echo "<td>" . $row["dateCreated"] . "</td>";
                                echo "<td>
                                    <button type='button' class='edit-btn' onclick='openEditForm(" . $row['Id'] . ", \"" . $row['firstName'] . "\", \"" . $row['emailAddress'] . "\", \"" . $row['phoneNo'] . "\", \"Tutor\")'>
                                        <i class='ri-edit-line'></i>
                                    </button>
                                    <form method='POST' style='display:inline;'>
                                        <input type='hidden' name='userId' value='" . $row['Id'] . "'>
                                        <input type='hidden' name='userType' value='Tutor'>
                                        <button type='submit' name='deleteUser' onclick='return confirm(\"¿Seguro que deseas eliminar este tutor?\");'>
                                            <i class='ri-delete-bin-line'></i>
                                        </button>
                                    </form>
                                  </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No records found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Formulario de Edición -->
        <div id="editForm" style="display:none; position:fixed; top:20%; left:30%; background:white; padding:20px; border:1px solid black; z-index:1000;">
            <form method="POST">
                <input type="hidden" id="editUserId" name="userId">
                <input type="hidden" id="editUserType" name="userType">
                <label for="firstName">Nombre</label>
                <input type="text" id="editFirstName" name="firstName" required>
                <label for="email">Email</label>
                <input type="email" id="editEmail" name="email" required>
                <label for="phoneNo">Teléfono</label>
                <input type="text" id="editPhoneNo" name="phoneNo" required>
                <button type="submit" name="updateUser">Guardar Cambios</button>
                <button type="button" onclick="closeEditForm()">Cancelar</button>
            </form>
        </div>
    </div>
</section>

<script>
function openEditForm(id, firstName, email, phoneNo, userType) {
    document.getElementById('editUserId').value = id;
    document.getElementById('editUserType').value = userType;
    document.getElementById('editFirstName').value = firstName;
    document.getElementById('editEmail').value = email;
    document.getElementById('editPhoneNo').value = phoneNo;
    document.getElementById('editForm').style.display = 'block';
}

function closeEditForm() {
    document.getElementById('editForm').style.display = 'none';
}
</script>

</body>
</html>
