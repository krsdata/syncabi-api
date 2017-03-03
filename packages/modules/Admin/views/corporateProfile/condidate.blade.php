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
                                        <form action="{{Request::URL('/')}}" method="get">
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
                                                <input value="{{ (isset($_REQUEST['search']))?$_REQUEST['search']:''}}" placeholder="Search by Name" type="text" name="search" id="search" class="form-control" >
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
                                         <div class="alert alert-danger alert-dismissable">
                                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                          <i class="icon fa fa-check"></i>  
                                         {{ Session::get('flash_alert_notice') }} 
                                         </div>
                                    @endif
                                     
                                    <div class="box-body table-responsive no-padding">
                                        <table class="table table-hover">
                                            <tbody>
                                                 <tr>
                                                    <td colspan="6"><h3 style="color:#3C8DBC">Candidate Details for <b>{{$c_name }}</b> </h3></td> </tr>
                                                <tr>
                                                    <th>Sno</th>
                                                  <!--   <th>ID</th> -->
                                                    <th>candidate Name</th>
                                                    <th>Description</th> 
                                                    <th>Rating</th> 
                                                   <!--  <th>Comment</th> -->
                                                    <th>Create date</th>
                                                    <th>Action</th> 
                                                </tr>
                                                @if(count($condidates)==0)
                                                    <tr>
                                                      <td colspan="7">
                                                        <div class="alert alert-danger alert-dismissable">
                                                          <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                                          <i class="icon fa fa-check"></i>  
                                                          Record not found for <b>www.{{$c_name}}</b> organizations!   {{ link_to(route('corporateProfile'), 'Go Back', ['class' => 'btn-sm btn-primary']) }}
                                                        </div>
                                                        </td>
                                                    </tr>
                                                  @endif
                                                @foreach ($condidates as $key => $result)  
                                                
                                                <tr>
                                                    <td>{{ ++$key }}</td> 
                                                    <td><a href="{{url('admin/getDirectory/'.$result['condidateID'].'?action=condidate_detail&name='.$result['condidateName'])}}"> {{ ucfirst($result['condidateName']) }}</a></td>
                                                    <td> {{ $result['shortDescription'] }}</td>
                                                    <td>{{ $result['rating'] }}</td>  
                                                    <!-- <td>{{ !empty($result['comment'])?$result['comment']:'NA' }}</td>
                                                     --> <td>{{ 
                                                        Carbon\Carbon::parse($result['created_date'])->format('m-d-Y')
                                                      }}
                                                     <td><a href="{{url('admin/getDirectory/'.$result['condidateID'].'?action=condidate_detail&name='.$result['condidateName'])}}">View rating </a></td> 
                                      
                                                </tr>
                                                @endforeach 
                                                    @if(count($condidates)!=0)
                                                    <tr><td colspan="5">
                                                        {!! link_to(route('corporateProfile'), 'Go Back', ['class' => 'btn btn-default']) !!}
                                                </td></tr>
                                                @endif
                                            </tbody></table>

                                    </div><!-- /.box-body -->

                                    <div class="center" align="center">  @if(count($condidates)!=0)  {{$pagination->render()}}  @endif </div>
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
