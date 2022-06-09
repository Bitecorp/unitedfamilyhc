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

<div class="row">
    <div class="col">
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
    <div class="col">
        <!-- Date Expedition Field -->
        <div class="form-group">
            {!! Form::label('date_expedition', 'Date Expedition:') !!}
            <input type="date" placeholder="YYYY-MM-DD" name="date_expedition" id="date_expedition" class="form-control" value="{{ isset($config) && !empty($config) && isset($config->date_expedition) && !empty($config->date_expedition) ? date_format($config->date_expedition, 'Y-m-d') : '' }}">
        </div>
    </div>
    <div class="col">
        <!-- Date Expired Field -->
        <div class="form-group">
            {!! Form::label('date_expired', 'Date Expired:') !!}
            <input type="date" placeholder="YYYY-MM-DD" name="date_expired" id="date_expired" class="form-control" value="{{ isset($config) && !empty($config) && isset($config->date_expired) && !empty($config->date_expired) ? date_format($config->date_expired, 'Y-m-d') : '' }}">
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            {!! Form::label('approved_units', 'Approved Units:') !!}
            <input type="text" name="approved_units" id="approved_units" class="form-control" value="{{ isset($config) && !empty($config) && isset($config->approved_units) && !empty($config->approved_units) ? $config->approved_units : '' }}">
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            {!! Form::label('code_patiente', 'Code Patiente:') !!}
            <input type="text" name="code_patiente" id="code_patiente" class="form-control" value="{{ isset($config) && !empty($config) && isset($config->code_patiente) && !empty($config->code_patiente) ? $config->code_patiente : '' }}">
        </div>
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
    <script type="text/javascript">
        $(function () {
            $('#date_expedition').datetimepicker({
                format: 'YYYY-MM-DD',
                useCurrent: true,
                icons: {
                    up: "icon-arrow-up-circle icons font-2xl",
                    down: "icon-arrow-down-circle icons font-2xl"
                },
                sideBySide: true
            });
        });

        $(function () {
            $('#date_expired').datetimepicker({
                format: 'YYYY-MM-DD',
                useCurrent: true,
                icons: {
                    up: "icon-arrow-up-circle icons font-2xl",
                    down: "icon-arrow-down-circle icons font-2xl"
                },
                sideBySide: true
            });
        });
    </script>
@endpush

{!! Form::close() !!}
