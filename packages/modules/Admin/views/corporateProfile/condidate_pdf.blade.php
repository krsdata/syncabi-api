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
                                        <div class="box-header"><p>Report : <b>Candidate Directory</b><br>
                                        Organisation Name : <b>{{$c_name}} </b><br>
                                        Generated Date : {{ date('d-m-Y H:i:s A') }} </p>
                                    </div> 
                                     
                                    <div class="box-body table-responsive no-padding">
                                        <table class="table table-hover">
                                            <tbody><tr>
                                                    <th>Sno</th>
                                                  <!--   <th>ID</th> -->
                                                    <th>candidate Name</th>
                                                    <th>Description</th> 
                                                    <th>Rating</th>  
                                                    <th>Create date</th>
                                                </tr>
                                                @if(count($condidates)==0)
                                                    <tr>
                                                      <td colspan="7">
                                                        <div class="alert alert-danger alert-dismissable">
                                                          <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                                          <i class="icon fa fa-check"></i>  
                                                          Record not found for <b>www.{{$c_name}}</b> organisation!   {{ link_to(route('corporateProfile'), 'Go Back', ['class' => 'btn-sm btn-primary']) }}
                                                        </div>
                                                        </td>
                                                    </tr>
                                                  @endif
                                                @foreach ($condidates as $key => $result)  
                                                
                                                <tr>
                                                    <td>{{ ++$key }}</td> 
                                                    <td>{{ ucfirst($result['condidateName']) }}</td>
                                                    <td> {{ $result['shortDescription'] }}</td>
                                                    <td>{{ $result['rating'] }}</td>  
                                                     <td>{{ 
                                                        Carbon\Carbon::parse($result['created_date'])->format('d-M-Y')
                                                      }}
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