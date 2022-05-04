<!-- Name Task Field -->
<div class="form-group col">
    {!! Form::label('name_task', 'Name Task:') !!}
    {!! Form::text('name_task', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('taskSubServices.index') }}" class="btn btn-secondary">Cancel</a>
</div>
