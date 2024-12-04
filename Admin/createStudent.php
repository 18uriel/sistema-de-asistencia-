<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

function getCourseNames($conn) {
    $sql = "SELECT courseCode,name FROM tblcourse";
    $result = $conn->query($sql);

    $courseNames = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $courseNames[] = $row;
        }
    }

    return $courseNames;
}
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

if(isset($_POST['addStudent'])){
  $firstName=$_POST['firstName'];
  $lastName=$_POST['lastName'];
  $email=$_POST['email'];
  $registrationNumber=$_POST['registrationNumber'];
  $courseCode=$_POST['course'];
  $faculty=$_POST['faculty'];
  $password = md5($_POST['password']);
  $dateRegistered = date("Y-m-d");
  $capturedImage1 = $_POST['capturedImage1'];
  $capturedImage2 = $_POST['capturedImage2'];
  $base64Data1 = explode(',', $capturedImage1)[1];
  $base64Data2 = explode(',', $capturedImage2)[1];
  $imageData1 = base64_decode($base64Data1);
  $imageData2 = base64_decode($base64Data2);
  $registrationNumber = mysqli_real_escape_string($conn, $_POST['registrationNumber']);
  $folderPath = "../Lecture/labels/{$registrationNumber}/";
  if (!file_exists($folderPath)) {
      mkdir($folderPath, 0777, true);
  }
  file_put_contents($folderPath . '1.png', $imageData1);
  file_put_contents($folderPath . '2.png', $imageData2);

    $query=mysqli_query($conn,"select * from tblstudent where registrationNumber ='$registrationNumber'");
    $ret=mysqli_fetch_array($query);

    if($ret > 0){ 

        $message = "Student with the give Registration No: $registrationNumber Exists!";
    }
    else{

    $query=mysqli_query($conn,"insert into tblstudent(firstName,lastName,email,registrationNumber,faculty,courseCode,password,studentImage1,studentImage2,dateRegistered) 
    value('$firstName','$lastName','$email','$registrationNumber','$faculty','$courseCode','$password', '$registrationNumber" . "_image1.png', '$registrationNumber" . "_image2.png','$dateRegistered')");

    $message = " Student : $registrationNumber Added Successfully";

    if ($query) {
        
            
    }
    else
    {
    }
  }
}

  if(isset($_POST['update'])){
    
  $firstName=$_POST['firstName'];
  $lastName=$_POST['lastName'];
  $email=$_POST['email'];

  $registrationNumber=$_POST['registrationNumber'];
  $classId=$_POST['classId'];
  $classArmId=$_POST['classArmId'];
  $dateCreated = date("Y-m-d");

 $query=mysqli_query($conn,"update tblstudent set firstName='$firstName', lastName='$lastName',
    email='$email', registrationNumber='$registrationNumber',password='12345', classId='$classId',classArmId='$classArmId'
    where Id='$Id'");
            if ($query) {
                
                echo "<script type = \"text/javascript\">
                window.location = (\"createStudents.php\")
                </script>"; 
            }
            else
            {
                $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
            }
        }
    
  if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "delete")
	{
        $Id= $_GET['Id'];
        $classArmId= $_GET['classArmId'];

        $query = mysqli_query($conn,"DELETE FROM tblstudent WHERE Id='$Id'");

        if ($query == TRUE) {

            echo "<script type = \"text/javascript\">
            window.location = (\"createStudents.php\")
            </script>";
        }
        else{

            $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>"; 
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css" rel="stylesheet">
  <script src="./javascript/addStudent.js"></script>   
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
<?php include 'includes/topbar.php';?>

  <section class=main>
      
      <?php include "Includes/sidebar.php";?>
       
   <div class="main--content"> 
   <div id="overlay"></div>
   <div id="messageDiv" class="messageDiv" style="display:none;"></div>

   <div class="table-container">
           
                <div class="title" id="addStudent">
                    <h2 class="section--title">Estudiantes</h2>
                    <button class="add"><i class="ri-add-line"></i>Agreagar Estudiantes</button>
                </div>
                
                <div class="table">
                    <table>
                        <thead >
                            <tr>
                                <th>Codigo</th>
                                <th>Nombres y Apellidos</th>
                                <th>Semestre </th>
                                <th>Telefono</th>
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
                            echo "<td>" . $row["Id"] . "</td>";
                            echo "<td>" . $row["firstName"] . "</td>";
                            echo "<td>" . $row["faculty"] . "</td>";
                            echo "<td>" . $row["phoneNo"] . "</td>";
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
            <div class="formDiv--" id="addStudentForm" style="display:none;"> 

                <form method="post"   >
                <div style="display:flex; justify-content:space-around;">
                    <div class="form-title">
                        <p>Agregar estudiantes</p>
                    </div>
                    <div>
                        <span class="close">&times;</span>
                    </div>
                </div>
                  <div>
                      <div>
                        <input type="text"  name="firstName" value="<?php echo $row['firstName'];?>" placeholder="Nombres" > 
                        <input type="text"  name="lastName" value="<?php echo $row['lastName'];?>" placeholder="Apellidos" >
                        <input type="email"  name="email" value="<?php echo $row['email'];?>" placeholder="Email ">
                        <input type="password" name="password" placeholder="Contraseña" required>
                        <input type="text"  required name="registrationNumber" value="<?php echo $row['registrationNumber'];?>" placeholder="Numero de registro">
                        <select required name="faculty">
                        <option value="" selected>Selecionar Semestre</option>
                        <?php
                        $facultyNames = getFacultyNames($conn);
                        foreach ($facultyNames as $faculty) {
                            echo '<option value="' . $faculty["facultyCode"] . '">' . $faculty["facultyName"] . '</option>';
                        }
                        ?>
                    </select>  <br/>

                        <select required name="course">
                                <option value="" selected>Seleccionar Curso</option>
                                <?php
                                $courseNames = getCourseNames($conn);
                                foreach ($courseNames as $course) {
                                    echo '<option value="' . $course["courseCode"] . '">' . $course["name"] . '</option>';
                                }
                                ?>
                            </select>          
                      </div>
                        <div>
                        <div class="form-title-image">
                        <p >Tomar fotografias del estudiante<p>
                         </div>
                   
                      <div class="image-box" onclick="openCamera('button1');">
                        <img src="img/default.png" alt="Default Image" id="button1-captured-image">
                                      <div class="edit-icon">
                                          <i class="fas fa-camera" onclick="openCamera('button1');"></i>
                                      </div>
                                      <input type="hidden" id="button1-captured-image-input" name="capturedImage1" />
                        </div>
                        <div class="image-box" onclick="openCamera('button2')">
                            <img src="img/default.png" alt="Default Image" id="button2-captured-image">
                            <div class="edit-icon">
                                <i class="fas fa-camera" onclick="openCamera('button2')"></i>
                            </div>
                            <input type="hidden" id="button2-captured-image-input" name="capturedImage2" />
                        </div>

                      </div> 
                  </div>
                      <?php
                    if (isset($Id))
                    {
                    ?>
                    <button type="submit" name="update" >Actualizar</button>
                   
                                    
                  
                  <?php
                    } else {           
                    ?>
                    <input type="submit" class="btn-submit" value="Save Student" name="addStudent" />
                    <?php
                    }         
                    ?> 

                  </form>
              </div>
          
 </section>
 <script src="javascript/main.js"></script>
<script>
    const addStudent=document.getElementById('addStudent');
    const addStudentForm=document.getElementById("addStudentForm");
    addStudent.addEventListener("click",function(){
        addStudentForm.style.display = "block";
        overlay.style.display="block";
        addStudentForm.style.overflowY = 'scroll'; 
        document.body.style.overflow = 'hidden'; 

    
    })
    var closeButtons = document.querySelectorAll(' #addStudentForm .close');
    
    closeButtons.forEach(function(closeButton) {
        closeButton.addEventListener('click', function() {
            addStudentForm.style.display="none";
            overlay.style.display = 'none';
            document.body.style.overflow = 'auto'; 
        });
    });
</script>
<script src="./javascript/confirmation.js"></script>
<?php if(isset($message)){
    echo "<script>showMessage('" . $message . "');</script>";
} 
?>
</body>

</html>    