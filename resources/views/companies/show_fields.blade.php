<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ isset($companies) && !empty($companies) ? $companies->name : ''}}</p>
</div>

<!-- Street Addres Field -->
<div class="form-group">
    {!! Form::label('street_addres', 'Street Addres:') !!}
    <p>{{ isset($companies) && !empty($companies) ? $companies->street_addres : '' }}</p>
</div>

<!-- Apartment Unit Field -->
<div class="form-group">
    {!! Form::label('apartment_unit', 'Apartment Unit:') !!}
    <p>{{ isset($companies) && !empty($companies) ? $companies->apartment_unit : '' }}</p>
</div>

<!-- City Field -->
<div class="form-group">
    {!! Form::label('city', 'City:') !!}
    <p>{{ isset($companies) && !empty($companies) ? $companies->city : '' }}</p>
</div>

<!-- State Field -->
<div class="form-group">
    {!! Form::label('state', 'State:') !!}
    <p>{{ isset($companies) && !empty($companies) ? $companies->state : '' }}</p>
</div>

<!-- Zip Code Field -->
<div class="form-group">
    {!! Form::label('zip_code', 'Zip Code:') !!}
    <p>{{ isset($companies) && !empty($companies) ? $companies->zip_code : '' }}</p>
</div>

<!-- Home Phone Field -->
<div class="form-group">
    {!! Form::label('home_phone', 'Home Phone:') !!}
    <p>{{ isset($companies) && !empty($companies) ? $companies->home_phone : '' }}</p>
</div>

<!-- Alternate Phone Field -->
<div class="form-group">
    {!! Form::label('alternate_phone', 'Alternate Phone:') !!}
    <p>{{ isset($companies) && !empty($companies) ? $companies->alternate_phone : '' }}</p>
</div>

<!-- Ssn Field -->
<div class="form-group">
    {!! Form::label('ssn', 'Ssn:') !!}
    <p>{{ isset($companies) && !empty($companies) ? $companies->ssn : '' }}</p>
</div>

<!-- Email Field -->
<div class="form-group">
    {!! Form::label('email', 'Email:') !!}
    <p>{{ isset($companies) && !empty($companies) ? $companies->email : '' }}</p>
</div>

