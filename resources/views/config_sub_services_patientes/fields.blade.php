<!-- Salary Service Assigned Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('salary_service_assigned_id', 'Salary Service Assigned Id:') !!}
    {!! Form::text('salary_service_assigned_id', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Agent Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('agent_id', 'Agent Id:') !!}
    {!! Form::text('agent_id', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Code Patiente Field -->
<div class="form-group col-sm-6">
    {!! Form::label('code_patiente', 'Code Patiente:') !!}
    {!! Form::text('code_patiente', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Approved Units Field -->
<div class="form-group col-sm-6">
    {!! Form::label('approved_units', 'Approved Units:') !!}
    {!! Form::text('approved_units', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Date Expedition Field -->
<div class="form-group col-sm-6">
    {!! Form::label('date_expedition', 'Date Expedition:') !!}
    {!! Form::text('date_expedition', null, ['class' => 'form-control','id'=>'date_expedition']) !!}
</div>

@push('scripts')
   <script type="text/javascript">
           $('#date_expedition').datetimepicker({
               format: 'YYYY-MM-DD HH:mm:ss',
               useCurrent: true,
               icons: {
                   up: "icon-arrow-up-circle icons font-2xl",
                   down: "icon-arrow-down-circle icons font-2xl"
               },
               sideBySide: true
           })
       </script>
@endpush


<!-- Date Expired Field -->
<div class="form-group col-sm-6">
    {!! Form::label('date_expired', 'Date Expired:') !!}
    {!! Form::text('date_expired', null, ['class' => 'form-control','id'=>'date_expired']) !!}
</div>

@push('scripts')
   <script type="text/javascript">
           $('#date_expired').datetimepicker({
               format: 'YYYY-MM-DD HH:mm:ss',
               useCurrent: true,
               icons: {
                   up: "icon-arrow-up-circle icons font-2xl",
                   down: "icon-arrow-down-circle icons font-2xl"
               },
               sideBySide: true
           })
       </script>
@endpush


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('configSubServicesPatientes.index') }}" class="btn btn-secondary">Cancel</a>
</div>
