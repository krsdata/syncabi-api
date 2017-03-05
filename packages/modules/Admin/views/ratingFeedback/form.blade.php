
<div class="col-md-6"> 
    

    <div class="form-group{{ $errors->first('rating_value', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">Rating</label>
        <div class="col-lg-8 col-md-8"> 
           <select name="rating_value" class="form-control form-cascade-control">
            @foreach($ratingdetails as $key=>$value) 
            <option value="{{$value->id}}" {{($value->id ==$ratingFeedback->id)?"selected":""}}>{{ $value->rating_value }}</option>
            @endforeach
            </select>
            <span class="label label-danger">{{ $errors->first('rating_value', ':message') }}</span>
        </div>
    </div>    

     <div class="form-group{{ $errors->first('feedback', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label"> Rating Feedback<span class="error">*</span></label>
        <div class="col-lg-8 col-md-8"> 
            {!! Form::text('feedback',null, ['class' => 'form-control form-cascade-control input-small'])  !!} 
            <span class="label label-danger">{{ $errors->first('feedback', ':message') }}</span>
        </div>
    </div> 
     
    
    <div class="form-group">
        <label class="col-lg-4 col-md-4 control-label"></label>
        <div class="col-lg-8 col-md-8">

            {!! Form::submit(' Save ', ['class'=>'btn  btn-primary text-white','id'=>'saveBtn']) !!}

            <a href="{{route('ratingFeedback')}}">
            {!! Form::button('Back', ['class'=>'btn btn-warning text-white']) !!} </a>
        </div>
    </div>

</div> 