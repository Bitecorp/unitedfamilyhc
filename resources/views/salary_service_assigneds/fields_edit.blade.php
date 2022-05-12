{!! Form::model($salaryServiceAssigneds, ['route' => ['salaryServiceAssigneds.update', $salaryServiceAssigneds->id], 'method' => 'patch']) !!}
<div class="row">
    <div class="col">
        <div class="form-group">
            {!! Form::label('service_id', 'Sub Service:') !!}
            <input type="text" name="service_id" class="form-control" readonly value="{{ $services->name_sub_service }}" >
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <p>Type of Salary:</p>
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="type_salary" name="type_salary" value="0" {{ isset($salaryServiceAssigneds) && $salaryServiceAssigneds->type_salary == 1 ? 'checked' : '' }}>
                <label class="custom-control-label" for="type_salary">Monthly/PerHour</label>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            {!! Form::label('customer_payment', 'Customer Billing:') !!}
            {!! Form::text('customer_payment', null, ['class' => 'form-control','maxlength' => 255, 'required' => true]) !!}
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            {!! Form::label('salary', 'Worker Payment:') !!}
            {!! Form::text('salary', null, ['class' => 'form-control','maxlength' => 255, 'required' => true]) !!}
        </div>
    </div>
</div>

<div class="col" hidden>
    <div class="form-group">
        {!! Form::label('user_id', 'User ID:') !!}
        {!! Form::text('user_id', $salaryServiceAssigneds->user_id,['class' => 'form-control','maxlength' => 255]) !!}
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('workers.show', [$salaryServiceAssigneds->user_id]) }}" class="btn btn-secondary">Cancel</a>
</div>

{!! Form::close() !!}
