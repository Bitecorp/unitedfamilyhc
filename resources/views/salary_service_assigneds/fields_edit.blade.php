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

    <div class="col" {{ strpos(URL::previous(), "workers") ? 'hidden' : ''}}>
        <div class="form-group">
            {!! Form::label('customer_payment', 'Customer Billing:') !!}
            {!! Form::text('customer_payment', null, ['class' => 'form-control','maxlength' => 255, 'required' => true]) !!}
        </div>
    </div>
    <div class="col" {{ strpos(URL::previous(), "patientes") ? 'hidden' : ''}}>
        <div class="form-group">
            {!! Form::label('salary', 'Worker Payment:') !!}
            {!! Form::text('salary', null, ['class' => 'form-control','maxlength' => 255, 'required' => true]) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col" {{ strpos(URL::previous(), "workers") ? 'hidden' : ''}}>
        <!-- agent Id Field -->
        <div class="form-group">
            {!! Form::label('agent_id', 'Agent:') !!}
            <select name='agent_id' class="form-control">
                <option value='' selected>Select Agent..</option>
                @foreach($agents as $agent)
                    <option value='{{ $agent->id }}' {{ isset($config) && !empty($config) && isset($config->agent_id) && !empty($config->agent_id) && $config->agent_id == $agent->id ? 'selected' : '' }} >{{ $agent->first_name }} {{ $agent->last_name }} - {{ $agent->companie_agent }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col" {{ strpos(URL::previous(), "workers") ? 'hidden' : ''}}>
        <!-- Date Expedition Field -->
        <div class="form-group" >
            {!! Form::label('date_expedition', 'Date Expedition:') !!}
            <input type="date" placeholder="YYYY-MM-DD" name="date_expedition" id="date_expedition" class="form-control" value="{{ isset($config) && !empty($config) && isset($config->date_expedition) && !empty($config->date_expedition) ? date_format($config->date_expedition, 'Y-m-d') : '' }}">
        </div>
    </div>
    <div class="col" {{ strpos(URL::previous(), "workers") ? 'hidden' : ''}}>
        <!-- Date Expired Field -->
        <div class="form-group">
            {!! Form::label('date_expired', 'Date Expired:') !!}
            <input type="date" placeholder="YYYY-MM-DD" name="date_expired" id="date_expired" class="form-control" value="{{ isset($config) && !empty($config) && isset($config->date_expired) && !empty($config->date_expired) ? date_format($config->date_expired, 'Y-m-d') : '' }}">
        </div>
    </div>

    <div class="col" {{ strpos(URL::previous(), "workers") ? 'hidden' : ''}}>
        <div class="form-group">
            {!! Form::label('approved_units', 'Approved Units:') !!}
            <input type="text" name="approved_units" id="approved_units" class="form-control" value="{{ isset($config) && !empty($config) && isset($config->approved_units) && !empty($config->approved_units) ? $config->approved_units : '' }}">
        </div>
    </div>

    <div class="col">
        <!-- unit Id Field -->
        <div class="form-group">
            {!! Form::label('unit_id', 'Unit Of Time:') !!}
            <select name='unit_id' id='unit_id' class="form-control">
                <option value='' selected>Select Unit of Time..</option>
                @foreach($units as $unit)
                    <option value='{{ $unit->id }}' {{ isset($config) && !empty($config) && isset($config->unit_id) && !empty($config->unit_id) && $config->unit_id == $unit->id ? 'selected' : '' }} >{{ $unit->time }} {{ $unit->type_unidad == 0 ? 'Minutes' : 'Hour'}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col" {{ strpos(URL::previous(), "workers") ? 'hidden' : ''}}>
        <div class="form-group">
            {!! Form::label('code_patiente', 'Code Patiente:') !!}
            <input type="text" name="code_patiente" id="code_patiente" class="form-control" value="{{ isset($config) && !empty($config) && isset($config->code_patiente) && !empty($config->code_patiente) ? $config->code_patiente : '' }}">
        </div>
    </div>
</div>

<div class="row" {{ strpos(URL::previous(), "workers") ? 'hidden' : ''}}>
    <div class="col">
        <!-- Name Sub Service Field -->
        <div class="form-group">
            {!! Form::label('frequency', 'Frequency:') !!}
            {!! Form::text('frequency', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
        </div>
    </div>
    <div class="col">
        <!-- Name Sub Service Field -->
        <div class="form-group">
            {!! Form::label('billin_code', 'Billin Code:') !!}
            {!! Form::text('billin_code', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
        </div>
    </div>
    <div class="col">
        <!-- Name Sub Service Field -->
        <div class="form-group">
            {!! Form::label('aditional_one', 'Aditional One:') !!}
            {!! Form::text('aditional_one', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
        </div>
    </div>
    <div class="col">
        <!-- Name Sub Service Field -->
        <div class="form-group">
            {!! Form::label('aditional_two', 'Aditional Two:') !!}
            {!! Form::text('aditional_two', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<div class="row" {{ strpos(URL::previous(), "workers") ? 'hidden' : ''}}>
    <div class="col">
        <div class="form-group">
            {!! Form::label('note', 'Aditional Three:') !!}
            <textarea id="note" name="aditional_three" rows="25" class="form-control" >{{ isset($salaryServiceAssigneds) && $salaryServiceAssigneds->aditional_three ? $salaryServiceAssigneds->aditional_three : '' }}</textarea>
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            {!! Form::label('note', 'Aditional Four:') !!}
            <textarea id="note" name="aditional_four" rows="25" class="form-control"  >{{ isset($salaryServiceAssigneds) && $salaryServiceAssigneds->aditional_four ? $salaryServiceAssigneds->aditional_four : '' }}</textarea>
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
    @if($user->role_id != 4)
        <a href="{{ route('workers.show', [$salaryServiceAssigneds->user_id]) }}" class="btn btn-secondary">Cancel</a>
    @else
        <a href="{{ route('patientes.show', [$salaryServiceAssigneds->user_id]) }}" class="btn btn-secondary">Cancel</a>
    @endif
</div>

@push('scripts')
    <script> 

        const getValueInput = () =>{
            let inputValue = document.getElementById("approved_units").value; 
            if(unitedAdd != '' && unitedAdd != null && typeof unitedAdd != 'undefined' && typeof unitedAdd != undefined){
                document.getElementById("unit_id").required = true;
            }            
        }
        
    </script> 
@endpush
{!! Form::close() !!}
