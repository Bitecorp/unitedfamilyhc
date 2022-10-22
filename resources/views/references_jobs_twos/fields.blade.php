<div class="row">
    <div class="col">
        <!-- Name And Address Field -->
        <div class="form-group">
            {!! Form::label('name_and_address', 'Employer Name and Address:') !!}
            {!! Form::text('name_and_address', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
        </div>
    </div>
    <div class="col">
        <!-- Position Field -->
        <div class="form-group">
            {!! Form::label('position', 'Position Title/Dutles Skill:') !!}
            {!! Form::text('position', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
        </div>
    </div>
    <div class="col">
        <!-- Supervisor Field -->
        <div class="form-group">
            {!! Form::label('supervisor', 'Supervisor Name:') !!}
            {!! Form::text('supervisor', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
        </div>
    </div>
    <div class="col">
        <!-- Phone Supervisor Field -->
        <div class="form-group">
            {!! Form::label('phone_supervisor', 'Supervisor Phone:') !!}
            {!! Form::text('phone_supervisor', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <!-- Dates Employed Field -->
        <div class="form-group">
            {!! Form::label('dates_employed', 'Dates Employed From:') !!}
            {!! Form::text('dates_employed', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
        </div>
    </div>
    <div class="col">
        <!-- To Dates Employed Field -->
        <div class="form-group">
            {!! Form::label('to_dates_employed', 'To:') !!}
            {!! Form::text('to_dates_employed', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
        </div>
    </div>
    <div class="col">
        <!-- Reason Leaving Field -->
        <div class="form-group">
            {!! Form::label('reason_leaving', 'Reason Leaving:') !!}
            {!! Form::text('reason_leaving', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Next', ['class' => 'btn btn-primary']) !!}
    <button id="btn_back" type="button" class="btn btn-info">Back</button>
    @push('scripts')
        <script>
            let p = document.getElementById("btn_back"); // Encuentra el elemento "p" en el sitio
            p.onclick = muestraAlerta; // Agrega función onclick al elemento
                
            function muestraAlerta(evento) {
                window.history.back();
            }
        </script>
    @endpush
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