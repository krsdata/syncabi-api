
<div class="col-md-6">

    <div class="form-group{{ $errors->first('first_name', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label"> First Name <span class="error">*</span></label>
        <div class="col-lg-8 col-md-8"> 
            {!! Form::text('first_name',null, ['class' => 'form-control form-cascade-control input-small'])  !!} 
            <span class="label label-danger">{{ $errors->first('first_name', ':message') }}</span>
        </div>
    </div> 

    <div class="form-group{{ $errors->first('last_name', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">Last Name</label>
        <div class="col-lg-8 col-md-8"> 
            {!! Form::text('last_name',null, ['class' => 'form-control form-cascade-control input-small'])  !!}
            <span class="label label-danger">{{ $errors->first('last_name', ':message') }}</span>
        </div>
    </div>

    <div class="form-group{{ $errors->first('email', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">Email</label>
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
            <input type="password" name="password" class="form-control form-cascade-control input-small" value="{{ $user->Password }}">
            <span class="label label-danger">{{ $errors->first('password', ':message') }}</span>
        </div>
    </div>  

    <div class="form-group{{ $errors->first('phone', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">Phone</label>
        <div class="col-lg-8 col-md-8"> 
            {!! Form::text('phone',null, ['class' => 'form-control form-cascade-control input-small'])  !!}
            <span class="label label-danger">{{ $errors->first('phone', ':message') }}</span>
        </div>
    </div> 

    <div class="form-group{{ $errors->first('created_at', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">Signup Date</label>
        <div class="col-lg-8 col-md-8"> 
            {!! Form::text('created_at',null, ['class' => 'form-control form-cascade-control input-small datepicker'])  !!}
            <span class="label label-danger">{{ $errors->first('created_at', ':message') }}</span>
        </div>
    </div>

    <div class="form-group{{ $errors->first('last_login_at', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">Last Login Date</label>
        <div class="col-lg-8 col-md-8"> 
            {!! Form::text('last_login_at',null, ['class' => 'form-control form-cascade-control input-small'])  !!}
            <span class="label label-danger">{{ $errors->first('last_login_at', ':message') }}</span>
        </div>
    </div> 
    
    
    <div class="form-group">
        <label class="col-lg-4 col-md-4 control-label"></label>
        <div class="col-lg-8 col-md-8">

            {!! Form::submit('Update', ['class'=>'btn btn-primary text-white']) !!}
        </div>
    </div>

</div> 