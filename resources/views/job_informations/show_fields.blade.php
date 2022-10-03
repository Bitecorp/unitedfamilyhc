<div class="row">
    <div class="col">
        <!-- Zip Code Field -->
        <div class="form-group">
            {!! Form::label('title', 'Title:') !!}
            @foreach($titleJobs as $job)
                @if($job->id == $jobInformation->supervisor)
                    <input type="text" name="title" class="form-control" readonly value="{{ $job->name_job }}" >
                @endif
            @endforeach
        </div>
    </div>
    <div class="col">
        <!-- Home Phone Field -->
        <div class="form-group">
            {!! Form::label('supervisor', 'Supervisor:') !!}
            @foreach($workers as $supervisor)
                @if($supervisor->id == $jobInformation->supervisor)
                    <input type="text" name="supervisor" class="form-control" readonly value="{{ $supervisor->first_name }} {{ $supervisor->last_name }}" >
                @endif
            @endforeach
        </div>
    </div>
    <div class="col">
        <!-- Zip Code Field -->
        <div class="form-group">
             {!! Form::label('work_phone', 'Work Phone:') !!}
             @foreach($workers as $supervisor)
                @if($supervisor->id == $jobInformation->supervisor)
                    <input type="text" name="work_phone" class="form-control" readonly value="{{ $supervisor->home_phone }}" >
                @endif
            @endforeach
        </div>
    </div>
    <div class="col">
        <!-- Alternate Phone Field -->
        <div class="form-group">
            {!! Form::label('work_name_location', 'Work Name Location:') !!}
            @foreach($locations as $location)
                @if($location->id == $jobInformation->work_name_location)
                    <input type="text" name="work_name_location" class="form-control" readonly value="{{ $location->name_location }}">
                @endif
            @endforeach
        </div>
    </div>
    <div class="col">
        <!-- Alternate Phone Field -->
        <div class="form-group">
            {!! Form::label('initial_salary', 'Initial Salary:') !!}
            <input type="text" name="work_name_location" class="form-control" readonly value="{{ isset($jobInformation->initial_salary) && !empty($jobInformation->initial_salary) ? $jobInformation->initial_salary : '0.00' }} $(USD)">
        </div>
    </div>
</div>

<!-- <div class="row">
    <div class="col">
        
        <div class="form-group">
             {!! Form::label('work_phone', 'Work Phone:') !!}
            <input type="text" name="work_phone" class="form-control" readonly value="{{ $jobInformation->work_phone }}" >
        </div>
    </div>
    <div class="col">
        
        <div class="form-group">
            {!! Form::label('type_salary', 'Type Salary:') !!}
            @if($jobInformation->type_salary == 0)
                <input type="text" name="type_salary" class="form-control" readonly value="MONTHLY" >
            @else
                <input type="text" name="type_salary" class="form-control" readonly value="PER HOUR" >
            @endif
        </div>
    </div>
    <div class="col">
        
        <div class="form-group">
            {!! Form::label('salary', 'Work Name Location:') !!}
            <input type="text" name="salary" class="form-control" readonly value="{{ $jobInformation->salary }}" >
        </div>
    </div>
</div> -->


<!-- Title Field -->
<!-- <div class="form-group">
    {!! Form::label('title', 'Title:') !!}
    <p>{{ $jobInformation->title }}</p>
</div> -->


