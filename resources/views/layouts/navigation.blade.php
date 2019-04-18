<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                        <img alt="image" class="rounded-circle" src="{{ url('images/avatar.jpeg') }}" width="48" />
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="block m-t-xs font-bold">{{ Auth::user()->email }}</span>
                            <span class="text-muted text-xs block">{{ Auth::user()->profile->name }}<b class="caret"></b></span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a class="" href="{{ route('profile') }}">Ver mi perfil</a></li>
                            <li class="dropdown-divider"></li>
                            <li><a class="dropdown-item logout" href="#">Salir</a></li>
                        </ul>
                    </div>
                <div class="logo-element">
                    AMCH
                </div>
            </li>
            @if(Auth::user()->profile->id <= 3)
            <li class="{{ isActiveRoute('clubes_list') }}">
                <a href="{{ route('clubes_list') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Clubes</span></a>
            </li>
            @endif

            <li class="{{ isActiveRoute('events_list') }}">
                <a href="{{ route('events_list') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Eventos</span> </a>
            </li>
        </ul>

    </div>
</nav>
