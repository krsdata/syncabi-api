<div>
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
                                     <div class="box-header"><p>Report : <b>Corporate Profile</b><br>
                                        Generated Date : {{ date('d-m-Y H:i:s A') }} </p>
                                      </div>
                                    <div class="box-body table-responsive no-padding">
                                        <table class="table table-hover">
                                            <tbody><tr>
                                                    <th>Sno</th> 
                                                    <th>Corporate Name</th>
                                                    <th>Website Url</th> 
                                                    <th>Total User</th> 
                                                    <th>Total Candidate </th>
                                                    <th>Created Date</th> 
                                                     
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
                                                    <td align="center">{{ ++$key }}  </td>
                                                  
                                                    <td> {{ ucfirst($result->company_name) }}  </td>
                                                    <td>www.{{ $result->company_url }}</td>
                                                    <td align="center"> 
                                                         {{ $result->count }}  </td>  
                                                    <td align="center"> {{ $helper->getCondidateCountByUserID($result->userID)}} </td>
                                                    <td> 
                                                        {!! Carbon\Carbon::parse($result->created_at)->format('d-M-Y'); !!}
                                                    </td> 
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