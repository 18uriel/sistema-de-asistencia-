<?php 
include '../Includes/dbcon.php';
include '../Includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="img/logo/attnlg.png" rel="icon">
  <title>Dashboard</title>
  <link rel="stylesheet" href="css/styles.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css" rel="stylesheet">
</head>
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


<body>

  <!-- Top Bar -->
  <?php include 'includes/topbar.php';?>

  <section class="main">
    
    <!-- Sidebar -->
    <?php include 'includes/sidebar.php';?>

    <div class="main--content">
      
      <!-- Overview Section -->
      <div class="overview">
        <div class="title">
          <h2 class="section--title">Descripción General</h2>
          <select name="date" id="date" class="dropdown">
            <option value="today">Hoy</option>
            <option value="lastweek">Semana pasada</option>
            <option value="lastmonth">Mes pasado</option>
            <option value="lastyear">Año pasado</option>
            <option value="alltime">Todo el tiempo</option>
          </select>
        </div>

        <!-- Cards -->
        <div class="cards">
          <div class="card card-1">
            <?php 
              $query1 = mysqli_query($conn, "SELECT * FROM tblstudent");                       
              $students = mysqli_num_rows($query1);
            ?>
            <div class="card--data">
              <div class="card--content">
                <h5 class="card--title">Estudiantes Registrados</h5>
                <h1><?php echo $students; ?></h1>
              </div>
              <i class="ri-user-2-line card--icon--lg"></i>
            </div>
          </div>

          <div class="card card-1">
            <?php 
              $query1 = mysqli_query($conn, "SELECT * FROM tblunit");                       
              $unit = mysqli_num_rows($query1);
            ?>
            <div class="card--data">
              <div class="card--content">
                <h5 class="card--title">Unidades</h5>
                <h1><?php echo $unit; ?></h1>
              </div>
              <i class="ri-file-text-line card--icon--lg"></i>
            </div>
          </div>

          <div class="card card-1">
            <?php 
              $query1 = mysqli_query($conn, "SELECT * FROM tbllecture");                       
              $totalLecture = mysqli_num_rows($query1);
            ?>
            <div class="card--data">
              <div class="card--content">
                <h5 class="card--title">Docentes Registrados</h5>
                <h1><?php echo $totalLecture; ?></h1>
              </div>
              <i class="ri-user-line card--icon--lg"></i>
            </div>
          </div>
        </div>
      </div>

      <!-- Docentes Section -->
      <div class="table-container">
        <a href="createLecture.php" style="text-decoration:none;">
          <div class="title">
            <h2 class="section--title">Docentes</h2>
            <button class="add"><i class="ri-add-line"></i>Agregar docente</button>
          </div>
        </a>
        <div class="table">
          <table>
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Número de teléfono</th>
                <th>Estado</th>
                <th>Hora de clase</th>
                <th>Configuraciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $sql = "SELECT l.*, f.facultyName
                        FROM tbllecture l
                        LEFT JOIN tblfaculty f ON l.facultyCode = f.facultyCode";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["firstName"] . "</td>";
                    echo "<td>" . $row["emailAddress"] . "</td>";
                    echo "<td>" . $row["phoneNo"] . "</td>";
                    echo "<td>" . $row["facultyName"] . "</td>";
                    echo "<td>" . $row["dateCreated"] . "</td>";
                    echo "<td><span><i class='ri-edit-line edit'></i><i class='ri-delete-bin-line delete'></i></span></td>";
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

      <!-- Estudiantes Section -->
      <div class="table-container">
        <a href="createStudent.php" style="text-decoration:none;">
          <div class="title">
            <h2 class="section--title">Estudiantes</h2>
            <button class="add"><i class="ri-add-line"></i>Agregar estudiante</button>
          </div>
        </a>
        <div class="table">
          <table>
            <thead>
              <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Semestre</th>
                <th>Curso</th>
                <th>Email</th>
                <th>Configuraciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $sql = "SELECT * FROM tblstudent";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["registrationNumber"] . "</td>";
                    echo "<td>" . $row["firstName"] . "</td>";
                    echo "<td>" . $row["faculty"] . "</td>";
                    echo "<td>" . $row["courseCode"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td><span><i class='ri-edit-line edit'></i><i class='ri-delete-bin-line delete'></i></span></td>";
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

      <!-- Tutores Section -->
      <div class="table-container">
        <a href="createTutor.php" style="text-decoration:none;">
          <div class="title">
            <h2 class="section--title">Tutores</h2>
            <button class="add"><i class="ri-add-line"></i>Agregar Tutor</button>
          </div>
        </a>
        <div class="table">
          <table>
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Número de Teléfono</th>
                <th>Facultad</th>
                <th>Fecha de Registro</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $sql = "SELECT t.*, f.facultyName 
                        FROM tbltutor t
                        LEFT JOIN tblfaculty f ON t.facultyCode = f.facultyCode";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["firstName"] . " " . $row["lastName"] . "</td>";
                    echo "<td>" . $row["emailAddress"] . "</td>";
                    echo "<td>" . $row["phoneNo"] . "</td>";
                    echo "<td>" . $row["facultyName"] . "</td>";
                    echo "<td>" . $row["dateCreated"] . "</td>";
                    echo "<td><span><i class='ri-edit-line edit'></i><i class='ri-delete-bin-line delete'></i></span></td>";
                    echo "</tr>";
                  }
                } else {
                  echo "<tr><td colspan='6'>No se encontraron tutores registrados.</td></tr>";
                }
              ?>
            </tbody>
          </table>
        </div>
      </div>

      
      <!-- Curso Section -->
      <div class="table-container">
        <a href="createCourse.php" style="text-decoration:none;">
          <div class="title">
            <h2 class="section--title">Cursos</h2>
            <button class="add"><i class="ri-add-line"></i>Agregar Curso</button>
          </div>
        </a>
        <div class="table">
          <table>
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Semestre</th>
                <th>Total Unidades</th>
                <th>Total de Estudiantes</th>
                <th>Horario</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $sql = "SELECT 
                          c.name AS course_name,
                          c.facultyID AS faculty,
                          f.facultyName AS faculty_name,
                          COUNT(u.ID) AS total_units,
                          COUNT(DISTINCT s.Id) AS total_student,
                          c.dateCreated AS date_created
                        FROM tblcourse c
                        LEFT JOIN tblunit u ON c.ID = u.courseID
                        LEFT JOIN tblstudent s ON c.courseCode = s.courseCode
                        LEFT JOIN tblfaculty f ON c.facultyID = f.Id
                        GROUP BY c.ID";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["course_name"] . "</td>";
                    echo "<td>" . $row["faculty_name"] . "</td>";
                    echo "<td>" . $row["total_units"] . "</td>";
                    echo "<td>" . $row["total_student"] . "</td>";
                    echo "<td>" . $row["date_created"] . "</td>";
                    echo "<td><span><i class='ri-edit-line edit'></i><i class='ri-delete-bin-line delete'></i></span></td>";
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

    </div>
  </section>

  <script src="javascript/main.js"></script>
  <?php include 'includes/footer.php';?>

</body>

</html>