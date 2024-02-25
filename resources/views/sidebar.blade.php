<!-- Sidebar wrapper start -->
<nav id="sidebar" class="sidebar-wrapper">

<!-- App brand starts -->
<div class="app-brand px-3 py-3 d-flex justify-content-center">
    <a href="{{ url('/') }}">
        <img src="{{asset('assets/images/logooo.png')}}" style="border-radius:32px;" class="logo" alt="Logo Hotel" />
    </a>
</div>
<!-- App brand ends -->

<!-- Sidebar profile starts -->
<div class="sidebar-user-profile">
    @if(Auth::user()->foto != "")
        <img src="{{URL::asset('img/usuarios/'.Auth::user()->foto)}}" style="width: 75px !important; height: 60px !important;" class="profile-thumb rounded-2 p-2 d-lg-flex d-none" alt="Usuario Imagen" />
    @else
        <img src="{{asset('assets/images/profile.png')}}" style="width: 90px !important; height: 85px !important;" class="profile-thumb rounded-2 p-2 d-lg-flex d-none" alt="Usuario Imagen" />
    @endif
    <h5 class="profile-name lh-lg mt-2 text-truncate">{{Auth::user()->usuario}}</h5>
</div>

<!-- Sidebar profile ends -->

<!-- Sidebar menu starts -->
<div class="sidebarMenuScroll">
    <ul class="sidebar-menu">
        <li @if($ruta == '/') class="active current-page" @endif>
            <a href="{{ url('/') }}">
                <i class="fas fa-home"></i>
                <span class="menu-text">Inicio</span>
            </a>
        </li>
        <li @if($ruta == 'recepcion') class="active current-page" @endif>
            <a href="{{ url('recepcion') }}">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span class="menu-text">Recepción</span>
            </a>
        </li>
        
        <li @if($ruta == 'historial') class="active current-page" @endif>
            <a href="{{ url('recepcion/historial') }}">
                <i class="fa-solid fa-table-list"></i>
                <span class="menu-text">Historial</span>
            </a>
        </li>

        <li @if($ruta == 'habitaciones' || $ruta == 'categorias' || $ruta == 'ubicaciones') class="treeview active" @else class="treeview" @endif>
            <a href="#!">
                <i class="fa-solid fa-database"></i>
                <span class="menu-text">Mant. Habitaciones</span>
            </a>
            <ul class="treeview-menu">
                <li @if($ruta == 'habitaciones') class="submenu-active" @endif>
                    <a href="{{ url('habitaciones') }}">Habitaciones</a>
                </li>
                <li @if($ruta == 'categorias') class="submenu-active" @endif>
                    <a href="{{ url('categorias') }}">Categorías</a>
                </li>
                <li @if($ruta == 'ubicaciones') class="submenu-active" @endif>
                    <a href="{{ url('ubicaciones') }}">Ubicaciones</a>
                </li>
            </ul>
        </li>
        <li @if($ruta == 'clientes') class="active current-page" @endif>
            <a href="{{ url('clientes') }}">
                <i class="fa-solid fa-users"></i>
                <span class="menu-text">Clientes</span>
            </a>
        </li>

        <li @if($ruta == 'usuarios') class="active current-page" @endif>
            <a href="{{ url('usuarios') }}">
                <i class="fa-solid fa-user"></i>
                <span class="menu-text">Usuario</span>
            </a>
        </li>

        <li @if($ruta == 'configuraciones') class="active current-page" @endif>
            <a href="{{ url('configuraciones') }}">
                <i class="fa-solid fa-gears"></i>
                <span class="menu-text">Configuración</span>
            </a>
        </li>

        <li @if($ruta == 'reportes') class="active current-page" @endif>
            <a href="{{ url('reportes') }}">
                <i class="fa-solid fa-file-invoice"></i>
                <span class="menu-text">Reportes</span>
            </a>
        </li>
    </ul>
</div>
<!-- Sidebar menu ends -->

</nav>
<!-- Sidebar wrapper end -->