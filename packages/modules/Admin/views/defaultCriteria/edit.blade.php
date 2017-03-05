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
                       <div class="panel panel-cascade">
                          <div class="panel-body ">
                              <div class="row">  

                                {!! Form::model($defaultCriteria, ['method' => 'PATCH', 'route' => ['defaultCriteria.update', $defaultCriteria->id],'class'=>'form-horizontal','id'=>'defaultCriteria']) !!}
                                    @include('packages::defaultCriteria.form', compact('user'))
                                {!! Form::close() !!}
                              </div>
                          </div>
                    </div>
                </div>            
              </div>  
            <!-- Main row --> 
          </section><!-- /.content -->
      </div> 
@stop



