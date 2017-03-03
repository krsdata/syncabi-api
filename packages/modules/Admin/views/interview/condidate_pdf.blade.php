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
                                     <div class="box-header"><p>Report : <b>Condidate Directory</b><br>
                                        Generated Date : {{ date('d-m-Y H:i:s A') }} </p>
                                      </div>
                                     
                                    <div class="box-body table-responsive no-padding">
                                        <table class="table table-hover">
                                            <tbody>
                                                <tr>
                                                    <th>Sno</th>
                                                  <!--   <th>ID</th> -->
                                                    <th>condidate Name</th>
                                                    <th>Description</th> 
                                                    <th>Company Name</th>  
                                                    <th>Interview Date</th> 
                                                </tr>
                                                @if(count($condidates)==0)
                                                    <tr>
                                                      <td colspan="7">
                                                        <div class="alert alert-danger alert-dismissable">
                                                           
                                                          Record not found  
                                                        </div>
                                                        </td>
                                                    </tr>
                                                  @endif
                                                @foreach ($condidates as $key => $result)  
                                                
                                                <tr>
                                                    <td>{{ ++$key }}</td> 
                                                    <td>{{ ucfirst($result->condidate_name) }}</a></td>
                                                    <td>{{ $result->short_description }}</td>
                                                    <td>{{ $result->company_url }} </td>  
                                                     <td>{{ 
                                                        Carbon\Carbon::parse($result->interview_date)->format('d-M-Y')
                                                      }} 
                                      
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
table, th, td {
    border: 1px solid black !important;
}
table {
    border-collapse: collapse;
}

table, th, td {
    border: 1px solid black;
   
}
table{
    width: 100%;
}
</style>