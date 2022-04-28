{!! Form::open(['route' => 'salaryServiceAssigneds.store']) !!}
<div class="row">
    <div class="col">
        <div class="form-group">
            {!! Form::label('service_id', 'Service:') !!}
            {!! Form::text('service_id', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <p>Type of Salary:</p>
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="type_salary" name="type_salary">
                <label class="custom-control-label" for="type_salary">Monthly/PerHour</label>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            {!! Form::label('salary', 'Salary:') !!}
            {!! Form::text('salary', null, ['class' => 'form-control','maxlength' => 255, 'required' => true]) !!}
        </div>
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('salaryServiceAssigneds.index') }}" class="btn btn-secondary">Cancel</a>
</div>

{!! Form::close() !!}