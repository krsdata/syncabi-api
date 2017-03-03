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
                                        <div class="box-header"><p>Report : <b>Corporate User details</b><br>
                                        Corporate Name : <b>{{$page_action}} </b><br>
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
                                            <tbody><tr>
                                                    <th>Sno</th> 
                                                    <th>Full Name</th>
                                                    <th>Email</th>
                                                    <th>Designation</th>
                                                    <th>Evaluated</th>
                                                    <th>Total Candidate </th>
                                                    <th>Organization</th>  
                                                    <th>Signup Date</th> 
                                                </tr>
                                                @if(count($users)==0)
                                                    <tr>
                                                      <td colspan="7">
                                                        <div class="alert alert-danger alert-dismissable">
                                                           
                                                          {{ 'Record not found. Try again !' }}
                                                        </div>
                                                      </td>
                                                    </tr>
                                                  @endif
                                                @foreach ($users as $key => $user)  
                                                 
                                                <tr>
                                                    <td>{{ ++$key }}</td> 
                                                    <td>{{ $user->first_name.' '.$user->last_name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->position->position_name }}</td> 
                                                    <td>{{ $helper->getEvaulationCount($user->userID) }} </td>
                                                    <td>{{ $helper->getPendingEvaulationCount($user->userID) }} </td>
                                                    <td>{{ $user->corporateProfile->company_url }}</td> 
                                                    <td> 
                                                        {!! Carbon\Carbon::parse($user->created_at)->format('d-m-Y'); !!}
                                                    </td>
                                                    
                                                </tr>
                                                @endforeach  
                                            </tbody>
                                        </table>

                                    </div><!-- /.box-body --> 

                                    <div class="center" align="center">  {!! $users->appends(['search' => isset($_GET['search'])?$_GET['search']:''])->render() !!}</div>
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
