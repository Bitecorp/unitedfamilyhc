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
            {!! Form::text('name_sub_service', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => true]) !!}
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <p>Type of Salary:</p>
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="type_salary" name="type_salary" value="0" {{ isset($subServices) && $subServices->type_salary == 1 ? 'checked' : '' }}>
                <label class="custom-control-label" for="type_salary">Monthly/PerHour</label>
            </div>
        </div>
    </div>
</div>

<div class="row" >
    <div class="col">
        <!-- Price Sub Service Field -->
        <div class="form-group">
            {!! Form::label('price_sub_service', 'Customer Billing:') !!}
            {!! Form::text('price_sub_service', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => true]) !!}
        </div>
    </div>
    <div class="col" id='unitCustomer' {{ isset($subServices) && $subServices->type_salary == 1 ? '' : 'hidden' }}>
        <!-- Role Id Field -->
        <div class="form-group">
            {!! Form::label('unit_customer_id', 'Unit Customer:') !!}
            <select name='unit_customer_id' id='unit_customer_id' class="form-control" {{ isset($subServices) && $subServices->type_salary  == 1 ? 'required' : ''}}>
                <option value='' {{ isset($subServices) && isset($subServices->unit_customer_id) && !empty($subServices->unit_customer_id) ? 'selected' : '' }} >Select Option</option>
                @foreach($units as $unit)
                    @if(!empty($unit))
                        <option value='{{ $unit->id }}' {{ isset($subServices) && isset($subServices->unit_customer_id) && $subServices->unit_customer_id == $unit->id ? 'selected' : '' }}> {{ $unit->time }} {{ $unit->type_unidad == 0 ? 'Minute' : 'Hour' }} </option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="col">
        <!-- Price Sub Service Field -->
        <div class="form-group">
            {!! Form::label('worker_payment', 'Worker Payment:') !!}
            {!! Form::text('worker_payment', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => true]) !!}
        </div>
    </div>
    <div class="col" id='unitWorker' {{ isset($subServices) && $subServices->type_salary == 1 ? '' : 'hidden' }}>
        <!-- Role Id Field -->
        <div class="form-group">
            {!! Form::label('unit_worker_payment', 'Unit Customer:') !!}
            <select name='unit_worker_payment_id' id='unit_worker_payment_id' class="form-control" {{ isset($subServices) && $subServices->type_salary  == 1 ? 'required' : ''}}>
                <option value='' {{ isset($subServices) && isset($subServices->unit_worker_payment_id) && !empty($subServices->unit_worker_payment_id)  ? 'selected' : '' }} >Select Option</option>
                @if(isset($units) && !empty($units))
                    @foreach($units as $unit)
                        @if(isset($unit) && !empty($unit))
                            <option value='{{ $unit->id }}' {{ isset($subServices) && isset($subServices->unit_worker_payment_id) && $subServices->unit_worker_payment_id == $unit->id ? 'selected' : '' }}> {{ $unit->time }} {{ $unit->type_unidad == 0 ? 'Minute' : 'Hour' }} </option>
                        @endif
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col">
        <!-- Documents Field -->
        <div class="form-group">
            {!! Form::label('config_validate', 'Tasks:') !!}
            <select class="form-control" name='config_validate[]' multiple="multiple">
                @if(!empty($tasks))
                    @foreach($tasks as $task)
                       <option value='{{ $task->id }}' {{ isset($task->assigned) &&  !empty($task->assigned) && $task->assigned == true ? 'selected' : '' }}>{{ $task->name_task }}</option>
                    @endforeach
                @endif
            </select>           
        </div>
    </div>
</div>

<script>
    const radio = document.getElementById('type_salary');

    radio.addEventListener('change', (event) => {
        if (event.currentTarget.checked == true) {
            document.getElementById('unitWorker').removeAttribute('hidden');
            document.getElementById('unitCustomer').removeAttribute('hidden');
            document.getElementById('unit_customer_id').setAttribute('required', 'true');
            document.getElementById('unit_worker_payment_id').setAttribute('required', 'true');
        }else{
            document.getElementById('unit_customer_id').removeAttribute('required');
            document.getElementById('unit_worker_payment_id').removeAttribute('required');
            document.getElementById('unitWorker').setAttribute('hidden', 'true');
            document.getElementById('unitCustomer').setAttribute('hidden', 'true');
        }
    })
</script>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('subServices.list', [$service->id]) }}" class="btn btn-secondary">Cancel</a>
</div>
