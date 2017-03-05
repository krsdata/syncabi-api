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
                                                <select class="form-control" name="year">
                                                    @foreach($year as $key => $yr)
                                                    <option value="{{$yr}}" @if($report_yr==$yr) selected @endif>{{$yr}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
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

                                           <a href="corporate-monthly-report?year={{$report_yr}}&report=pdf&search={{(isset($_REQUEST['search']))?$_REQUEST['search']:''}}"  class="btn btn-warning">Download PDF</a> 
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
                                                    <th>Corporate Domain</th>
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
                                                @if(count($corporateProfile)==0)
                                                    <tr>
                                                      <td colspan="14">
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
                                                    <td> <a href="{{url('admin/monthly-report/'.$result->company_url)}}?year={{$yr}}"> {{ ucfirst($result->company_url) }} </a></td>
                                                  
                                                        <td>{{ $helper->getCorporateEvaluationCountByMonth($result->userID,1)}}</td>
                                                        <td>{{ $helper->getCorporateEvaluationCountByMonth($result->userID,2)}}</td>
                                                        <td>{{ $helper->getCorporateEvaluationCountByMonth($result->userID,3)}}</td>
                                                        <td>{{ $helper->getCorporateEvaluationCountByMonth($result->userID,4)}}</td>
                                                        <td>{{ $helper->getCorporateEvaluationCountByMonth($result->userID,5)}}</td>
                                                        <td>{{ $helper->getCorporateEvaluationCountByMonth($result->userID,6)}}</td>
                                                        <td>{{ $helper->getCorporateEvaluationCountByMonth($result->userID,7)}}</td>
                                                        <td>{{ $helper->getCorporateEvaluationCountByMonth($result->userID,8)}}</td>
                                                        <td>{{ $helper->getCorporateEvaluationCountByMonth($result->userID,9)}}</td>
                                                        <td>{{ $helper->getCorporateEvaluationCountByMonth($result->userID,10)}}</td>
                                                        <td>{{ $helper->getCorporateEvaluationCountByMonth($result->userID,11)}}</td>
                                                        <td>{{ $helper->getCorporateEvaluationCountByMonth($result->userID,12)}}</td>
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
