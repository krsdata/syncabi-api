
<div class="col-md-10">

    
     <div class="form-group{{ $errors->first('article_title', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label"> Article Name <span class="error">*</span></label>
        <div class="col-lg-8 col-md-8"> 
            {!! Form::text('article_title',null, ['class' => 'form-control form-cascade-control input-small'])  !!} 
            <span class="label label-danger">{{ $errors->first('article_title', ':message') }}</span>
        </div>
    </div> 


    <div class="form-group{{ $errors->first('article_category', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">Article category <span class="error">*</span></label>
        <div class="col-lg-8 col-md-8"> 
            {!! Form::select('article_category',$cat, null,['class' => 'form-control form-cascade-control input-small'])  !!}

            <span class="label label-danger">{{ $errors->first('article_category', ':message') }}</span>
        </div>
    </div> 
 


     <div class="form-group{{ $errors->first('description', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">Article Description</label>
        <div class="col-lg-8 col-md-8"> 
            {!! Form::textarea('description',null, ['class' => 'form-control ckeditor form-cascade-control input-small'])  !!}
            <span class="label label-danger">{{ $errors->first('description', ':message') }}</span>
            @if(Session::has('flash_alert_notice')) 
            <span class="label label-danger">

                {{ Session::get('flash_alert_notice') }} 

            </span>@endif
        </div>
    </div> 

<!-- 
     <div class="form-group{{ $errors->first('image', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">Feature Image</label>
        <div class="col-lg-8 col-md-8">  

             {!! Form::file('image',null,['class' => 'form-control form-cascade-control input-small'])  !!}


            <span class="label label-danger">{{ $errors->first('image', ':message') }}</span>
            @if(Session::has('flash_alert_notice')) 
            <span class="label label-danger">

                {{ Session::get('flash_alert_notice') }} 

            </span>@endif
        </div>
    </div> 

      -->
    
    <div class="form-group">
        <label class="col-lg-4 col-md-4 control-label"></label>
        <div class="col-lg-8 col-md-8">

            {!! Form::submit(' Save ', ['class'=>'btn  btn-primary text-white','id'=>'saveBtn']) !!}

            <a href="{{route('article')}}">
            {!! Form::button('Back', ['class'=>'btn btn-warning text-white']) !!} </a>
        </div>
    </div>

</div> 
