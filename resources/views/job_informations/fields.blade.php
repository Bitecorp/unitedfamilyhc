<script type="text/javascript">
    // funcion que se ejecuta cada vez que se selecciona una opción

    function cambioOpciones() {
        document.getElementById('work_phone').value = document.getElementById('supervisor').value;
    }
</script>

<div class="row">
    <div class="col">
        <!-- Title Field -->
        <div class="form-group">
            {!! Form::label('title', 'Title:') !!}
            <select name='title' class="form-control">
                @foreach($titleJobs as $titleJob)
                @if(empty($jobInformation))
                <option value='{{ $titleJob->id }}'>{{ $titleJob->name_job }}</option>
                @else
                <option value='{{ $titleJob->id }}' {{ $jobInformation->title == $titleJob->id ? 'selected' : '' }}>{{ $titleJob->name_job }}</option>
                @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="col">
        <!-- Supervisor Field -->
        <div class="form-group">
            {!! Form::label('supervisor', 'Manager:') !!}
            <select id='supervisor' name='supervisor' class="form-control" onchange='cambioOpciones();' required>
                <option value=''>Selecciona una opción</option>
                @foreach($workers as $manager)
                    @if ($manager->role_id == 1 || $manager->role_id == 3)
                        @if(empty($jobInformation))
                            <option value='{{ $manager->home_phone }}'>{{ $manager->first_name }} {{ $manager->last_name }}</option>
                        @else
                            <option value='{{ $manager->home_phone }}' {{ $jobInformation->supervisor == $manager->id ? 'selected' : '' }}>{{ $manager->first_name }} {{ $manager->last_name }}</option>
                        @endif
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="col">
        <!-- Work Phone Field -->
        <div class="form-group">
            {!! Form::label('work_phone', 'Work Phone:') !!}
            {!! Form::text('work_phone', null, ['class' => 'form-control','maxlength' => 255, 'required' => true, 'readonly' => 'true']) !!}
        </div>
    </div>
    <div class="col">
        <!-- Work Name Location Field -->
        <div class="form-group">
            {!! Form::label('work_name_location', 'Work Name Location:') !!}
            <select id='work_name_location' name='work_name_location' class="form-control" required>
                <option value=''>Selecciona una opción</option>
                @foreach($locations as $location)
                @if(empty($jobInformation))
                <option value='{{ $location->id }}'>{{ $location->name_location }}</option>
                @else
                <option value='{{ $location->id }}' {{ $jobInformation->work_name_location  == $location->id ? 'selected' : '' }}>{{ $location->name_location }}</option>
                @endif
                @endforeach
            </select>
        </div>
    </div>
</div>


<!-- <div class="row">
    <div class="col">
        
        <div class="form-group">
            {!! Form::label('work_phone', 'Work Phone:') !!}
            {!! Form::text('work_phone', null, ['class' => 'form-control','maxlength' => 255, 'required' => true, 'readonly' => 'true']) !!}
        </div>
    </div>
    <div class="col">
        
        <div class="form-group">
            <p>Type of Salary:</p>
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="type_salary" name="type_salary" {{ $jobInformation->type_salary == 1 ? 'checked' : '' }}>
                <label class="custom-control-label" for="type_salary">Monthly/PerHour</label>
            </div>
        </div>
    </div>
    <div class="col">
        
        <div class="form-group">
            {!! Form::label('salary', 'Salary:') !!}
            {!! Form::text('salary', null, ['class' => 'form-control','maxlength' => 255, 'required' => true]) !!}
        </div>
    </div>
</div> -->

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Next', ['class' => 'btn btn-primary']) !!}
    <?php
    $link = "$_SERVER[REQUEST_URI]";
    $stringSeparado = explode('/', $link);
    ?>
    @if($stringSeparado[2] === 'create')
    <a href="{{ route('workers.index') }}" class="btn btn-secondary">Cancel</a>
    @else
    <a href="{{ route('workers.show', [$stringSeparado[2]]) }}" class='btn btn-success'>Show</a>
    <a href="{{ route('workers.index') }}" class="btn btn-secondary">Cancel</a>
    @endif
</div>