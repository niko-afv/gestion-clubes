<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <img alt="image" class="rounded-circle" src="{{ url('images/avatar.jpeg') }}" width="48"/>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="block m-t-xs">
                                <strong class="font-bold">{{ Auth::user()->email }}</strong>
                            </span> <span class="text-muted text-xs block">Director <b class="caret"></b></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a class="logout" href="{{ route('profile') }}">Ver mi perfil</a></li>
                        <li><a class="logout" href="#">Mensajes</a></li>
                        <li class="dropdown-divider"></li>
                        <li><a class="logout" href="#">Salir</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
            <li class="{{ isActiveRoute('main') }}">
                <a href="{{ route('clubes_list') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Clubes</span></a>
            </li>
            <li class="{{ isActiveRoute('minor') }}">
                <a href="{{ url('/minor') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Eventos</span> </a>
            </li>
        </ul>

    </div>
</nav>
