<!-- Name Statu Field -->
<div class="form-group">
    {!! Form::label('name_status', 'Status:') !!}
    {!! Form::text('name_status', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255, 'required' => true]) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('status.index') }}" class="btn btn-secondary">Cancel</a>
</div>
