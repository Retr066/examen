<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('empleado.home') }}">Gestionar Empleados</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('horario') }}">Gestionar
                        Horarios</a>
                </li>
            </ul>
        </div>
        <form class="d-flex">
            <input class="form-control me-2" id="buscar" type="search" placeholder="Buscar..." aria-label="Search">
        </form>

    </div>
</nav>
