<!-- Service Id Field -->
<div class="form-group">
    {!! Form::label('service_id', 'Service Id:') !!}
    <p>{{ $subServices->service_id }}</p>
</div>

<!-- Name Sub Service Field -->
<div class="form-group">
    {!! Form::label('name_sub_service', 'Name Sub Service:') !!}
    <p>{{ $subServices->name_sub_service }}</p>
</div>

<!-- Price Sub Service Field -->
<div class="form-group">
    {!! Form::label('price_sub_service', 'Price Sub Service:') !!}
    <p>{{ $subServices->price_sub_service }}</p>
</div>

<!-- Config Validate Field -->
<div class="form-group">
    {!! Form::label('config_validate', 'Config Validate:') !!}
    <p>{{ $subServices->config_validate }}</p>
</div>

