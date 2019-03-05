@extends('layouts.app')

@section('title', 'Lista de Clubes')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Mi Perfil</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.html">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a>Perfil</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Mi Perfil</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="row animated fadeInRight">
            <div class="col-md-4">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Detalles del perfil</h5>
                        <div class="ibox-tools">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#" class="dropdown-item">Cambiar Avatar</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div>
                        <div class="ibox-content no-padding border-left-right">
                            <img alt="image" class="img-fluid" src="{{ url('images/avatar.jpeg') }}">

                            <div id="modal-form" class="modal fade" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-6 b-r"><h3 class="m-t-none m-b">Sign in</h3>

                                                    <p>Sign in today for more expirience.</p>

                                                    <form role="form">
                                                        <div class="form-group"><label>Email</label> <input type="email" placeholder="Enter email" class="form-control"></div>
                                                        <div class="form-group"><label>Password</label> <input type="password" placeholder="Password" class="form-control"></div>
                                                        <div>
                                                            <button class="btn btn-sm btn-primary float-right m-t-n-xs" type="submit"><strong>Log in</strong></button>
                                                            <label> <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div> Remember me </label>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-sm-6"><h4>Not a member?</h4>
                                                    <p>You can create an account:</p>
                                                    <p class="text-center">
                                                        <a href=""><i class="fa fa-sign-in big-icon"></i></a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-content profile-content">
                            <h4><strong>{{ $user->name }}</strong></h4>
                            <!--<p><i class="fa fa-map-marker"></i> Riviera State 32/106</p>-->
                            <h5>
                                Acerca de mi
                            </h5>
                            <p>
                                {{ $user->resume }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Activites</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#" class="dropdown-item">Config option 1</a>
                                </li>
                                <li><a href="#" class="dropdown-item">Config option 2</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div>
                            <div class="feed-activity-list">
                                @foreach($user->logs as $log)
                                <div class="feed-element">
                                    <!--
                                    <a href="#" class="float-left">
                                        <img alt="image" class="rounded-circle" src="img/a1.jpg">
                                    </a>
                                    -->
                                    <div class="media-body ">
                                        <small class="float-right text-navy">{{ $log->created_at->diffForHumans() }}</small>
                                        <strong>{{ $log->user->name }}</strong> {{ $log->tipo->description }}. <br>
                                        <small class="text-muted">{{ $log->created_at->format('d/ M/ Y H:i') }}</small>
                                        <div class="actions">
                                            <a href=""  class="btn btn-xs btn-white"><i class="fa fa-thumbs-up"></i> Like </a>
                                            <a href="" class="btn btn-xs btn-danger"><i class="fa fa-heart"></i> Love</a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <button class="btn btn-primary btn-block m"><i class="fa fa-arrow-down"></i> Show More</button>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
      $(document).ready(function(){

      });

    </script>
@endsection