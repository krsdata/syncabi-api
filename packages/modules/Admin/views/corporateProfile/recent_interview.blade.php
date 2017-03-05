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
                                       <form action="" method="get">
                                            <div class="col-md-3">
                                                <select class="form-control" name="month">
                                                    <option value="" @if($month=="") selected @endif>Sort by month</option>
                                                    <option value="01" @if($month==="01") selected @endif >January</option>
                                                    <option value="02" @if($month==="02") selected @endif>February</option>
                                                    <option value="03" @if($month==="03") selected @endif>March</option>
                                                    <option value="04" @if($month==="04") selected @endif>April</option>
                                                    <option value="05" @if($month==="05") selected @endif>May</option>
                                                    <option value="06" @if($month==="06") selected @endif>June</option>
                                                    <option value="07" @if($month==="07") selected @endif>July</option>
                                                    <option value="08" @if($month==="08") selected @endif>August</option>
                                                    <option value="09" @if($month==="09") selected @endif>September</option>
                                                    <option value="10" @if($month==="10") selected @endif>October</option>
                                                    <option value="11" @if($month==="11") selected @endif>November</option>
                                                    <option value="12" @if($month==="12") selected @endif>December</option>
                                                     
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <input value="{{ (isset($_REQUEST['search']))?$_REQUEST['search']:''}}" placeholder="Search" type="text" name="search" id="search" class="form-control" >
                                            </div>
                                            <div class="col-md-2">
                                                <input type="submit" value="Search" class="btn btn-primary form-control">
                                            </div>
                                            <div class="col-md-2">
                                               {!! link_to(Request::url(), 'Reset', ['class' => 'btn btn-default']) !!}
                                            </div>
                                        </form>
                                        <div class="col-md-2 pull-right">

                                           <a href="{{$report_url}}"  class="btn btn-warning">Download PDF</a> 
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
                                            <tbody> 
                                                @if(count($interview)==0)
                                                    <tr>
                                                      <td colspan="7">
                                                        <div class="alert alert-danger alert-dismissable">
                                                          <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                                          <i class="icon fa fa-check"></i>  
                                                          Record not found 
                                                        </div>
                                                        </td>
                                                    </tr>
                                                  @endif
                                                                                                   
                                                 <tr>
                                                  <th>
                                                      Sno.
                                                    </th>
                                                    <th>
                                                       Candidate Name
                                                    </th>
                                                     <th>
                                                        Description
                                                    </th>
                                                     <th>
                                                        Created Date
                                                    </th>
                                                     
                                                    <th>Rating</th>
                                                    <th>
                                                        Rating Status
                                                    </th>
                                                    <th>Evaluation Date</th> 
                                                 </tr>

                                                 @foreach ($interview as $key => $result)
                                                   @if(($ratingStatus && count($result->InterviewRating)>0) || $ratingStatus==null )
                                                     <tr>
                                                      <td>{{ ++$key }} </td> 
                                                        <td>
                                                          <a href="{{ url('admin/getDirectory/'.$result->id.'?action=condidate_detail&name='.ucfirst($result->condidate_name))}}">
                                                            {{ ucwords($result->condidate_name)}} </a></td>
                                                        <td>{{$result->short_description}} </td>
                                                        <td>   
                                                        {!! Carbon\Carbon::parse($result->created_at)->format('m-d-Y'); !!}
                                                        </td>
                                                        <td>{{ (count($result->InterviewRating))?"":"0.0" }}
                                                          @foreach ($result->InterviewRating as $key => $ir) 

                                                          {{ number_format(floatval($ir->rating),1) }}
                                                          @endforeach 
                                                        </td>
                                                        <td> 
                                                            {{ (count($result->InterviewRating))?"Evaluated":"Pending" }}</td>
                                                        </td>
                                                        <td> {{ (count($result->InterviewRating))?"":"N/A" }}
                                                          @foreach ($result->InterviewRating as $key => $ir) 
                                                              {{ Carbon\Carbon::parse($ir->created_at)->format('m-d-Y') }}
                                                          @endforeach 
                                                        </td> 
                                                      @endif  
                                                    @endforeach 
                                                    </tr>
                                                      <tr>
                                                        <td colspan="7">
                                                            {!! link_to(URL::previous(), 'Go Back', ['class' => 'btn btn-default']) !!}
                                                        </td>
                                                      </tr>
                                                  </tbody>
                                                </table>

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
