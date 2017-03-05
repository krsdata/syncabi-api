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
                                        <form action="{{route('corporateProfile')}}" method="get">
                                            
                                            <div class="col-md-3">
                                                <input value="{{ (isset($_REQUEST['search']))?$_REQUEST['search']:''}}" placeholder="Search" type="text" name="search" id="search" class="form-control" >
                                            </div>
                                            <div class="col-md-2">
                                                <input type="submit" value="Search" class="btn btn-primary form-control">
                                            </div> 
                                        </form>
                                        <!-- <div class="col-md-1">
                                           <a href="corporateProfile" class="btn btn-warning">Reset</a> 
                                        </div>   -->
                                        <div class="col-md-1">
                                               {!! link_to(Request::url(), 'Reset', ['class' => 'btn btn-default']) !!}
                                            </div>
                                                    <div class="col-md-2 pull-right">

                                           <a href="corporateProfile?report=pdf&search={{(isset($_REQUEST['search']))?$_REQUEST['search']:''}}"  class="btn btn-warning">Download PDF</a> 
                                        </div> 
                                    </div><!-- /.box-header -->

                                    
                                    @if(Session::has('flash_alert_notice'))
                                         <div class="alert alert-danger alert-dismissable">
                                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                          <i class="icon fa fa-check"></i>  
                                         {{ Session::get('flash_alert_notice') }} 
                                         </div>
                                    @endif
                                     
                                    <div class="box-body table-responsive no-padding">
                                        <table class="table table-hover">
                                            <tbody><tr>
                                                    <th>Sno</th>
                                                  <!--   <th>ID</th> -->
                                                    <th>Corporate Name</th>
                                                    <th>Website Url</th> 
                                                    <th>Total User</th>
                                                    <th>Total Active User</th>  
                                                    <th>Total Candidate </th>
                                                    <th>Created Date</th> 
                                                    <th>Action</th> 
                                                </tr>
                                                @if(count($corporateProfile)==0)
                                                    <tr>
                                                      <td colspan="7">
                                                        <div class="alert alert-danger alert-dismissable">
                                                          <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                                          <i class="icon fa fa-check"></i>  
                                                          {{ 'Record not found. Try again !' }}
                                                        </div>
                                                         {!! link_to(URL::previous(), 'Go Back', ['class' => 'btn btn-default']) !!}
                                                      </td>
                                                    </tr>
                                                  @endif
                                                @foreach ($corporateProfile as $key => $result)  
                                                 
                                                <tr>
                                                    <td>{{ ++$key }}  </td>
                                                   <!--  <td>{{ $result->id }}</td> -->
                                                    <td> <a href="{{url('admin/corporateUser/'.$result->company_url)}}"> {{ ucfirst($result->company_name) }} </a></td>
                                                    <td>www.{{ $result->company_url }}</td>
                                                    <td align="center"> 
                                                        <a class="btn btn-default"  href="{{url('admin/corporateUser/'.$result->company_url)}}">
                                                            {{ $result->count }} </a></td> 
                                                    <td align="center">
                                                    <a class="btn btn-default"  href="{{url('admin/corporateUser/'.$result->company_url)}}?status=active">
                                                           
                                                        {{ $helper->getActiveUserCount($result->company_url) }}
                                                    </a>    
                                                    </td>          
                                                    <td align="center"><a class="btn btn-default" href="corporateProfile/{{$result->id}}"> {{ $helper->getCondidateCountByUserID($result->userID)}}</a></td>
                                                    <td>{{ $result->created_at }}</td>
                                                     
                                                    <td> 

                                                        {!! Form::open(array('class' => 'form-inline pull-left', 'method' => 'GET',  'id'=>'deleteForm_'.$result->id, 'route' => array('corporateProfile.show', $result->id))) !!}
                                                        <button class="delbtn btn btn-primary " type="submit">Candidate Directory</button>
                                                        {!! Form::close() !!}

                                                    </td> 
                                                </tr>
                                                @endforeach 
                                            </tbody></table>

                                    </div><!-- /.box-body -->
                                    <div class="center" align="center">  {!! $corporateProfile ->appends(['search' => isset($_GET['search'])?$_GET['search']:''])->render() !!}</div>
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
