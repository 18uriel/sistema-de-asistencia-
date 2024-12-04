<?php
include '../conexion.php';
session_start();

// Verificar si el usuario es tutor
if (!isset($_SESSION['userId']) || $_SESSION['userType'] != 'Tutor') {
    header('Location: ../logout.php');
    exit();
}

$tutorId = $_SESSION['userId'];

// Obtener la lista de estudiantes y cursos
$queryStudents = "SELECT * FROM tblstudent";
$queryCourses = "SELECT * FROM tblcourse";
$students = $conexion->query($queryStudents);
$courses = $conexion->query($queryCourses);

// Procesar asignación de estudiantes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_POST['student_id'];
    $courseId = $_POST['course_id'];

    $insertQuery = "INSERT INTO tutor_students (tutor_id, student_id, course_id) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($insertQuery);
    $stmt->bind_param("iii", $tutorId, $studentId, $courseId);

    if ($stmt->execute()) {
        echo "<script>alert('Estudiante asignado correctamente.'); window.location.href = 'asignar_estudiantes.php';</script>";
    } else {
        echo "<script>alert('Error al asignar estudiante.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Estudiantes</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        .container { max-width: 800px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); }
        h2 { text-align: center; color: #333; }
        form { display: flex; flex-direction: column; gap: 15px; }
        select, button { padding: 10px; border-radius: 5px; border: 1px solid #ddd; }
        button { background-color: #0d47a1; color: white; cursor: pointer; }
        button:hover { background-color: #1565c0; }
    </style>
</head>
<body>
<div class="container">
    <h2>Asignar Estudiantes a un Curso</h2>
    <form method="POST">
        <label for="student_id">Selecciona Estudiante:</label>
        <select name="student_id" id="student_id" required>
            <option value="">Seleccione un estudiante</option>
            <?php while ($row = $students->fetch_assoc()) { ?>
                <option value="<?php echo $row['Id']; ?>"><?php echo $row['firstName'] . " " . $row['lastName']; ?></option>
            <?php } ?>
        </select>

        <label for="course_id">Selecciona Curso:</label>
        <select name="course_id" id="course_id" required>
            <option value="">Seleccione un curso</option>
            <?php while ($row = $courses->fetch_assoc()) { ?>
                <option value="<?php echo $row['ID']; ?>"><?php echo $row['name']; ?></option>
            <?php } ?>
        </select>

        <button type="submit">Asignar</button>
    </form>
</div>
</body>
</html>
