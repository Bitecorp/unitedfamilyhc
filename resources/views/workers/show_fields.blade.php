<div class="row">
    <div class="col">
        <!-- First Name Field -->
        <div class="form-group">
            {!! Form::label('first_name', 'First Name:') !!}
            <input type="text" name="first_name" class="form-control" readonly value="{{ $worker->first_name }}" >
        </div>
    </div>
    <div class="col">
        <!-- Mi Field -->
        <div class="form-group">
            {!! Form::label('mi', 'Mi:') !!}
            <input type="text" name="mi" class="form-control" readonly value="{{ $worker->mi }}" >
        </div>
    </div>
    <div class="col">
        <!-- Last Name Field -->
        <div class="form-group">
            {!! Form::label('last_name', 'Last Name:') !!}
            <input type="text" name="last_name" class="form-control" readonly value="{{ $worker->last_name }}" >
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <!-- Street Addres Field -->
        <div class="form-group">
            {!! Form::label('street_addres', 'Street Addres:') !!}
            <input type="text" name="street_addres" class="form-control" readonly value="{{ $worker->street_addres }}" >
        </div>
    </div>
    <div class="col">
        <!-- Apartment Unit Field -->
        <div class="form-group">
            {!! Form::label('apartment_unit', 'Apartment Unit:') !!}
            <input type="text" name="apartment_unit" class="form-control" readonly value="{{ $worker->apartment_unit }}" >
        </div>
    </div>
    <div class="col">
        <!-- City Field -->
        <div class="form-group">
            {!! Form::label('city', 'City:') !!}
            <input type="text" name="city" class="form-control" readonly value="{{ $worker->city }}" >
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <!-- Statu Field -->
        <div class="form-group">
            {!! Form::label('state', 'State:') !!}
            <input type="text" name="state" class="form-control" readonly value="{{ $worker->state }}" >
        </div>
    </div>
    <div class="col">
        <!-- Zip Code Field -->
        <div class="form-group">
            {!! Form::label('zip_code', 'Zip Code:') !!}
            <input type="text" name="zip_code" class="form-control" readonly value="{{ $worker->zip_code }}" >
        </div>
    </div>
    <div class="col">
        <!-- Home Phone Field -->
        <div class="form-group">
            {!! Form::label('home_phone', 'Home Phone:') !!}
            <input type="text" name="home_phone" class="form-control" readonly value="{{ $worker->home_phone}}" >
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <!-- Alternate Phone Field -->
        <div class="form-group">
            {!! Form::label('alternate_phone', 'Alternate Phone:') !!}
            <input type="text" name="alternate_phone" class="form-control" readonly value="{{ $worker->alternate_phone }}" >
        </div>
    </div>
    <div class="col">
        <!-- Ssn Field -->
        <div class="form-group">
            {!! Form::label('ssn', 'SSN:') !!}
            <input type="text" name="ssn" class="form-control" readonly value="{{ $worker->ssn }}" >
        </div>
    </div>
    <div class="col">
        <!-- Birth Date Field -->
        <div class="form-group">
            {!! Form::label('birth_date', 'Birth Date:') !!}
            <input type="date" name="birth_date" class="form-control" readonly value={{ $worker->birth_date }} >
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <!-- Marital Status Field -->
        <div class="form-group">
            {!! Form::label('marital_status', 'Marital Status:') !!}
            @foreach($maritalStatus as $key => $maritalS)
                @if($maritalS->id == $worker->marital_status)
                    <input type="text" name="marital_status" class="form-control" readonly value="{{ $maritalS->name_marital_status }}" >
                @endif
            @endforeach
        </div>
    </div>
    <div class="col">
        <!-- Email Field -->
        <div class="form-group">
            {!! Form::label('email', 'Email:') !!}
            <input type="email" name="email" class="form-control" readonly value="{{ $worker->email}}" >
        </div>
    </div>
    <div class="col">
        <!-- Role Id Field -->
        <div class="form-group">
            {!! Form::label('role_id', 'Role:') !!}
            @foreach($roles as $key => $role)
                @if($role->id == $worker->role_id)
                    <input type="text" name="role_id" class="form-control" readonly value="{{ $role->name_role }}" >
                @endif
            @endforeach
        </div>
    </div>
    <div class="col">
        <!-- Statu Id Field -->
        <div class="form-group">
            {!! Form::label('statu_id', 'Status:') !!}
             @foreach($status as $key => $statu)
                @if($statu->id == $worker->statu_id)
                    <input type="text" name="statu_id" class="form-control" readonly value="{{ $statu->name_status }}" >
                @endif
            @endforeach
        </div>
    </div>
</div>

