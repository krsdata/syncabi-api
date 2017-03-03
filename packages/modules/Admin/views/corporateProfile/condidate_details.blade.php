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
                                         {!! link_to(URL::previous(), 'Go Back', ['class' => 'btn btn-default']) !!}
                                        <!-- <div class="col-md-2 pull-right">
                                            <div style="width: 150px;" class="input-group"> 
                                                <a href="{{ route('corporateProfile.create')}}">
                                                    <button class="btn  btn-primary"><i class="fa fa-user-plus"></i> Add User</button> 
                                                </a>
                                            </div>
                                        </div> -->
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
                                            <tbody> 
                                                @if(count($c_details)==0)
                                                    <tr>
                                                      <td colspan="7">
                                                        <div class="alert alert-danger alert-dismissable">
                                                          <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                                          <i class="icon fa fa-check"></i>  
                                                          Record not found for <b>www.{{$c_name}}</b> organization!   {{ link_to(route('corporateProfile'), 'Go Back', ['class' => 'btn-sm btn-primary']) }}
                                                        </div>
                                                        </td>
                                                    </tr>
                                                  @endif
                                                
                                                    
                                                 <tr>
                                                    <th>
                                                       Candidate Name
                                                    </th>
                                                     <th>
                                                        Description
                                                    </th>
                                                     <th>
                                                        Interview Create Date
                                                    </th>
                                                    <th colspan="3">
                                                        Interview  Date
                                                    </th>
                                                    <th>Rating</th>
                                                    <th>
                                                        Rating Status
                                                    </th>   
                                                     
                                                 </tr>
                                                  <tr>
                                                    <td>
                                                        {{ucwords($c_details->condidate_name)}}
                                                    </td>
                                                     <td>
                                                        {{$c_details->short_description}}
                                                    </td>
                                                    <td>
                                                        {{$c_details->created_at}}
                                                    </td>
                                                    <td colspan="3">
                                                        {{$c_details->interview_date}}
                                                    </td>
                                                    <td>{{ number_format(floatval(($rate)),1)  }} </td>
                                                    <td>
                                                        {{ (count($rating_detail)==0)?'Pending':'Evaluated' }}
                                                    </td>
                                                 </tr>

                                                 <tr>
                                                    <th colspan="4">Rating Details:  <span  style="color:red"> {{ (count($rating_detail)==0)?'Pending':'' }}</span></th>
                                                 </tr>
                                                    
                                                  @foreach($rating_detail as $key =>$result)
                                                  
                                                 
                                                <tr>
                                                   <th rowspan="2" style="background:darkseagreen">
                                                        Interviewer Name :{{ $result['interviewerDetail']['firstName'].' '.$result['interviewerDetail']['lastName']}}<br>
                                                      
                                                        Position :{{$result['interviewerDetail']['positionName'] }}
                                                       
                                                    </th>

                                                    <th>Criteria:</th>
                                                     @foreach($result['ratingDetail'] as $key1 => $value)
                                                    <td>
                                                          {{ $value['criteria'] }}
                                                    </td>
                                                    
                                                    @endforeach
                                                    <td>Over all</td>
                                                </tr>
                                                <tr>
                                                    <th >Rating:</th>
                                                     @foreach($result['ratingDetail'] as $key1 => $value)
                                                    <td>
                                                          {{ $value['ratingValue'] }}
                                                    </td>
                                                    @endforeach
                                                     <td>{{$result['rating']}}</td>
                                                </tr>

                                                @endforeach

                                                <tr>
                                                     <td colspan="8"> 
                                                       <b> Comment : </b> {{(!$comment)?'N/A':''}} <br>
                                                        <ol>
                                                        @foreach($comment as $key => $c)
                                                            <li>{{$c}}</li>
                                                        @endforeach
                                                    </ul>
                                                    </td>
                                                </tr>     
                                            </tbody></table>

                                    </div><!-- /.box-body -->

                                </div>
                                 
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>  
        <style type="text/css">
            tr:nth-child(even) {
                background-color: #ECF0F5;
            }
        </style>
        <!-- Main row --> 
    </section><!-- /.content -->
</div> 

@stop
