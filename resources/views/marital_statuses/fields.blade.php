<!-- Name Marital Status Field -->
<div class="form-group">
    {!! Form::label('name_marital_status', 'Name Marital Status:') !!}
    {!! Form::text('name_marital_status', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => true]) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('maritalStatuses.index') }}" class="btn btn-secondary">Cancel</a>
</div>
