
<div class="col-md-6">

    <div class="form-group{{ $errors->first('name', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label"> First Name <span class="error">*</span></label>
        <div class="col-lg-8 col-md-8"> 
            {!! Form::text('name',null, ['class' => 'form-control form-cascade-control input-small'])  !!} 
            <span class="label label-danger">{{ $errors->first('name', ':message') }}</span>
        </div>
    </div> 

    <div class="form-group{{ $errors->first('email', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">Email *</label>
        <div class="col-lg-8 col-md-8"> 
            {!! Form::email('email',null, ['class' => 'form-control form-cascade-control input-small'])  !!}
            <span class="label label-danger">{{ $errors->first('email', ':message') }}</span>
            @if(Session::has('flash_alert_notice')) 
            <span class="label label-danger">

                {{ Session::get('flash_alert_notice') }} 

            </span>@endif
        </div>
    </div>
    
    <div class="form-group{{ $errors->first('password', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">Password</label>
        <div class="col-lg-8 col-md-8">   
            <input type="password" name="password" id="password" class="form-control form-cascade-control input-small" value="">
            <span class="label label-danger">{{ $errors->first('password', ':message') }}</span>
        </div>
    </div>
    <div class="form-group{{ $errors->first('role_type', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">User Type</label>
        <div class="col-lg-8 col-md-8"> 
           <label class="col-lg-4 col-md-4 control-label">{{ ($user->role_type==1)?'Professor':'student' }}</label>
            <span class="label label-danger">{{ $errors->first('role_type', ':message') }}</span>
            @if(Session::has('flash_alert_notice')) 
            <span class="label label-danger">
                {{ Session::get('flash_alert_notice') }} 
            </span>@endif
        </div>
    </div>    
    
    <div class="form-group">
        <label class="col-lg-4 col-md-4 control-label"></label>
        <div class="col-lg-8 col-md-8">

            {!! Form::submit(' Save ', ['class'=>'btn  btn-primary text-white','id'=>'saveBtn']) !!}

            <a href="{{route('user')}}">
            {!! Form::button('Back', ['class'=>'btn btn-warning text-white']) !!} </a>
        </div>
    </div>

</div> 