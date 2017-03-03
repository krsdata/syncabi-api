  
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
                                         <div class="box-header"><p>Report : <b>Interview Details</b><br>
                                            Interviwer Name : <b>{{ $userName }}</b><br>
                                            Generated Date : {{ date('d-m-Y H:i:s A') }} </p>
                                      </div>
                                    </div>  
                                    <div class="box-body table-responsive no-padding">
                                        <p>Candidate Details : </p>
                                       
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
                                                      <th>Sno</th>
                                                      <th>Candidate Name</th>
                                                      <th>Description</th>
                                                      <th>Interview Create Date</th>
                                                      <th>Rating</th>
                                                      <th>Rating Status</th> 
                                                 </tr>

                                                 @foreach ($interview as $key => $result) 
                                                 <tr>
                                                   <td>{{++$key}} </td>
                                                    <td>{{$result->condidate_name}} </td>
                                                    <td>{{$result->short_description}} </td>
                                                    <td>   
                                                    {!! Carbon\Carbon::parse($result->created_at)->format('d-m-Y'); !!}
                                                    </td>
                                                    <td>{{ (count($result->InterviewRating))?"":"0.0" }}
                                                      @foreach ($result->InterviewRating as $key => $ir) 
                                                      {{ ($ir->rating) }}
                                                      @endforeach 
                                                    </td>
                                                    <td> {{ (count($result->InterviewRating))?"Evaluated":"Pending" }}</td>
                                                    </td> 
                                                  @endforeach 
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