<!-- Name Role Field -->
<div class="form-group">
    {!! Form::label('title_reason', 'Reason Memo:') !!}
    {!! Form::text('title_reason', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255, 'required' => true]) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('reasonsMemos.index') }}" class="btn btn-secondary">Cancel</a>
</div>
