@extends('layouts.app')

@section('content')
<div class="wrapper wrapper-content">
    <div class="row">

        @if(Auth::user()->profile->level >= 3)
        <div class="col-lg-3">
            <div class="ibox ">
                <div class="ibox-title">
                    <!--
                    <span class="label label-success float-right"></span>
                    -->
                    <h5>Miembros</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ Auth::user()->member->institutable->members()->count() }}</h1>
                    <!--
                    <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div>
                    -->
                    <small>Miembros registrados</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox ">
                <div class="ibox-title">
                    <!--
                    <span class="label label-success float-right"></span>
                    -->
                    <h5>Unidades</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ Auth::user()->member->institutable->units()->count() }}</h1>
                    <!--
                    <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div>
                    -->
                    <small>Unidades registradas</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox ">
                <div class="ibox-title">
                    <!--
                    <span class="label label-success float-right"></span>
                    -->
                    <h5>Eventos</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ 0 }}</h1>
                    <!--
                    <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div>
                    -->
                    <small>Participaciones en Eventos</small>
                </div>
            </div>
        </div>
        @else
            <div class="col-lg-3">
                <div class="ibox ">
                    <div class="ibox-title">
                        <!--
                        <span class="label label-success float-right"></span>
                        -->
                        <h5>Miembros</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ \App\Member::all()->count() }}</h1>
                        <!--
                        <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div>
                        -->
                        <small>Miembros registrados</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox ">
                    <div class="ibox-title">
                        <!--
                        <span class="label label-success float-right"></span>
                        -->
                        <h5>Clubes</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ \App\Club::all()->count() }}</h1>
                        <!--
                        <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div>
                        -->
                        <small>Clubes registrados</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox ">
                    <div class="ibox-title">
                        <!--
                        <span class="label label-success float-right"></span>
                        -->
                        <h5>Unidades</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ \App\Unit::all()->count() }}</h1>
                        <!--
                        <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div>
                        -->
                        <small>Unidades registradas</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox ">
                    <div class="ibox-title">
                        <!--
                        <span class="label label-success float-right"></span>
                        -->
                        <h5>Eventos</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ \App\Event::all()->count() }}</h1>
                        <!--
                        <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div>
                        -->
                        <small>Eventos creados</small>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!--
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
    -->
</div>

@endsection
