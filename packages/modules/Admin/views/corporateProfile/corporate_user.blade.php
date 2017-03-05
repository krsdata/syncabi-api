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
                                                <select class="form-control" name="month">
                                                    <option value="" @if($month=="") selected @endif>Sort by month</option>
                                                    <option value="01" @if($month=="01") selected @endif >January</option>
                                                    <option value="02" @if($month=="02") selected @endif>February</option>
                                                    <option value="03" @if($month=="03") selected @endif>March</option>
                                                    <option value="04" @if($month=="04") selected @endif>April</option>
                                                    <option value="05" @if($month=="05") selected @endif>May</option>
                                                    <option value="06" @if($month=="06") selected @endif>June</option>
                                                    <option value="07" @if($month=="07") selected @endif>July</option>
                                                    <option value="08" @if($month=="08") selected @endif>August</option>
                                                    <option value="09" @if($month=="09") selected @endif>September</option>
                                                    <option value="10" @if($month=="10") selected @endif>October</option>
                                                    <option value="11" @if($month=="11") selected @endif>November</option>
                                                    <option value="12" @if($month=="12") selected @endif>December</option>
                                                     
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="hidden" name="status" value="{{ (isset($_REQUEST['status']))?$_REQUEST['status']:''}}" >
                                                <input value="{{ (isset($_REQUEST['search']))?$_REQUEST['search']:''}}" placeholder="search by Name/Email" type="text" name="search" id="search" class="form-control" >
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
                                         <div class="alert alert-success alert-dismissable" style="margin:10px">
                                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                          <i class="icon fa fa-check"></i>  
                                         {{ Session::get('flash_alert_notice') }} 
                                         </div>
                                    @endif   
                                    <div class="box-body table-responsive no-padding">
                                        <table class="table table-hover">
                                            <tbody>
                                                <tr>
                                                    <td colspan="9"><h3 style="color:#3C8DBC"><b>{{ $page_action }}  </b> users detail :</td> </tr>
                                                <tr>
                                                    <th>Sno</th> 
                                                    <th>Full Name</th>
                                                    <th>Email</th>
                                                    <th>Position</th>
                                                    <th>Total Candidate </th> 
                                                     <th>Evaluated</th> 
                                                    <th>Last Evaluation</th>
                                                    <!-- <th>Status</th> -->
                                                     <th>Action</th>  
                                                </tr>
                                                @if(count($users)==0 || ($evaluation_by_month =="" && $month!=""))
                                                    <tr>
                                                      <td colspan="9">
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
                                                        <td>{{ $user->first_name.' '.$user->last_name }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>{{ $user->position->position_name }}</td>  
                                                        <td align="center">
                                                            <a href="{{  url('admin/recentInterview/'.$user->userID) }}?interviewerName={{$user->first_name.' '.$user->last_name}}" >
                                                                <span class="btn btn-default">{{ $helper->getPendingEvaulationCount($user->userID) }}  </span></a></td>
                                                        <td align="center">
                                                                <a href="{{  url('admin/recentInterview/'.$user->userID) }}?interviewerName={{$user->first_name.' '.$user->last_name}}&ratingStatus=true">
                                                               
                                                            <span class="btn btn-default">{{ $helper->getEvaulationCount($user->userID) }}  </span> </a></td>
                                                        <td> 
                                                            {{ $helper->getLastEvaluationDate($user->userID) }}
                                                        </td>
                                                      <!--  <td>
                                                            <span class="label label-{{ ($user->status==1)?'success':'warning'}} status" id="{{$user->userID}}" >
                                                                {{ ($user->status==1)?'Active':'Inactive'}}
                                                            </span>
                                                        </td>  --> 
                                                        <td> 
                                                           <a href="{{  url('admin/recentInterview/'.$user->userID) }}?interviewerName={{$user->first_name.' '.$user->last_name}}" class="btn btn-primary">
                                                                 Interview Details
                                                            </a>  
                                                        </td>
                                                    </tr>
                                                    @endif
                                                @endforeach 
                                                <tr>
                                                    <td colspan="5">
                                                      {!! link_to(route('corporateProfile'), 'Go Back', ['class' => 'btn btn-default']) !!}
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
