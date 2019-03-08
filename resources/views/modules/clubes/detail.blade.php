@extends('layouts.app')

@section('title', 'Lista de Clubes')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>{{ $club->name }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('clubes_list') }}">Clubes</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>{{ $club->name }}</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
    </div>

    <div class="row">
        <div class="col-lg-9">
            <div class="wrapper wrapper-content animated fadeInUp">
        <div class="ibox">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="m-b-md">
                            <!--<a href="#" class="btn btn-white btn-xs float-right">Edit project</a>-->
                            <h2>{{ $club->name }}</h2>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-right"><dt>Estado:</dt> </div>
                            <div class="col-sm-8 text-sm-left"><dd class="mb-1"><span class="label {{($club->active)?'label-primary':'label-danger'}}">{{ ($club->active)?'Activo':'Inactivo' }}</span></dd></div>
                        </dl>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-right"><dt>Director:</dt> </div>
                            <div class="col-sm-8 text-sm-left"><dd class="mb-1">{{ ($club->hasDirector())?$club->director->name:'Director no asociado' }}</dd> </div>
                        </dl>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-right"><dt>Unidades:</dt> </div>
                            <div class="col-sm-8 text-sm-left"> <dd class="mb-1">  {{ '0' }}</dd></div>
                        </dl>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-right"><dt>Zona:</dt> </div>
                            <div class="col-sm-8 text-sm-left"> <dd class="mb-1"><a href="#" class="text-navy">Zona {{ $club->zone->name }}</a> </dd></div>
                        </dl>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-right"> <dt>Version:</dt></div>
                            <div class="col-sm-8 text-sm-left"> <dd class="mb-1"> 	v1.4.2 </dd></div>
                        </dl>

                    </div>
                    <div class="col-lg-6" id="cluster_info">

                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-right">
                                <dt>Last Updated:</dt>
                            </div>
                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1">16.08.2014 12:15:57</dd>
                            </div>
                        </dl>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-right">
                                <dt>Created:</dt>
                            </div>
                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1"> 10.07.2014 23:36:57</dd>
                            </div>
                        </dl>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-right">
                                <dt>Participants:</dt>
                            </div>
                            <div class="col-sm-8 text-sm-left">
                                <dd class="project-people mb-1">
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a3.jpg"></a>
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a1.jpg"></a>
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a2.jpg"></a>
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a4.jpg"></a>
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a5.jpg"></a>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <dl class="row mb-0">
                            <div class="col-sm-2 text-sm-right">
                                <dt>Completed:</dt>
                            </div>
                            <div class="col-sm-10 text-sm-left">
                                <dd>
                                    <div class="progress m-b-1">
                                        <div style="width: 60%;" class="progress-bar progress-bar-striped progress-bar-animated"></div>
                                    </div>
                                    <small>Project completed in <strong>60%</strong>. Remaining close the project, sign a contract and invoice.</small>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
                <div class="row m-t-sm">
                    <div class="col-lg-12">
                        <div class="panel blank-panel">
                            <div class="panel-heading">
                                <div class="panel-options">
                                    <ul class="nav nav-tabs">
                                        <li><a class="nav-link active" href="#tab-1" data-toggle="tab">Users messages</a></li>
                                        <li><a class="nav-link" href="#tab-2" data-toggle="tab">Last activity</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="panel-body">

                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab-1">
                                        <div class="feed-activity-list">
                                            <div class="feed-element">
                                                <a href="#" class="float-left">
                                                    <img alt="image" class="rounded-circle" src="img/a2.jpg">
                                                </a>
                                                <div class="media-body ">
                                                    <small class="float-right">2h ago</small>
                                                    <strong>Mark Johnson</strong> posted message on <strong>Monica Smith</strong> site. <br>
                                                    <small class="text-muted">Today 2:10 pm - 12.06.2014</small>
                                                    <div class="well">
                                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                                                        Over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="feed-element">
                                                <a href="#" class="float-left">
                                                    <img alt="image" class="rounded-circle" src="img/a3.jpg">
                                                </a>
                                                <div class="media-body ">
                                                    <small class="float-right">2h ago</small>
                                                    <strong>Janet Rosowski</strong> add 1 photo on <strong>Monica Smith</strong>. <br>
                                                    <small class="text-muted">2 days ago at 8:30am</small>
                                                </div>
                                            </div>
                                            <div class="feed-element">
                                                <a href="#" class="float-left">
                                                    <img alt="image" class="rounded-circle" src="img/a4.jpg">
                                                </a>
                                                <div class="media-body ">
                                                    <small class="float-right text-navy">5h ago</small>
                                                    <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                                                    <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                                    <div class="actions">
                                                        <a href=""  class="btn btn-xs btn-white"><i class="fa fa-thumbs-up"></i> Like </a>
                                                        <a href=""  class="btn btn-xs btn-white"><i class="fa fa-heart"></i> Love</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="feed-element">
                                                <a href="#" class="float-left">
                                                    <img alt="image" class="rounded-circle" src="img/a5.jpg">
                                                </a>
                                                <div class="media-body ">
                                                    <small class="float-right">2h ago</small>
                                                    <strong>Kim Smith</strong> posted message on <strong>Monica Smith</strong> site. <br>
                                                    <small class="text-muted">Yesterday 5:20 pm - 12.06.2014</small>
                                                    <div class="well">
                                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                                                        Over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="feed-element">
                                                <a href="#" class="float-left">
                                                    <img alt="image" class="rounded-circle" src="img/profile.jpg">
                                                </a>
                                                <div class="media-body ">
                                                    <small class="float-right">23h ago</small>
                                                    <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                                    <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                                </div>
                                            </div>
                                            <div class="feed-element">
                                                <a href="#" class="float-left">
                                                    <img alt="image" class="rounded-circle" src="img/a7.jpg">
                                                </a>
                                                <div class="media-body ">
                                                    <small class="float-right">46h ago</small>
                                                    <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                                    <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane" id="tab-2">

                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>Status</th>
                                                <th>Title</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th>Comments</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <span class="label label-primary"><i class="fa fa-check"></i> Completed</span>
                                                </td>
                                                <td>
                                                    Create project in webapp
                                                </td>
                                                <td>
                                                    12.07.2014 10:10:1
                                                </td>
                                                <td>
                                                    14.07.2014 10:16:36
                                                </td>
                                                <td>
                                                    <p class="small">
                                                        Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable.
                                                    </p>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="label label-primary"><i class="fa fa-check"></i> Accepted</span>
                                                </td>
                                                <td>
                                                    Various versions
                                                </td>
                                                <td>
                                                    12.07.2014 10:10:1
                                                </td>
                                                <td>
                                                    14.07.2014 10:16:36
                                                </td>
                                                <td>
                                                    <p class="small">
                                                        Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                                                    </p>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="label label-primary"><i class="fa fa-check"></i> Sent</span>
                                                </td>
                                                <td>
                                                    There are many variations
                                                </td>
                                                <td>
                                                    12.07.2014 10:10:1
                                                </td>
                                                <td>
                                                    14.07.2014 10:16:36
                                                </td>
                                                <td>
                                                    <p class="small">
                                                        There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which
                                                    </p>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="label label-primary"><i class="fa fa-check"></i> Reported</span>
                                                </td>
                                                <td>
                                                    Latin words
                                                </td>
                                                <td>
                                                    12.07.2014 10:10:1
                                                </td>
                                                <td>
                                                    14.07.2014 10:16:36
                                                </td>
                                                <td>
                                                    <p class="small">
                                                        Latin words, combined with a handful of model sentence structures
                                                    </p>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="label label-primary"><i class="fa fa-check"></i> Accepted</span>
                                                </td>
                                                <td>
                                                    The generated Lorem
                                                </td>
                                                <td>
                                                    12.07.2014 10:10:1
                                                </td>
                                                <td>
                                                    14.07.2014 10:16:36
                                                </td>
                                                <td>
                                                    <p class="small">
                                                        The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.
                                                    </p>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="label label-primary"><i class="fa fa-check"></i> Sent</span>
                                                </td>
                                                <td>
                                                    The first line
                                                </td>
                                                <td>
                                                    12.07.2014 10:10:1
                                                </td>
                                                <td>
                                                    14.07.2014 10:16:36
                                                </td>
                                                <td>
                                                    <p class="small">
                                                        The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.
                                                    </p>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="label label-primary"><i class="fa fa-check"></i> Reported</span>
                                                </td>
                                                <td>
                                                    The standard chunk
                                                </td>
                                                <td>
                                                    12.07.2014 10:10:1
                                                </td>
                                                <td>
                                                    14.07.2014 10:16:36
                                                </td>
                                                <td>
                                                    <p class="small">
                                                        The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested.
                                                    </p>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="label label-primary"><i class="fa fa-check"></i> Completed</span>
                                                </td>
                                                <td>
                                                    Lorem Ipsum is that
                                                </td>
                                                <td>
                                                    12.07.2014 10:10:1
                                                </td>
                                                <td>
                                                    14.07.2014 10:16:36
                                                </td>
                                                <td>
                                                    <p class="small">
                                                        Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable.
                                                    </p>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="label label-primary"><i class="fa fa-check"></i> Sent</span>
                                                </td>
                                                <td>
                                                    Contrary to popular
                                                </td>
                                                <td>
                                                    12.07.2014 10:10:1
                                                </td>
                                                <td>
                                                    14.07.2014 10:16:36
                                                </td>
                                                <td>
                                                    <p class="small">
                                                        Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical
                                                    </p>
                                                </td>

                                            </tr>

                                            </tbody>
                                        </table>

                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
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