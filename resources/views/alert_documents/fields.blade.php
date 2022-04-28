<!-- First Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('first_name', 'First Name:') !!}
    {!! Form::text('first_name', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Last Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('last_name', 'Last Name:') !!}
    {!! Form::text('last_name', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Mi Field -->
<div class="form-group col-sm-6">
    {!! Form::label('mi', 'Mi:') !!}
    {!! Form::text('mi', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Street Addres Field -->
<div class="form-group col-sm-6">
    {!! Form::label('street_addres', 'Street Addres:') !!}
    {!! Form::text('street_addres', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Apartment Unit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('apartment_unit', 'Apartment Unit:') !!}
    {!! Form::text('apartment_unit', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- City Field -->
<div class="form-group col-sm-6">
    {!! Form::label('city', 'City:') !!}
    {!! Form::text('city', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- State Field -->
<div class="form-group col-sm-6">
    {!! Form::label('state', 'State:') !!}
    {!! Form::text('state', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Zip Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('zip_code', 'Zip Code:') !!}
    {!! Form::text('zip_code', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Home Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('home_phone', 'Home Phone:') !!}
    {!! Form::text('home_phone', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Alternate Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('alternate_phone', 'Alternate Phone:') !!}
    {!! Form::text('alternate_phone', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Ssn Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ssn', 'Ssn:') !!}
    {!! Form::text('ssn', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Birth Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('birth_date', 'Birth Date:') !!}
    {!! Form::text('birth_date', null, ['class' => 'form-control','id'=>'birth_date']) !!}
</div>

@push('scripts')
   <script type="text/javascript">
           $('#birth_date').datetimepicker({
               format: 'YYYY-MM-DD HH:mm:ss',
               useCurrent: true,
               icons: {
                   up: "icon-arrow-up-circle icons font-2xl",
                   down: "icon-arrow-down-circle icons font-2xl"
               },
               sideBySide: true
           })
       </script>
@endpush


<!-- Marital Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('marital_status', 'Marital Status:') !!}
    {!! Form::text('marital_status', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Email Verified At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email_verified_at', 'Email Verified At:') !!}
    {!! Form::text('email_verified_at', null, ['class' => 'form-control','id'=>'email_verified_at']) !!}
</div>

@push('scripts')
   <script type="text/javascript">
           $('#email_verified_at').datetimepicker({
               format: 'YYYY-MM-DD HH:mm:ss',
               useCurrent: true,
               icons: {
                   up: "icon-arrow-up-circle icons font-2xl",
                   down: "icon-arrow-down-circle icons font-2xl"
               },
               sideBySide: true
           })
       </script>
@endpush


<!-- Password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password', 'Password:') !!}
    {!! Form::password('password', ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Role Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('role_id', 'Role Id:') !!}
    {!! Form::text('role_id', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Statu Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('statu_id', 'Statu Id:') !!}
    {!! Form::text('statu_id', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Remember Token Field -->
<div class="form-group col-sm-6">
    {!! Form::label('remember_token', 'Remember Token:') !!}
    {!! Form::text('remember_token', null, ['class' => 'form-control','maxlength' => 100,'maxlength' => 100]) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('alertDocuments.index') }}" class="btn btn-secondary">Cancel</a>
</div>
