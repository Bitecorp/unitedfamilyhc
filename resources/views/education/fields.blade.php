<div class="row">
    <div class="col">
        <!-- High School Field -->
        <div class="form-group">
            {!! Form::label('high_school', 'High School:') !!}
            {!! Form::text('high_school', null, ['class' => 'form-control','maxlength' => 255, 'required' => true]) !!}
        </div>
    </div>
    <div class="col">
        <!-- College University Field -->
        <div class="form-group">
            {!! Form::label('college_university', 'College University:') !!}
            {!! Form::text('college_university', null, ['class' => 'form-control','maxlength' => 255,]) !!}
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
