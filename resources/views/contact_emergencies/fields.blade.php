<div class="row">
    <div class="col">
        <!-- First Name Field -->
        <div class="form-group">
            {!! Form::label('first_name', 'First Name:') !!}
            {!! Form::text('first_name', null, ['class' => 'form-control','maxlength' => 255, 'required' => true ]) !!}
        </div>
    </div>
    <div class="col">
        <!-- Mi Field -->
        <div class="form-group">
            {!! Form::label('mi', 'M.I.:') !!}
            {!! Form::text('mi', null, ['class' => 'form-control','maxlength' => 255,]) !!}
        </div>
    </div>
    <div class="col">
        <!-- Last Name Field -->
        <div class="form-group">
            {!! Form::label('last_name', 'Last Name:') !!}
            {!! Form::text('last_name', null, ['class' => 'form-control','maxlength' => 255, 'required' => true]) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <!-- Street Addres Field -->
        <div class="form-group">
            {!! Form::label('street_addres', 'Street Addres:') !!}
            {!! Form::text('street_addres', null, ['class' => 'form-control','maxlength' => 255, 'required' => $isRequired]) !!}
        </div>
    </div>
    <div class="col">
        <!-- Apartment Unit Field -->
        <div class="form-group">
            {!! Form::label('apartment_unit', 'Apartment Unit:') !!}
            {!! Form::text('apartment_unit', null, ['class' => 'form-control','maxlength' => 255,]) !!}
        </div>
    </div>
    <div class="col">
        <!-- City Field -->
        <div class="form-group">
            {!! Form::label('city', 'City:') !!}
            {!! Form::text('city', null, ['class' => 'form-control','maxlength' => 255, 'required' => $isRequired]) !!}
        </div>
    </div>
    <div class="col">
        <!-- Statu Field -->
        <div class="form-group">
            {!! Form::label('state', 'State:') !!}
            {!! Form::text('state', null, ['class' => 'form-control','maxlength' => 255, 'required' => $isRequired]) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <!-- Zip Code Field -->
        <div class="form-group">
            {!! Form::label('zip_code', 'Zip Code:') !!}
            {!! Form::text('zip_code', null, ['class' => 'form-control','maxlength' => 255, 'required' => $isRequired]) !!}
        </div>
    </div>
    <div class="col">
        <!-- Home Phone Field -->
        <div class="form-group">
            {!! Form::label('home_phone', 'Home Phone:') !!}
            {!! Form::text('home_phone', null, ['class' => 'form-control','maxlength' => 255, 'required' => $isRequired]) !!}
        </div>
    </div>
    <div class="col">
        <!-- Alternate Phone Field -->
        <div class="form-group">
            {!! Form::label('alternate_phone', 'Alternate Phone:') !!}
            {!! Form::text('alternate_phone', null, ['class' => 'form-control','maxlength' => 255]) !!}
        </div>
    </div>
</div>

<div class="form-group" hidden>
    <label for="idContact">idContact</label>
    <input type="text" value="{{$contactEmergency->id}}" class="form-control" id="exampleInputEmail1" name="idContact">
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Next', ['class' => 'btn btn-primary']) !!}
    <a href="{{ redirect()->back()->getTargetUrl() }}" class='btn btn-info'>Back</a>
    @if($contactEmergency->guardian == 0)
    <a href="{{ route($urlUser . '.show', [$contactEmergency->user_id]) }}" class='btn btn-success'>Show</a>
    <a href="{{ route($urlUser . '.index') }}" class="btn btn-secondary">Cancel</a>
    @else
    <a href="{{ route('patientes.show', [$contactEmergency->user_id]) }}" class='btn btn-success'>Show</a>
    <a href="{{ route('patientes.index') }}" class="btn btn-secondary">Cancel</a>
    @endif
</div>
