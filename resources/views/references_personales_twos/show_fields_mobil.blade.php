
    <div class="col mt-2">
        <!-- Zip Code Field -->
        <div class="form-group">
            {!! Form::label('name_job', 'Name Job:') !!}
            <input type="name_job" name="title" class="form-control" readonly value="{{ $referencesPersonalesTwo->name_job }}" >
        </div>
    </div>
    <div class="col">
        <!-- Home Phone Field -->
        <div class="form-group">
            {!! Form::label('address', 'Address:') !!}
            <input type="text" name="address" class="form-control" readonly value="{{ $referencesPersonalesTwo->address }}" >
        </div>
    </div>
    <div class="col">
        <!-- Alternate Phone Field -->
        <div class="form-group">
            {!! Form::label('phone', 'Phone:') !!}
            <input type="text" name="phone" class="form-control" readonly value="{{ $referencesPersonalesTwo->phone }}">
        </div>
    </div>

    <div class="col">
        <!-- Zip Code Field -->
        <div class="form-group">
            {!! Form::label('ocupation', 'Ocupation:') !!}
            <input type="ocupation" name="title" class="form-control" readonly value="{{ $referencesPersonalesTwo->ocupation }}" >
        </div>
    </div>
    <div class="col">
        <!-- Home Phone Field -->
        <div class="form-group">
            {!! Form::label('time', 'Time:') !!}
            <input type="text" name="time" class="form-control" readonly value="{{ $referencesPersonalesTwo->time }}" >
        </div>
    </div>

