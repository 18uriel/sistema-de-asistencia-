<?php 
include '../Includes/dbcon.php';
include '../Includes/session.php';

function getFacultyNames($conn) {
    $sql = "SELECT Id, facultyName FROM tblfaculty";
    $result = $conn->query($sql);

    $facultyNames = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $facultyNames[] = $row;
        }
    }

    return $facultyNames;
}
function getLectureNames($conn) {
    $sql = "SELECT Id, firstName, lastName FROM tbllecture";
    $result = $conn->query($sql);

    $lectureNames = array();  
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $lectureNames[] = $row;
        }
    }

    return $lectureNames;
}
function getCourseNames($conn) {
    $sql = "SELECT ID,name FROM tblcourse";
    $result = $conn->query($sql);

    $courseNames = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $courseNames[] = $row;
        }
    }

    return $courseNames;
}

    if (isset($_POST["addCourse"])) {
        $courseName = $_POST["courseName"];
        $courseCode = $_POST["courseCode"];
        $facultyID = $_POST["faculty"];
        $dateRegistered = date("Y-m-d");

        $query=mysqli_query($conn,"select * from tblcourse where courseCode='$courseCode'");
        $ret=mysqli_fetch_array($query);
            if($ret > 0){ 
                $message = " Course Already Exists";
        }
        else{
                $query=mysqli_query($conn,"insert into tblcourse(name,courseCode,facultyID,dateCreated) 
            value('$courseName','$courseCode','$facultyID','$dateRegistered')");
            $message = " Course Inserted Successfully";

        }
       
    }
    if (isset($_POST["addUnit"])) {
        $unitName = $_POST["unitName"];
        $unitCode = $_POST["unitCode"];
        $courseID = $_POST["course"];
        $dateRegistered = date("Y-m-d");

        $query=mysqli_query($conn,"select * from tblunit where unitCode='$unitCode'");
        $ret=mysqli_fetch_array($query);
            if($ret > 0){ 
                $message = " Unit Already Exists";

        }
        else{
            $query=mysqli_query($conn,"insert into tblunit(name,unitCode,courseID,dateCreated) 
            value('$unitName','$unitCode','$courseID','$dateRegistered')");
            $message = " Unit Inserted Successfully";

        }
       
    
       
    }
    if (isset($_POST["addFaculty"])) {
        $facultyName = $_POST["facultyName"];
        $facultyCode = $_POST["facultyCode"];
        $dateRegistered = date("Y-m-d");

        $query=mysqli_query($conn,"select * from tblfaculty where facultyCode='$facultyCode'");
        $ret=mysqli_fetch_array($query);
            if($ret > 0){ 

                $message = " Faculty already Exists";}
        else{
            $query=mysqli_query($conn,"insert into tblfaculty(facultyName,facultyCode,dateRegistered) 
            value('$facultyName','$facultyCode','$dateRegistered')");
            $message = " Faculty Inserted Successfully";

        }
       
       
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="img/logo/attnlg.png" rel="icon">
  <title>Panel de Control</title>
  <link rel="stylesheet" href="css/styles.css">
 <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css" rel="stylesheet">
 <script src="./javascript/confirmation.js" defer></script>
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
<?php include 'includes/topbar.php'?>
<section class="main">
<?php include 'includes/sidebar.php';?>
 <div class="main--content">
    <div id="overlay"></div>
 <div class="overview">
                <div class="title">
                    <h2 class="section--title">Descripcion General</h2>
                    <select name="date" id="date" class="dropdown">
                        <option value="today">Hoy</option>
                        <option value="lastweek">Semana Pasada</option>
                        <option value="lastmonth">Mes Pasado</option>
                        <option value="lastyear">Año Pasado</option>
                        <option value="alltime">Todo el Tiempo</option>
                    </select>
                </div>
                <div class="cards">
                    <div id="addCourse" class="card card-1">
                        <?php 
                        $query1=mysqli_query($conn,"SELECT * from tblcourse");                       
                        $courses = mysqli_num_rows($query1);
                        ?>
                        <div class="card--data">
                            <div class="card--content">
                            <button class="add"><i class="ri-add-line"></i>Agregar Curso</button>
                                <h1><?php echo $courses;?> Cursos</h1>
                            </div>
                            <i class="ri-user-2-line card--icon--lg"></i>
                        </div>
                       
                    </div>
                    <div class="card card-1" id="addUnit">
                        <?php 
                        $query1=mysqli_query($conn,"SELECT * from tblunit");                       
                        $unit = mysqli_num_rows($query1);
                        ?>
                        <div class="card--data" >
                            <div class="card--content">
                            <button class="add"><i class="ri-add-line"></i>Agregar Unidades</button>
                                <h1><?php echo $unit;?> Unidades</h1>
                            </div>
                            <i class="ri-file-text-line card--icon--lg"></i>
                        </div>
                        
                    </div>
                   
                    <div class="card card-1" id="addFaculty">
                        <?php 
                        $query1=mysqli_query($conn,"SELECT * from tblfaculty");                       
                        $faculty = mysqli_num_rows($query1);
                        ?>
                        <div class="card--data">
                            <div class="card--content">
                            <button class="add"><i class="ri-add-line"></i>Agregar Salones</button>
                                <h1><?php echo $faculty;?> Salones</h1> 
                            </div>
                            <i class="ri-user-line card--icon--lg"></i>
                        </div>
                       
                    </div>
                </div>
            </div>
            <div id="messageDiv" class="messageDiv" style="display:none;"></div>

            <div class="table-container">
                <div class="title">
                    <h2 class="section--title">Curso</h2>
                </div>
                </a>
                <div class="table">
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Salon</th>
                                <th>Total de unidades</th>
                                <th>Total de estudiantes</th>
                                <th>Fecha de creacion</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql = "SELECT 
                        c.name AS course_name,
                        c.facultyID AS faculty,
                        f.facultyName AS faculty_name,
                        COUNT(u.ID) AS total_units,
                        COUNT(DISTINCT s.Id) AS total_students,
                        c.dateCreated AS date_created
                        FROM tblcourse c
                        LEFT JOIN tblunit u ON c.ID = u.courseID
                        LEFT JOIN tblstudents s ON c.courseCode = s.courseCode
                        LEFT JOIN tblfaculty f on c.facultyID=f.Id
                        GROUP BY c.ID";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["course_name"] . "</td>";
                            echo "<td>" . $row["faculty_name"] . "</td>";
                            echo "<td>" . $row["total_units"] . "</td>";
                            echo "<td>" . $row["total_students"] . "</td>";
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
            <div class="table-container">
                <div class="title">
                    <h2 class="section--title">Unidad</h2>
                </div>
                </a>
                <div class="table">
                    <table>
                        <thead>
                            <tr>
                                <th>Codigo de Unidad</th>
                                <th>Nombre</th>
                                <th>Curso</th>
                                <th>Total de estudiantes</th>
                                <th>Fecha de creacion</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $sql = "SELECT 
                            c.name AS course_name,
                            u.unitCode AS unit_code,
                            u.name AS unit_name,
                            u.dateCreated AS date_created,
                            COUNT(s.Id) AS total_students
                            FROM tblunit u
                            LEFT JOIN tblcourse c ON u.courseID = c.ID
                            LEFT JOIN tblstudents s ON c.courseCode = s.courseCode
                            GROUP BY u.ID";                       
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["unit_code"] . "</td>";
                            echo "<td>" . $row["unit_name"] . "</td>";
                            echo "<td>" . $row["course_name"] . "</td>";
                            echo "<td>" . $row["total_students"] . "</td>";
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
            <div class="table-container">
                <div class="title">
                    <h2 class="section--title">Salon</h2>
                </div>
                </a>
                <div class="table">
                    <table>
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Nombre</th>
                                <th>Total de cursos</th>
                                <th>Total de estudiantes</th>
                                <th>Total Matriculados</th>
                                <th>Fecha de creacion</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                           $sql = "SELECT 
                           f.facultyName AS faculty_name,
                           f.facultyCode AS faculty_code,
                           f.dateRegistered AS date_created,
                           COUNT(DISTINCT c.ID) AS total_courses,
                           COUNT(DISTINCT s.Id) AS total_students,
                           COUNT(DISTINCT l.Id) AS total_lectures
                       FROM tblfaculty f
                       LEFT JOIN tblcourse c ON f.Id = c.facultyID
                       LEFT JOIN tblstudents s ON f.facultyCode = s.faculty
                       LEFT JOIN tbllecture l ON f.facultyCode = l.facultyCode
                       GROUP BY f.Id";
                                     
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                           while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["faculty_code"] . "</td>";
                            echo "<td>" . $row["faculty_name"] . "</td>";
                            echo "<td>" . $row["total_courses"] . "</td>";
                            echo "<td>" . $row["total_students"] . "</td>";
                            echo "<td>" . $row["total_lectures"] . "</td>";
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
 <div class="formDiv" id="addCourseForm"  style="display:none; ">
        
<form method="POST" action="" name="addCourse" enctype="multipart/form-data">
    <div style="display:flex; justify-content:space-around;">
        <div class="form-title">
            <p>Agregar Cursos</p>
        </div>
        <div>
            <span class="close">&times;</span>
        </div>
    </div>

    <input type="text" name="courseName" placeholder="Course Name" required>
    <input type="text" name="courseCode" placeholder="Course Code" required>


    <select required name="faculty">
        <option value="" selected>Seleccionar Salon</option>
        <?php
        $facultyNames = getFacultyNames($conn);
        foreach ($facultyNames as $faculty) {
            echo '<option value="' . $faculty["Id"] . '">' . $faculty["facultyName"] . '</option>';
        }
        ?>
    </select>

    <input type="submit" class="submit" value="Save Course" name="addCourse">
</form>		  
    </div>

<div class="formDiv" id="addUnitForm"  style="display:none; ">
<form method="POST" action="" name="addUnit" enctype="multipart/form-data">
    <div style="display:flex; justify-content:space-around;">
        <div class="form-title">
            <p>Agregar Unidades</p>
        </div>
        <div>
            <span class="close">&times;</span>
        </div>
    </div>

    <input type="text" name="unitName" placeholder="Unit Name" required>
    <input type="text" name="unitCode" placeholder="Unit Code" required>

    <select required name="lecture">
        <option value="" selected>Assign Lecture</option>
        <?php
        $lectureNames = getLectureNames($conn);
        foreach ($lectureNames as $lecture) {
            echo '<option value="' . $lecture["Id"] . '">' . $lecture["firstName"] . ' ' . $lecture["lastName"]  .  '</option>';
        }
        ?>
    </select>
    <select required name="course">
        <option value="" selected>Seleccionar curso</option>
        <?php
        $courseNames = getCourseNames($conn);
        foreach ($courseNames as $course) {
            echo '<option value="' . $course["ID"] . '">' . $course["name"] . '</option>';
        }
        ?>
    </select>

    <input type="submit" class="submit" value="Save Unit" name="addUnit">
</form>		  
 </div>
    
<div class="formDiv" id="addFacultyForm"  style="display:none; ">
<form method="POST" action="" name="addFaculty" enctype="multipart/form-data">
    <div style="display:flex; justify-content:space-around;">
        <div class="form-title">
            <p>Agregar Salon</p>
        </div>
        <div>
            <span class="close">&times;</span>
        </div>
    </div>
    <input type="text" name="facultyName" placeholder="Faculty Name" required>
    <input type="text" name="facultyCode" placeholder="Faculty Code" required>
    <input type="submit" class="submit" value="Save Faculty" name="addFaculty">
</form>		  
</div>
      
      

</section>
<script src="javascript/main.js"></script>
<script src="javascript/addCourse.js"></script>
<script src="javascript/confirmation.js"></script>
<?php if(isset($message)){
    echo "<script>showMessage('" . $message . "');</script>";
} 
?>
</body>
</html>


        
      
