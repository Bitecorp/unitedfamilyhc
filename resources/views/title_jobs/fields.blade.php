<!-- Name Job Field -->
<div class="form-group">
    {!! Form::label('name_job', 'Name Job:') !!}
    {!! Form::text('name_job', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => true]) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('titleJobs.index') }}" class="btn btn-secondary">Cancel</a>
</div>
