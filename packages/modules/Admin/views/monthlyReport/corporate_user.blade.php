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
                                        <form action="{{ url($request->getPathInfo()) }}" method="get">
                                            <div class="col-md-3">
                                                <select class="form-control" name="year">
                                                    @foreach($year as $key => $yr)
                                                    <option value="{{$yr}}" @if($report_yr==$yr) selected @endif>{{$yr}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <input type="hidden" name="status" value="{{ (isset($_REQUEST['status']))?$_REQUEST['status']:''}}" >
                                                <input value="{{ (isset($_REQUEST['search']))?$_REQUEST['search']:''}}" placeholder="search by Name" type="text" name="search" id="search" class="form-control" >
                                            </div>
                                            <div class="col-md-2">
                                                <input type="submit" value="Search" class="btn btn-primary form-control">
                                            </div>
                                            <div class="col-md-2">
                                               {!! link_to(Request::url(), 'Reset', ['class' => 'btn btn-default']) !!}
                                            </div>
                                        </form>
                                      <div class="col-md-2 pull-right">
                                            <div style="width: 150px;" class="input-group"> 
                                                <a href="{{ $download_url }}">
                                                    <button class="btn  btn-warning">Download PDF</button> 
                                                </a>
                                            </div>
                                        </div> 
                                        
                                    </div><!-- /.box-header -->

                                    
                                    @if(Session::has('flash_alert_notice'))
                                         <div class="alert alert-success alert-dismissable" style="margin:10px; width:100%">
                                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                          <i class="icon fa fa-check"></i>  
                                         {{ Session::get('flash_alert_notice') }} 
                                         </div>
                                    @endif   
                                    <div class="box-body table-responsive no-padding">
                                        <table class="table table-hover">
                                            <tbody>
                                                <tr>
                                                    <td colspan="9"><h3 style="color:#3C8DBC"><b>'{{ $page_action }}'  </b> Monthly evaluation report :</td> </tr>
                                                <tr>
                                                    <th>Sno</th> 
                                                    <th>Full Name</th>
                                                    <th>Jan</th>
                                                    <th>Feb</th>
                                                    <th>March </th> 
                                                    <th>April</th> 
                                                    <th>May</th>
                                                    <th>June</th>
                                                    <th>July</th>
                                                    <th>Aug</th>
                                                    <th>Sep</th>
                                                    <th>Oct</th>
                                                    <th>Nov</th>
                                                    <th>Dec</th> 
                                                </tr>
                                                @if(count($users)==0 || ($evaluation_by_month =="" && $month!=""))
                                                    <tr>
                                                      <td colspan="14">
                                                        <div class="alert alert-danger alert-dismissable">
                                                          <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                                          <i class="icon fa fa-check"></i>  
                                                          {{ 'Record not found. Try again !' }}
                                                        </div>
                                                      </td>
                                                    </tr>
                                                  @endif
                                                @foreach ($users as $key => $user)  
                                                    @if(($evaluation_by_month!="" AND in_array($user->userID, $evaluation_by_month)) OR $evaluation_by_month =="" && $month=="")
                                                    <tr>
                                                        <td>{{ ++$key }}</td> 
                                                        <td>
                                                            <a href='{{url("admin/recentInterview/".$user->userID."?interviewerName=")}}'>
                                                            {{ $user->first_name.' '.$user->last_name }} </a> </td>
                                                        <td>{{ $helper->getEvaluationCountByMonth($user->userID,1)}}</td>
                                                        <td>{{ $helper->getEvaluationCountByMonth($user->userID,2)}}</td>
                                                        <td>{{ $helper->getEvaluationCountByMonth($user->userID,3)}}</td>
                                                        <td>{{ $helper->getEvaluationCountByMonth($user->userID,4)}}</td>
                                                        <td>{{ $helper->getEvaluationCountByMonth($user->userID,5)}}</td>
                                                        <td>{{ $helper->getEvaluationCountByMonth($user->userID,6)}}</td>
                                                        <td>{{ $helper->getEvaluationCountByMonth($user->userID,7)}}</td>
                                                        <td>{{ $helper->getEvaluationCountByMonth($user->userID,8)}}</td>
                                                        <td>{{ $helper->getEvaluationCountByMonth($user->userID,9)}}</td>
                                                        <td>{{ $helper->getEvaluationCountByMonth($user->userID,10)}}</td>
                                                        <td>{{ $helper->getEvaluationCountByMonth($user->userID,11)}}</td>
                                                        <td>{{ $helper->getEvaluationCountByMonth($user->userID,12)}}</td> 
                                                         
                                                    </tr>
                                                    @endif
                                                @endforeach 
                                                <tr>
                                                    <td colspan="5">
                                                      {!! link_to(url('admin/corporate-monthly-report'), 'Go Back', ['class' => 'btn btn-default']) !!}
                                                    </td>
                                                </tr> 
                                            </tbody>
                                        </table>

                                    </div><!-- /.box-body --> 

                                    <div class="center" align="center">  {!! $users->appends(['search' => isset($_GET['search'])?$_GET['search']:''])->render() !!}</div>
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
