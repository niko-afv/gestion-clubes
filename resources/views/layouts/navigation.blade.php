<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                        <img alt="image" class="rounded-circle" src="{{ url('images/avatar.jpeg') }}" width="48" />
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="block m-t-xs font-bold">{{ Auth::user()->name }}</span>
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
            <li class="{{ isActiveRoute('') }}">
                <a href="{{ route('home') }}"><i class="fa fa-dashboard fa-2x"></i> <span class="nav-label">Principal</span></a>
            </li>

            @can('see-my-club')
                <li class="{{ isActiveRoute('/mi_club') }}">
                    <a href="{{ route('my_club') }}"><i class="fa fa-home fa-2x"></i> <span class="nav-label">Mi Club</span></a>
                </li>
            @endcan

            @can('see-my-field')
                <li class="{{ isActiveRoute('/mi_campo') }}">
                    <a href="{{ route('my_field') }}"><i class="fa fa-home fa-2x"></i> <span class="nav-label">Mi Campo</span></a>
                </li>
            @endcan

            @can('list-clubs')
            <li class="{{ isActiveRoute('/clubes') }}">
                <a href="{{ route('clubes_list') }}"><i class="fa fa-object-group fa-2x"></i> <span class="nav-label">Clubes</span></a>
            </li>
            @endcan

            @can('list-units')
                <li class="{{ isActiveRoute('/unidades') }}">
                    <a href="{{ route('unidades_list') }}"><i class="fa fa-users fa-2x"></i> <span class="nav-label">Unidades</span></a>
                </li>
            @endcan


            @can('list-events')
            <li class="{{ isActiveRoute('/eventos') }}">
                <a href="{{ route('events_list') }}"><i class="fa fa-bandcamp fa-2x"></i> <span class="nav-label">Eventos</span> </a>
            </li>
            @endcan

            @can('list-users')
                <li class="{{ isActiveRoute('/usuarios') }}">
                    <a href="{{ route('users_list') }}"><i class="fa fa-users fa-2x"></i> <span class="nav-label">Usuarios</span></a>
                </li>
            @endcan
        </ul>

    </div>
</nav>
