<!-- User Id Field -->
<div class="form-group">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $salaryServiceAssigneds->user_id }}</p>
</div>

<!-- Service Id Field -->
<div class="form-group">
    {!! Form::label('service_id', 'Service Id:') !!}
    <p>{{ $salaryServiceAssigneds->service_id }}</p>
</div>

<!-- Type Salary Field -->
<div class="form-group">
    {!! Form::label('type_salary', 'Type Salary:') !!}
    <p>{{ $salaryServiceAssigneds->type_salary }}</p>
</div>

<!-- Salary Field -->
<div class="form-group">
    {!! Form::label('salary', 'Salary:') !!}
    <p>{{ $salaryServiceAssigneds->salary }}</p>
</div>

