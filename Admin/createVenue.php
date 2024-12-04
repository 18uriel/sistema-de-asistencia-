<?php 
include '../Includes/dbcon.php';
include '../Includes/session.php';

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
if (isset($_POST["addVenue"])) {
    $className = $_POST["className"];
    $facultyCode = $_POST["faculty"];
    $currentStatus = $_POST["currentStatus"];
    $capacity=$_POST["capacity"];
    $classification=$_POST["classification"];
    $faculty=$_POST["faculty"];
    $dateRegistered = date("Y-m-d");

    $query=mysqli_query($conn,"select * from tblvenue where className='$className'");
    $ret=mysqli_fetch_array($query);
        if($ret > 0){ 
            $message = " Venue Already Exists";
    }
    else{
            $query=mysqli_query($conn,"insert into tblvenue(className,facultyCode,currentStatus,capacity,classification,dateCreated) 
        value('$className','$facultyCode','$currentStatus','$capacity','$classification','$dateRegistered')");
        $message = " Venue Inserted Successfully";

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
  <title>Dashboard</title>
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
<?php include 'includes/topbar.php'?>
<section class="main">
<?php include 'includes/sidebar.php';?>
 <div class="main--content">

 <div id="overlay"></div>

 <div class="rooms">
                <div class="title">
                    <h2 class="section--title">Salones</h2>
                    <div class="rooms--right--btns">
                        <select name="date" id="date" class="dropdown room--filter">
                            <option >Filtro</option>
                            <option value="free">Free</option>
                            <option value="scheduled">Scheduled</option>
                        </select>
                        <button id="addClass1" class="add"><i class="ri-add-line"></i>Agregar salones</button>
                    </div>
                </div>
                <div class="rooms--cards">
                    <a href="#" class="room--card">
                        <div class="img--box--cover">
                            <div class="img--box">
                            <img src="img/office image.jpeg" alt="">
                            </div>
                        </div>
                        <p class="free">TALLERES</p>
                    </a>
                    <a href="#" class="room--card">
                        <div class="img--box--cover">
                            <div class="img--box">
                            <img src="img/class.jpeg" alt="">
                            </div>
                        </div>
                        <p class="free">CLASES</p>
                    </a>
                    
                    <a href="#" class="room--card">
                        <div class="img--box--cover">
                            <div class="img--box">
                                <img src="img/lecture hall.jpeg" alt="">
                            </div>
                        </div>
                        <p class="free">CLASES VIRTUALES</p>
                    </a>
                   
                    <a href="#" class="room--card">
                        <div class="img--box--cover">
                            <div class="img--box">
                            <img src="img/computer lab.jpeg" alt="">
                            </div>
                        </div>
                        <p class="free">LABORATORIOS - PABELLON 1 </p>
                    </a>
                    <a href="#" class="room--card">
                        <div class="img--box--cover">
                            <div class="img--box">
                            <img src="img/laboratory.jpeg" alt="">
                            </div>
                        </div>
                        <p class="free">LABORATORIO - PABELLON 2 </p>
                    </a>
                </div>
            </div>
            <div id="messageDiv" class="messageDiv" style="display:none;"></div>

            <div class="table-container">
            <div class="title" id="addClass2">
                    <h2 class="section--title">Lecture Rooms</h2>
                    <button class="add"><i class="ri-add-line"></i>Agregar clase</button>
                </div>
        
                <div class="table">
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre de clases</th>
                                <th>Grupo</th>
                                <th>Estado Actual</th>
                                <th>Capacidad</th>
                                <th>Clasificacion</th>
                                <th>Configuraciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql = "SELECT * FROM tblvenue";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["className"] . "</td>";
                            echo "<td>" . $row["facultyCode"] . "</td>";
                            echo "<td>" . $row["currentStatus"] . "</td>";
                            echo "<td>" . $row["capacity"] . "</td>";
                            echo "<td>" . $row["classification"] . "</td>";
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
                
<div class="formDiv-venue" id="addClassForm"  style="display:none; ">
<form method="POST" action="" name="addVenue" enctype="multipart/form-data">
    <div style="display:flex; justify-content:space-around;">
        <div class="form-title">
            <p>Add Venue</p>
        </div>
        <div>
            <span class="close">&times;</span>
        </div>
    </div>
    <input type="text" name="className" placeholder="Nombre de clase" required>
    <select name="currentStatus" id="">
        <option value="">--Estado Actual--</option>
        <option value="availlable">Presencial</option>
        <option value="scheduled">Virtual</option>
    </select>
    <input type="text" name="capacity" placeholder="Capacidad" required>
    <select required name="classification">
      <option value="" selected> --Seleccionar semestre--</option>
      <option value="laboratory">Primero</option>
      <option value="computerLab">Segundo</option>
      <option value="lectureHall">Tercero </option>
      <option value="class">Cuarto</option>
      <option value="office">Quinto </option>
      <option value="office">Sexto</option>
      <option value="office">Septimo</option>
      <option value="office">Octavo</option>
      <option value="office">Noveno</option>
      <option value="office">Decimo</option>
    </select>
    <select required name="faculty">
        <option value="" selected>Select Faculty</option>
        <?php
        $facultyNames = getFacultyNames($conn);
        foreach ($facultyNames as $faculty) {
            echo '<option value="' . $faculty["facultyCode"] . '">' . $faculty["facultyName"] . '</option>';
        }
        ?>
    </select>
    <input type="submit" class="submit" value="Save Venue" name="addVenue">
</form>		  
</div>
 </div>
</section>
<script src="javascript/main.js"></script>
<script src="./javascript/confirmation.js"></script>
<?php if(isset($message)){
    echo "<script>showMessage('" . $message . "');</script>";
} 
?>
<script>
   
const addClass1 = document.getElementById('addClass1');
const addClass2 = document.getElementById('addClass2');
const addClassForm = document.getElementById('addClassForm');
const overlay = document.getElementById('overlay'); // Add this line to select the overlay element

addClass1.addEventListener('click', function () {
    addClassForm.style.display = 'block';
    overlay.style.display = 'block';
    document.body.style.overflow = 'hidden'; 

});

addClass2.addEventListener('click', function () {
    addClassForm.style.display = 'block';
    overlay.style.display = 'block';
    document.body.style.overflow = 'hidden'; 

});

var closeButtons = document.querySelectorAll('#addClassForm .close');

closeButtons.forEach(function (closeButton) {
    closeButton.addEventListener('click', function () {
        addClassForm.style.display = 'none';
        overlay.style.display = 'none';
        document.body.style.overflow = 'auto'; 

    });
});

</script>
</body>
</html>