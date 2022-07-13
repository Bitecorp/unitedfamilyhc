
    <div class="col mt-2">
        <!-- Zip Code Field -->
        <div class="form-group">
            {!! Form::label('name_and_address', 'Name And Address:') !!}
            <input type="name_and_address" name="title" class="form-control" readonly value="{{ $referencesJobsTwo->name_and_address }}" >
        </div>
    </div>
    <div class="col">
        <!-- Home Phone Field -->
        <div class="form-group">
            {!! Form::label('position', 'Position:') !!}
            <input type="text" name="position" class="form-control" readonly value="{{ $referencesJobsTwo->position }}" >
        </div>
    </div>
    <div class="col">
        <!-- Alternate Phone Field -->
        <div class="form-group">
            {!! Form::label('work_name_location', 'Work Name Location:') !!}
            <input type="text" name="supervisor" class="form-control" readonly value="{{ $referencesJobsTwo->supervisor }}">
        </div>
    </div>

    <div class="col">
        <!-- Zip Code Field -->
        <div class="form-group">
            {!! Form::label('phone_supervisor', 'Phone Supervisor:') !!}
            <input type="phone_supervisor" name="title" class="form-control" readonly value="{{ $referencesJobsTwo->phone_supervisor }}" >
        </div>
    </div>
    <div class="col">
        <!-- Home Phone Field -->
        <div class="form-group">
            {!! Form::label('dates_employed', 'Dates Employed:') !!}
            <input type="text" name="dates_employed" class="form-control" readonly value="{{ $referencesJobsTwo->dates_employed }}" >
        </div>
    </div>
    <div class="col">
        <!-- Alternate Phone Field -->
        <div class="form-group">
            {!! Form::label('to_dates_employed', 'To Dates Employed:') !!}
            <input type="text" name="to_dates_employed" class="form-control" readonly value="{{ $referencesJobsTwo->to_dates_employed }}">
        </div>
    </div>
    <div class="col">
        <!-- Alternate Phone Field -->
        <div class="form-group">
            {!! Form::label('reason_leaving', 'Reason Leaving:') !!}
            <input type="text" name="reason_leaving" class="form-control" readonly value="{{ $referencesJobsTwo->reason_leaving }}">
        </div>
    </div>


