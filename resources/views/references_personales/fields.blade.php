<div class="row">
    <div class="col">
        <!-- Name Job Field -->
        <div class="form-group">
            {!! Form::label('name_job', 'Name:') !!}
            {!! Form::text('name_job', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => true]) !!}
        </div>
    </div>
    <div class="col">
        <!-- Address Field -->
        <div class="form-group">
            {!! Form::label('address', 'Address:') !!}
            {!! Form::text('address', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => true]) !!}
        </div>
    </div>
    <div class="col">
        <!-- Phone Field -->
        <div class="form-group">
            {!! Form::label('phone', 'Phone:') !!}
            {!! Form::text('phone', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => true]) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <!-- Ocupation Field -->
        <div class="form-group">
            {!! Form::label('ocupation', 'Ocupation:') !!}
            {!! Form::text('ocupation', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => true]) !!}
        </div>
    </div>
    <div class="col">
        <!-- Time Field -->
        <div class="form-group">
            {!! Form::label('time', 'Years Known:') !!}
            {!! Form::text('time', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => true]) !!}
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