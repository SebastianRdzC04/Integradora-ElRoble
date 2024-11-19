<!-- Botón para abrir el menú -->
<style>
    #sidebar {
            width: 280px;
            max-width: 80%;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            color: white;
            z-index: 1050;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        #sidebar.open {
            transform: translateX(0);
        }

        #closeSidebarBtn {
            position: absolute;
            top: 10px;
            right: 10px;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }

        #openSidebarBtn {
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 1100;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
</style>


     <button id="openSidebarBtn">C</button>
     
     <!-- Menú lateral (sidebar) -->
     <div id="sidebar" class="d-flex flex-column p-3">
    <span id="closeSidebarBtn">&times;</span>
    <a href="/" class="d-flex align-items-center mb-3 text-white text-decoration-none row">
        <span class="fs-4">{{Auth::user()->person->firstName}}</span>
        <span class="fs-normal">{{Auth::user()->roles->first()->name}}</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="#" class="nav-link text-white">Inicio</a>
        </li>
        <li>
            <a href="{{route('event.today')}}" class="nav-link text-white">Evento</a>
        </li>
        <li>
            <a href="#" class="nav-link text-white">Eventos proximos</a>
        </li>
        <li>
            <a href="#" class="nav-link text-white">Registro de incidencia</a>
        </li>
        <li>
            <a href="#" class="nav-link text-white">Incidencias reportadas</a>
        </li>
    </ul>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const sidebar = document.getElementById('sidebar');
const openSidebarBtn = document.getElementById('openSidebarBtn');
const closeSidebarBtn = document.getElementById('closeSidebarBtn');

//abre y cierra el modal
openSidebarBtn.addEventListener('click', () => {
    sidebar.classList.add('open');
});

closeSidebarBtn.addEventListener('click', () => {
    sidebar.classList.remove('open');
});
</script>