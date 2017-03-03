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
                                        <div class="box-header"><p>Report : <b>Monthly evaluation report</b><br>
                                        Generated Date : {{ date('d-m-Y H:i:s A') }} </p>
                                    </div>

                                    
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
                                                    <td colspan="14"><h3 style="color:#3C8DBC"><b>'{{ $page_action }}'  </b> Monthly evaluation report :</td> </tr>
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
                                                        <td> 
                                                            {{ $user->first_name.' '.$user->last_name }}   
                                                        </td>
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