<div class="row">
    <div class="col">
        <!-- First Name Field -->
        <div class="form-group">
            {!! Form::label('first_name', 'First Name:') !!}
            <input type="text" name="first_name" class="form-control" readonly value="{{ $contactEmergency->first_name }}" >
        </div>
    </div>
    <div class="col">
        <!-- Mi Field -->
        <div class="form-group">
            {!! Form::label('mi', 'Mi:') !!}
            <input type="text" name="mi" class="form-control" readonly value="{{ $contactEmergency->mi }}" >
        </div>
    </div>
    <div class="col">
        <!-- Last Name Field -->
        <div class="form-group">
            {!! Form::label('last_name', 'Last Name:') !!}
            <input type="text" name="last_name" class="form-control" readonly value="{{ $contactEmergency->last_name }}" >
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <!-- Street Addres Field -->
        <div class="form-group">
            {!! Form::label('street_addres', 'Street Addres:') !!}
            <input type="text" name="street_addres" class="form-control" readonly value="{{ $contactEmergency->street_addres }}" >
        </div>
    </div>
    <div class="col">
        <!-- Apartment Unit Field -->
        <div class="form-group">
            {!! Form::label('apartment_unit', 'Apartment Unit:') !!}
            <input type="text" name="apartment_unit" class="form-control" readonly value="{{ $contactEmergency->apartment_unit }}" >
        </div>
    </div>
    <div class="col">
        <!-- City Field -->
        <div class="form-group">
            {!! Form::label('city', 'City:') !!}
            <input type="text" name="city" class="form-control" readonly value="{{ $contactEmergency->city }}" >
        </div>
    </div>
    <div class="col">
        <!-- Statu Field -->
        <div class="form-group">
            {!! Form::label('state', 'State:') !!}
            <input type="text" name="state" class="form-control" readonly value="{{ $contactEmergency->state }}" >
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <!-- Zip Code Field -->
        <div class="form-group">
            {!! Form::label('zip_code', 'Zip Code:') !!}
            <input type="text" name="zip_code" class="form-control" readonly value="{{ $contactEmergency->zip_code }}" >
        </div>
    </div>
    <div class="col">
        <!-- Home Phone Field -->
        <div class="form-group">
            {!! Form::label('home_phone', 'Home Phone:') !!}
            <input type="text" name="home_phone" class="form-control" readonly value="{{ $contactEmergency->home_phone}}" >
        </div>
    </div>
    <div class="col">
        <!-- Alternate Phone Field -->
        <div class="form-group">
            {!! Form::label('alternate_phone', 'Alternate Phone:') !!}
            <input type="text" name="alternate_phone" class="form-control" readonly value="{{ $contactEmergency->alternate_phone }}" >
        </div>
    </div>
</div>
