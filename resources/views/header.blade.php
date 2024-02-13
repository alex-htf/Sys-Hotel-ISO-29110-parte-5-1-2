	<!-- App header starts -->
    <div class="app-header d-flex align-items-center">

<!-- Toggle buttons start -->
<div class="d-flex">
    <button class="btn btn-primary me-2 toggle-sidebar" id="toggle-sidebar">
        <i class="bi bi-chevron-left fs-5"></i>
    </button>
    <button class="btn btn-primary me-2 pin-sidebar" id="pin-sidebar">
        <i class="bi bi-chevron-left fs-5"></i>
    </button>
</div>
<!-- Toggle buttons end -->

<!-- App brand sm start -->
<div class="app-brand-sm d-md-none d-sm-block">
    <a href="index.html">
        <img src="{{asset('assets/images/logo-sm.svg')}}" class="logo" alt="Bootstrap Gallery">
    </a>
</div>
<!-- App brand sm end -->

<!-- App header actions start -->
<div class="header-actions">
 
    <div class="dropdown ms-3">
        <a id="userSettings" class="dropdown-toggle d-flex py-2 align-items-center text-decoration-none"
            href="#!" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="d-none d-md-block me-2">{{Auth::user()->usuario}}</span>
            @if(Auth::user()->foto != "")
                <img src="{{URL::asset('img/usuarios/'.Auth::user()->foto)}}" class="rounded-circle img-3x" alt="Usuario Foto" />
            @else
                <img src="{{asset('assets/images/profile.png')}}" class="rounded-circle img-3x" alt="Usuario Foto" />
            @endif
        </a>
        <div class="dropdown-menu dropdown-menu-end shadow">
            <!-- <a class="dropdown-item d-flex align-items-center" href="profile.html"><i
                    class="bi bi-person fs-4 me-2"></i>Profile</a>
            <a class="dropdown-item d-flex align-items-center" href="settings.html"><i
                    class="bi bi-gear fs-4 me-2"></i>Account Settings</a> -->
            <a class="dropdown-item d-flex align-items-center" href="{{url('/logout')}}"><i
                    class="bi bi-escape fs-4 me-2"></i>Cerrar Sesión</a>
        </div>
    </div>
</div>
<!-- App header actions end -->

</div>
<!-- App header ends -->