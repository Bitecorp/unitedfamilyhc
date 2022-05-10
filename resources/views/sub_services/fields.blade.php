<!-- Service Id Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('service_id', 'Service Id:') !!}
    {!! Form::text('service_id', $service->id,  ['class' => 'form-control','maxlength' => 255,'maxlength' => 255 ]) !!}
</div>


<div class="row">
    <div class="col">
        <!-- Name Sub Service Field -->
        <div class="form-group">
            {!! Form::label('name_sub_service', 'Name Sub Service:') !!}
            {!! Form::text('name_sub_service', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <p>Type of Salary:</p>
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="type_salary" name="type_salary" {{ isset($subServices) && $subServices->type_salary == 1 ? 'checked' : '' }}>
                <label class="custom-control-label" for="type_salary">Monthly/PerHour</label>
            </div>
        </div>
    </div>
    <div class="col">
        <!-- Price Sub Service Field -->
        <div class="form-group">
            {!! Form::label('price_sub_service', 'Customer Billing:') !!}
            {!! Form::text('price_sub_service', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
        </div>
    </div>
    <div class="col" hidden>
        <!-- Config Validate Field -->
        <div class="form-group">
            {!! Form::label('config_validate', 'Config Validate:') !!}
            {!! Form::text('config_validate', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('subServices.list', [$service->id]) }}" class="btn btn-secondary">Cancel</a>
</div>
