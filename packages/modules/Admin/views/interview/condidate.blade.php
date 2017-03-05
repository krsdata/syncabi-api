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
                                                    <th>Sno</th>
                                                  <!--   <th>ID</th> -->
                                                    <th>candidate Name</th>
                                                    <th>Description</th> 
                                                    <th>Company Name</th>  
                                                    <th>Interview Date</th>
                                                    <th>Action</th> 
                                                </tr>
                                                @if(count($condidates)==0)
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
                                                @foreach ($condidates as $key => $result)  
                                                
                                                <tr>
                                                    <td>{{ (++$key) }}</td> 
                                                    <td>{{ ucfirst($result->condidate_name) }}</a></td>
                                                    <td>{{ $result->short_description }}</td>
                                                    <td><a href="{{ url('admin/corporateUser/'.$result->company_url)}}">{{ $result->company_url }}</a></td>  
                                                     <td>{{ 
                                                        Carbon\Carbon::parse($result->interview_date)->format('d-M-Y')
                                                      }}

                                                     <td><a href="{{ url('admin/getDirectory/'.$result->id.'?action=condidate_detail&name='.ucfirst($result->condidate_name))}}">View Details</a></td> 
                                      
                                                </tr>
                                                @endforeach 
                                                    
                                            </tbody></table>

                                    </div><!-- /.box-body -->

                                    <div class="center" align="center"> 

                                        <div class="center" align="center">  {!! $condidates->appends(['search' => isset($_GET['search'])?$_GET['search']:''])->render() !!}</div>

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
