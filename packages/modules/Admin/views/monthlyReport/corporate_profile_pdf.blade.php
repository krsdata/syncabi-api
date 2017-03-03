
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"> 
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
                                        <div align="center" style="background: #183240;padding: 9px;color: #17DA8A;">
                                            <h1 aling="center">Udex</h1>              
                                        </div
                                        <div class="box-header"><p>Report : <b>Monthly Evaluation Report</b><br>
                                       
                                        Generated Date : {{ date('d-m-Y H:i:s A') }} </p>
                                    </div>

                                    
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
                                                    <td> {{ ucfirst($result->company_url) }}    </td>
                                                  
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
 
<style type="text/css">
 
table {
    border-collapse: collapse;
}

table, th, td {
    border: 1px solid black; 
   
}
table tr td {
    padding: 5px;
   
}
table{
    width: 100%;
}
</style>  
