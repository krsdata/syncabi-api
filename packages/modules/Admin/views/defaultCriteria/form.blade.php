
<div class="col-md-8">  
       
   
     <div class="form-group{{ $errors->first('criteria_name', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label"> Default  Criteria Name<span class="error">*</span></label>
        <div class="col-lg-6 col-md-4"> 
            {!! Form::text('criteria_name',null, ['class' => 'form-control form-cascade-control input-small'])  !!} 
            <span class="label label-danger">{{ $errors->first('criteria_name', ':message') }}</span>
        </div>
    </div> 

    <div class="form-group{{ $errors->first('criteria_rating_value_1', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">Rating 1<span class="error">*</span></label>
        <div class="col-lg-6 col-md-4">  
            {!! Form::text('criteria_rating_value_1',null, ['class' => 'form-control form-cascade-control input-small'])  !!} 
            <span class="label label-danger">{{ $errors->first('criteria_rating_value_1', ':message') }}</span>
              (Type your feedback message here)
        </div>
    </div> 

    <div class="form-group{{ $errors->first('criteria_rating_value_2', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">Rating 2<span class="error">*</span></label>
        <div class="col-lg-6 col-md-4">  
            {!! Form::text('criteria_rating_value_2',null, ['class' => 'form-control form-cascade-control input-small'])  !!} 
            <span class="label label-danger">{{ $errors->first('criteria_rating_value_2', ':message') }}</span>
              (Type your feedback message here)
        </div>
    </div> 
    <div class="form-group{{ $errors->first('criteria_rating_value_3', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">Rating 3<span class="error">*</span></label>
        <div class="col-lg-6 col-md-4">  
            {!! Form::text('criteria_rating_value_3',null, ['class' => 'form-control form-cascade-control input-small'])  !!} 
            <span class="label label-danger">{{ $errors->first('criteria_rating_value_3', ':message') }}</span>
              (Type your feedback message here)
        </div>
    </div> 
    <div class="form-group{{ $errors->first('criteria_rating_value_4', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">Rating 4<span class="error">*</span></label>
        <div class="col-lg-6 col-md-4">  
            {!! Form::text('criteria_rating_value_4',null, ['class' => 'form-control form-cascade-control input-small'])  !!} 
            <span class="label label-danger">{{ $errors->first('criteria_rating_value_4', ':message') }}</span>
              (Type your feedback message here)
        </div>
    </div> 
    <div class="form-group{{ $errors->first('criteria_rating_value_5', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">Rating 5<span class="error">*</span></label>
        <div class="col-lg-6 col-md-4">  
            {!! Form::text('criteria_rating_value_5',null, ['class' => 'form-control form-cascade-control input-small'])  !!} 
            <span class="label label-danger">{{ $errors->first('criteria_rating_value_5', ':message') }}</span>
              (Type your feedback message here)
        </div>
    </div> 
     
    
    <div class="form-group">
        <label class="col-lg-4 col-md-4 control-label"></label>
        <div class="col-lg-6 col-md-4">

            {!! Form::submit(' Save ', ['class'=>'btn  btn-primary text-white','id'=>'saveBtn']) !!}

            <a href="{{route('defaultCriteria')}}">
            {!! Form::button('Back', ['class'=>'btn btn-warning text-white']) !!} </a>
        </div>
    </div>

</div> 