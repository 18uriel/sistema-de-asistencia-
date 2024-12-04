<div class="sidebar">
            <ul class="sidebar--items">
                <li>
                    <a href="index.php">
                        <span class="icon icon-1"><i class="ri-layout-grid-line"></i></span>
                        <span class="sidebar--item">Panel de Control</span>
                    </a>
                </li>
                <li>
                    <a href="createCourse.php">
                        <span class="icon icon-1"><i class="ri-file-text-line"></i></span>
                        <span class="sidebar--item">Administrar Cursos</span>
                    </a>
                </li>
                <li>
                    <a href="createVenue.php">
                        <span class="icon icon-1"><i class="ri-map-pin-line"></i></span>
                        <span class="sidebar--item" style="white-space: nowrap;">Crear Salon</span>
                    </a>
                </li>
                <li>
                    <a href="createLecture.php">
                        <span class="icon icon-1"><i class="ri-user-line"></i></span>
                        <span class="sidebar--item">Administrar Docentes</span>
                    </a>
                </li>
                <li>
                    <a href="createStudent.php">
                        <span class="icon icon-1"><i class="ri-user-line"></i></span>
                        <span class="sidebar--item">Administrar Estudiantes</span>
                    </a>
                </li>
                
            </ul>
            <ul class="sidebar--bottom-items">
                <li>
                    <a href="#">
                        <span class="icon icon-2"><i class="ri-settings-3-line"></i></span>
                        <span class="sidebar--item">Configuraciones</span>
                    </a>
                </li>
                <li>
                    <a href="../logout.php">
                        <span class="icon icon-2"><i class="ri-logout-box-r-line"></i></span>
                        <span class="sidebar--item">Salir</span>
                    </a>
                </li>
            </ul>
        </div>
        

        <script>
        document.addEventListener("DOMContentLoaded", function() {
        var currentUrl = window.location.href;
        var links = document.querySelectorAll('.sidebar a');
        links.forEach(function(link) {
            if (link.href === currentUrl) {
                link.id = 'active--link';
            }
        });
    });
</script>
