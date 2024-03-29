@push('css')
    <link href="../assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
	<script src="../assets/plugins/select2/dist/js/select2.min.js"></script>
@endpush

{!! Form::model($salaryServiceAssigneds, ['route' => ['salaryServiceAssigneds.update', $salaryServiceAssigneds->id], 'method' => 'patch']) !!}
<div class="row">
    <div class="col">
        <div class="form-group">
            {!! Form::label('service_id', 'Sub Service:') !!}
            <input type="text" name="service_id" class="form-control" readonly value="{{ $services->name_sub_service }}" >
        </div>
    </div>

    @if (strpos(URL::previous(), "patientes"))
        <div class="col">
            <div class="form-group">
                <p>Values:</p>
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="billing_default" onclick="billingDefault()" name="billing_default" value="{{ isset($salaryServiceAssigneds) && !empty($salaryServiceAssigneds) && isset($salaryServiceAssigneds->customer_payment) && !empty($salaryServiceAssigneds->customer_payment) ? '0' : (isset($services) && !empty($services) && isset($services->price_sub_service) && !empty($services->price_sub_service) ? '1' : '0') }}" {{ isset($salaryServiceAssigneds) && !empty($salaryServiceAssigneds) && isset($salaryServiceAssigneds->customer_payment) && !empty($salaryServiceAssigneds->customer_payment) ? '' : (isset($services) && !empty($services) && isset($services->price_sub_service) && !empty($services->price_sub_service) ? 'checked' : '') }}>
                    <label class="custom-control-label" for="billing_default">Changed/Default</label>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="form-group">
                <p>Type of Salary:</p>
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="type_salary" name="type_salary" value="0" {{ isset($salaryServiceAssigneds) && !empty($salaryServiceAssigneds) && isset($salaryServiceAssigneds->type_salary) && !empty($salaryServiceAssigneds->type_salary) == 1 ? 'checked' : (isset($salaryServiceAssigneds) && $salaryServiceAssigneds->type_salary == 1 ? 'checked' : '') }} {{ isset($salaryServiceAssigneds) && !empty($salaryServiceAssigneds) && isset($salaryServiceAssigneds->customer_payment) && !empty($salaryServiceAssigneds->customer_payment) ? '' : (isset($services) && !empty($services) && isset($services->price_sub_service) && !empty($services->price_sub_service) ? 'disabled' : '') }}>
                    <label class="custom-control-label" for="type_salary">Monthly/PerHour</label>
                </div>
            </div>
        </div>
    @endif

    @if (strpos(URL::previous(), "workers"))
        <div class="col">
            <div class="form-group">
                <p>Values:</p>
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="payment_default" onclick="paymentDefault()" name="payment_default" value="{{ isset($salaryServiceAssigneds) && !empty($salaryServiceAssigneds) && isset($salaryServiceAssigneds->salary) && !empty($salaryServiceAssigneds->salary) ? '0' : (isset($services) && !empty($services) && isset($services->worker_payment) && !empty($services->worker_payment) ? '1' : '0') }}" {{ isset($salaryServiceAssigneds) && !empty($salaryServiceAssigneds) && isset($salaryServiceAssigneds->salary) && !empty($salaryServiceAssigneds->salary) ? '' : (isset($services) && !empty($services) && isset($services->worker_payment) && !empty($services->worker_payment) ? 'checked' : '') }}>
                    <label class="custom-control-label" for="payment_default">Changed/Default</label>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="form-group">
                <p>Type of Salary:</p>
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="type_salary" name="type_salary" value="0" {{ isset($salaryServiceAssigneds) && !empty($salaryServiceAssigneds) && isset($salaryServiceAssigneds->type_salary) && !empty($salaryServiceAssigneds->type_salary) == 1 ? 'checked' : (isset($salaryServiceAssigneds) && $salaryServiceAssigneds->type_salary == 1 ? 'checked' : '') }} {{ isset($salaryServiceAssigneds) && !empty($salaryServiceAssigneds) && isset($salaryServiceAssigneds->salary) && !empty($salaryServiceAssigneds->salary) ? '' : (isset($services) && !empty($services) && isset($services->worker_payment) && !empty($services->worker_payment) ? 'disabled' : '') }}>
                    <label class="custom-control-label" for="type_salary">Monthly/PerHour</label>
                </div>
            </div>
        </div>
    @endif

    <div class="col" {{ strpos(URL::previous(), "workers") ? 'hidden' : ''}}>
        <div class="form-group">
            {!! Form::label('customer_payment', 'Customer Billing:') !!}
            <input type="text" name="customer_payment" id="customer_payment" class="form-control" value="{{ isset($salaryServiceAssigneds) && !empty($salaryServiceAssigneds) && isset($salaryServiceAssigneds->customer_payment) && !empty($salaryServiceAssigneds->customer_payment) ? $salaryServiceAssigneds->customer_payment : (isset($services) && !empty($services) && isset($services->price_sub_service) && !empty($services->price_sub_service) ? $services->price_sub_service : '') }}" readonly>
        </div>
    </div>

    <div class="col" {{ strpos(URL::previous(), "patientes") ? 'hidden' : ''}}>
        <div class="form-group">
            {!! Form::label('salary', 'Worker Payment:') !!}
            <input type="text" name="salary" id="salary" class="form-control" value="{{ isset($salaryServiceAssigneds) && !empty($salaryServiceAssigneds) && isset($salaryServiceAssigneds->salary) && !empty($salaryServiceAssigneds->salary) ? $salaryServiceAssigneds->salary : (isset($services) && !empty($services) && isset($services->worker_payment) && !empty($services->worker_payment) ? $services->worker_payment : '') }}" {{ isset($salaryServiceAssigneds) && !empty($salaryServiceAssigneds) && isset($salaryServiceAssigneds->salary) && !empty($salaryServiceAssigneds->salary) ? '' : (isset($services) && !empty($services) && isset($services->worker_payment) && !empty($services->worker_payment) ? 'readonly' : '') }}>
        </div>
    </div>
</div>

<div class="row">
     <div class="col" id="show_unit_id">
        <!-- unit Id Field -->
        <div class="form-group">
            {!! Form::label('unit_id', 'Unit Of Time:') !!}
            <select name='unit_id' id='unit_id' class="default-select2 form-control" {{ strpos(URL::previous(), "workers") && isset($salaryServiceAssigneds) && !empty($salaryServiceAssigneds) && isset($salaryServiceAssigneds->salary) && !empty($salaryServiceAssigneds->salary) ? '' : (isset($services) && !empty($services) && isset($services->worker_payment) && !empty($services->worker_payment) ? 'readonly disabled' : (strpos(URL::previous(), "patientes") && isset($salaryServiceAssigneds) && !empty($salaryServiceAssigneds) && isset($salaryServiceAssigneds->customer_payment) && !empty($salaryServiceAssigneds->customer_payment) ? '' : (isset($services) && !empty($services) && isset($services->price_sub_service) && !empty($services->price_sub_service) ? 'readonly disabled' : ''))) }}>
                <option value='' selected>Select Unit of Time..</option>
                @foreach($units as $unit)
                    <option value='{{ $unit->id }}' 
                    {{ isset($config) && !empty($config) && isset($config->unit_id) && !empty($config->unit_id) && $config->unit_id == $unit->id ? 'selected' : 
                        (isset($services) && $services->unit_customer_id == $unit->id ? 'selected' : '') }} >{{ $unit->time }} {{ $unit->type_unidad == 0 ? 'Minutes' : 'Hour'}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @if((new \Jenssegers\Agent\Agent())->isDesktop())
        <div class="row" {{ strpos(URL::previous(), "patientes") ? 'hidden' : ''}}>
        <?php $styleNew = '0px'; ?>
    @else
        <div {{ strpos(URL::previous(), "patientes") ? 'hidden' : ''}}>
        <?php $styleNew = '20px'; ?>
    @endif
        <div class="col" style="margin-right:{{ $styleNew }};">
            <!-- Name Sub Service Field -->
            <div class="form-group">
                {!! Form::label('workerIdIc', 'Worker ID IConect:') !!}
                {!! Form::text('workerIdIc', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
            </div>
        </div>
        <div class="col" style="margin-right:{{ $styleNew }};">
            <!-- Name Sub Service Field -->
            <div class="form-group">
                {!! Form::label('aditional_one_w', 'Aditional One:') !!}
                {!! Form::text('aditional_one_w', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
            </div>
        </div>
        <div class="col" style="margin-right:{{ $styleNew }};">
            <!-- Name Sub Service Field -->
            <div class="form-group">
                {!! Form::label('aditional_two_w', 'Aditional Two:') !!}
                {!! Form::text('aditional_two_w', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
            </div>
        </div>
        <div class="col" style="margin-right:{{ $styleNew }};">
            <!-- Name Sub Service Field -->
            <div class="form-group">
                {!! Form::label('aditional_three_w', 'Aditional Tree:') !!}
                {!! Form::text('aditional_three_w', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
            </div>
        </div>
    </div>
    <div class="col" {{ strpos(URL::previous(), "workers") ? 'hidden' : ''}}>
        <!-- agent Id Field -->
        <div class="form-group">
            {!! Form::label('agent_id', 'Agent:') !!}
            <select name='agent_id' class="default-select2 form-control">
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

    <div class="col" {{ strpos(URL::previous(), "workers") ? 'hidden' : ''}}>
        <div class="form-group">
            {!! Form::label('code_patiente', 'Code Patient:') !!}
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
        $(".default-select2").select2();

        function billingDefault() {
            var testCheck = $('#billing_default').val();
            if(testCheck == 1 || testCheck == '1'){
                $('#type_salary').removeAttr('disabled');
                $('#customer_payment').removeAttr('readonly');
                $('#unit_id').removeAttr('readonly');
                $('#unit_id').removeAttr('disabled');
                $('#billing_default').val(0);
            }else{            
                var id_salary = "{{ isset($salaryServiceAssigneds) && !empty($salaryServiceAssigneds) ? $salaryServiceAssigneds->id : null }}";
                var billin_default = true;
                var payment_default = false;
                var url = "/returnValuesDefault";
                var token = '{{ csrf_token() }}';
                var id_user = "{{ isset($salaryServiceAssigneds) && !empty($salaryServiceAssigneds) ? $salaryServiceAssigneds->user_id : null }}";
                var urlRedirect = '/patientes/' + id_user + '?services';
                var urlClean = urlRedirect.replace("%20", "")

                $.ajax({
                    type: "post",
                    url: url,
                    dataType: 'json',
                    data: {
                    _token: token,
                    id_salary: id_salary,
                    billin_default: billin_default,
                    payment_default: payment_default
                },
                    success: function(data) {
                        location.replace(urlClean.replace(" ", ""));
                    },
                    error: function (error) { 
                        console.log(error);
                    }
                })

            }
        }


        function paymentDefault() {
            var testCheck = $('#payment_default').val();
            if(testCheck == 1 || testCheck == '1'){
                $('#type_salary').removeAttr('disabled');
                $('#salary').removeAttr('readonly');
                $('#unit_id').removeAttr('readonly');
                $('#unit_id').removeAttr('disabled');
                $('#payment_default').val(0);
            }else{
                var id_salary = '{{ isset($salaryServiceAssigneds) && !empty($salaryServiceAssigneds) ? $salaryServiceAssigneds->id : null }}';
                var billin_default = false;
                var payment_default = true;
                var url = "/returnValuesDefault";
                var token = '{{ csrf_token() }}';
                var id_user = '{{ isset($salaryServiceAssigneds) && !empty($salaryServiceAssigneds) ? $salaryServiceAssigneds->user_id : null }}';
                var urlRedirect = '/workers/' + id_user + '?services';
                var urlClean = urlRedirect.replace("%20", "");

                $.ajax({
                    type: "post",
                    url: url,
                    dataType: 'json',
                    data: {
                    _token: token,
                    id_salary: id_salary,
                    billin_default: billin_default,
                    payment_default: payment_default
                },
                    success: function(data) {
                        location.replace(urlClean.replace(" ", ""));
                    },
                    error: function (error) { 
                        console.log(error);
                    }
                })
            }
        }   
    </script>
    <script> 

        $("#approved_units").change(function() {
            let unitedAdd = document.getElementById("approved_units").value; 
            if(unitedAdd != '' && unitedAdd != null && typeof unitedAdd != 'undefined' && typeof unitedAdd != undefined){
                document.getElementById("unit_id").required = true;
            }            
        });

        $("#customer_payment").change(function() {
            let customer_payment= document.getElementById("customer_payment").value; 
            if(customer_payment != '' && customer_payment != null && typeof customer_payment != 'undefined' && typeof customer_payment != undefined && $('#type_salary').prop('checked')){
                document.getElementById("unit_id").required = true;
            }            
        });

        $("#type_salary").change(function() {
            if( $('#type_salary').prop('checked') ) {
                $('#show_unit_id').removeAttr('hidden');
                //$('#unit_id').attr('required', true);
            }else{
               // $('#unit_id').removeAttr('required');
                $('#show_unit_id').attr('hidden', true);
            }           
        });
        
    </script> 
@endpush
{!! Form::close() !!}
