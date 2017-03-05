@extends('packages::layouts.master')
@section('content') 
@include('packages::partials.main-header')
<!-- Left side column. contains the logo and sidebar -->
@include('packages::partials.main-sidebar')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"> 
    @include('packages::partials.breadcrumb')

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12">
                    <div class="panel panel-cascade">
                        <div class="panel-body ">
                            <div class="row">
                                <div class="box">
                                     <div class="box-header">
                                        <form action="{{route('defaultCriteria')}}" method="get">
                                            
                                            <div class="col-md-3">
                                                <input value="{{ (isset($_REQUEST['search']))?$_REQUEST['search']:''}}" placeholder="search criteria" type="text" name="search" id="search" class="form-control" >
                                            </div>
                                            <div class="col-md-2">
                                                <input type="submit" value="Search" class="btn btn-primary form-control">
                                            </div>
                                        </form>
                                        <div class="col-md-3 pull-right">
                                            <div style="width: 150px;" class="input-group"> 
                                                <a href="{{ route('defaultCriteria.create')}}">
                                                    <button class="btn  btn-primary"><i class="fa fa-user-plus"></i> Create Default Criteria</button> 
                                                </a>
                                            </div>
                                        </div>

                                    </div><!-- /.box-header --> 
                                    @if(Session::has('flash_alert_notice'))
                                         <div class="alert alert-success alert-dismissable" style="margin:10px">
                                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                          <i class="icon fa fa-check"></i>  
                                         {{ Session::get('flash_alert_notice') }} 
                                         </div>
                                    @endif
                                     
                                    <div class="box-body table-responsive no-padding">
                                        <table class="table table-hover">
                                            <tbody><tr>
                                                    <th>Sno</th> 
                                                    <th>Default Criteria</th>
                                                    <th>Rating 1</th>
                                                    <th>Rating 2</th>
                                                    <th>Rating 3</th>
                                                    <th>Rating 4</th>
                                                    <th>Rating 5</th> 
                                                    <th>Action</th>
                                                </tr>
                                                @if(count($defaultCriteria)==0)
                                                    <tr>
                                                      <td colspan="7">
                                                        <div class="alert alert-danger alert-dismissable">
                                                          <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                                          <i class="icon fa fa-check"></i>  
                                                          {{ 'Record not found. Try again !' }}
                                                        </div>
                                                      </td>
                                                    </tr>
                                                  @endif
                                                @foreach ($defaultCriteria as $key => $result)  
                                                 
                                                <tr>
                                                    <td>{{ ++$key }}</td> 
                                                        <td>{{ $result->criteria_name }}</td>
                                                        <td>{{  $result->criteria_rating_value_1 }}</td>
                                                        <td>{{  $result->criteria_rating_value_2 }}</td> 
                                                        <td>{{  $result->criteria_rating_value_3 }}</td> 
                                                        <td>{{  $result->criteria_rating_value_4 }}</td> 
                                                        <td>{{  $result->criteria_rating_value_5 }}</td>  
                                                    <td> 
                                                        <a href="{{ route('defaultCriteria.edit',$result->id)}}">
                                                            <i class="fa fa-fw fa-pencil-square-o" title="edit"></i> 
                                                        </a> 
                                                    </td>
                                                </tr>
                                                @endforeach 
                                            </tbody></table>
                                    </div><!-- /.box-body --> 
                                        <div class="center" align="center"> 
                                        {{ $defaultCriteria->appends(['search' => isset($_GET['search'])?$_GET['search']:''])->render() }}
                                     </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div> 
        <!-- Main row --> 
    </section><!-- /.content -->
</div> 

@stop
