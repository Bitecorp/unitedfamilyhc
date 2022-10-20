
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


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Next', ['class' => 'btn btn-primary']) !!}
    <a href="{{ redirect()->back()->getTargetUrl() }}" class='btn btn-info'>Back</a>
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
