<?php

$required = false;
if($confirmationIndependent->independent_contractor == 1 && $confirmationIndependent->personalEmpresa == 2){
    $required = true;
}

?>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Company Data</h4>
    </div>
    <div class="panel-body">
        
            <div class="col">
                <!-- Name Field -->
                <div class="form-group">
                    {!! Form::label('name', 'Name:') !!}
                    {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => $required]) !!}
                </div>
            </div>
            <div class="col">
                <!-- Street Address Field -->
                <div class="form-group">
                    {!! Form::label('street_addres', 'Street Addres:') !!}
                    {!! Form::text('street_addres', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => $required]) !!}
                </div>
            </div>
            <div class="col">
                <!-- Apartment Unit Field -->
                <div class="form-group">
                    {!! Form::label('apartment_unit', 'Apartment Unit:') !!}
                    {!! Form::text('apartment_unit', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => $required]) !!}
                </div>
            </div>
        
            <div class="col">
                <!-- City Field -->
                <div class="form-group">
                    {!! Form::label('city', 'City:') !!}
                    {!! Form::text('city', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => $required]) !!}
                </div>
            </div>
            <div class="col">
                <!-- State Field -->
                <div class="form-group">
                    {!! Form::label('state', 'State:') !!}
                    {!! Form::text('state', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => $required]) !!}
                </div>
            </div>
            <div class="col">
                <!-- Zip Code Field -->
                <div class="form-group">
                    {!! Form::label('zip_code', 'Zip Code:') !!}
                    {!! Form::text('zip_code', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => $required]) !!}
                </div>
            </div>
        
            <div class="col">
                <!-- Home Phone Field -->
                <div class="form-group">
                    {!! Form::label('home_phone', 'Home Phone:') !!}
                    {!! Form::text('home_phone', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => $required]) !!}
                </div>
            </div>
            <div class="col">
                <!-- Alternate Phone Field -->
                <div class="form-group">
                    {!! Form::label('alternate_phone', 'Alternate Phone:') !!}
                    {!! Form::text('alternate_phone', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => $required]) !!}
                </div>
            </div>
            <div class="col">
                <!-- Ssn Field -->
                <div class="form-group">
                    {!! Form::label('ssn', 'Employer Identification Number:') !!}
                    {!! Form::text('ssn', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => $required]) !!}
                </div>
            </div>
            <div class="col">
                <!-- Email Field -->
                <div class="form-group">
                    {!! Form::label('email', 'Email:') !!}
                    {!! Form::email('email', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => $required]) !!}
                </div>
            </div>

    </div>
</div>