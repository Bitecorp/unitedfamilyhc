<div class="row">
    <!-- Time Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('time', 'Time:') !!}
        {!! Form::text('time', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => 'true']) !!}
    </div>
    <div class="col">
        <div class="form-group">
            <p>Type of Unit:</p>
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="type_unidad" name="type_unidad" {{ isset($units) && $units->type_unidad == 1 ? 'checked' : '' }}>
                <label class="custom-control-label" for="type_unidad">Per Minute - Per Hour</label>
            </div>
        </div>
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('units.index') }}" class="btn btn-secondary">Cancel</a>
</div>
