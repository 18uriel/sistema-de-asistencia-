<?php 
$fullName = ""; 

if (isset($_SESSION['userId'])) {
    $userId = $conn->real_escape_string($_SESSION['userId']);

    $query = "SELECT * FROM tbllecture WHERE Id = $userId";

    $rs = $conn->query($query);

    if ($rs) {
        $num = $rs->num_rows;

        if ($num > 0) {
            $row = $rs->fetch_assoc();

            $fullName = $row['firstName'] . " " . $row['lastName'];
            
        } else {
            echo "lecture not found";
        }
    } else {
        echo "Error: " . $conn->error;
    }
} else {
 header('location: ../index.php');
}

?>
<section class="header" style="display: flex; align-items: center; padding: 10px 20px;">
    <div class="logo" style="display: flex; align-items: center;">
        <img src="../img/finesi.png" alt="Logo" style="width: 60px; height: 60px; margin-right: 15px;"> <!-- Ajuste del tamaño y margen del logo -->
        <h2 style="margin: 0; font-size: 24px;">Asistencia M<span style="color: #1565c0;">s</span></h2> <!-- Ajuste del tamaño del texto -->
    </div>
    <div class="search--notification--profile" style="flex: 1; display: flex; justify-content: flex-end; align-items: center;">
        <div id="searchInput" class="search" style="margin-right: 20px;">
            <input type="text" id="searchText" placeholder="Buscar ....." style="padding: 5px 10px; border-radius: 5px; border: 1px solid #ddd;">
            <button onclick="searchItems()" style="background: none; border: none; cursor: pointer;"><i class="ri-search-2-line"></i></button>
        </div>
        <div class="notification--profile" style="display: flex; align-items: center;">
            <div class="picon lock" style="margin-right: 15px;">
                @ <?php echo $fullName; ?>
            </div>
            <div class="picon profile">
                <img src="../admin/img/user.png" alt="" style="width: 35px; height: 35px; border-radius: 50%;"> 
            </div>
        </div>
    </div>
</section>

<script>
function searchItems() {
    var input = document.getElementById('searchText').value.toLowerCase();
    var rows = document.querySelectorAll('table tr'); 

    rows.forEach(function(row) {
        var cells = row.querySelectorAll('td'); 
        var found = false;

        cells.forEach(function(cell) {
            if (cell.innerText.toLowerCase().includes(input)) { 
                found = true;
            }
        });

        if (found) {
            row.style.display = ''; 
        } else {
            row.style.display = 'none'; 
        }
    });
}
</script>
