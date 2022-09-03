<?php
    $options = [
        '3' => 'Agreements',
        '1' => 'Certificate',
        '0' => 'Document',
        '2' => 'Personal Documents',
        '4' => 'Others'
    ];

    $selected = isset($typeDoc) && isset($typeDoc->document_certificate) ? $typeDoc->document_certificate : 0;
?>

@push('css')
	<link href="../assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
	<script src="../assets/plugins/select2/dist/js/select2.min.js"></script>
@endpush

<div class="row">
    <div class="col">
        <!-- Name Doc Field -->
        <div class="form-group">
            {!! Form::label('name_doc', 'Name Document:') !!}
            {!! Form::text('name_doc', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => true]) !!}
        </div>
    </div>
    <div class="col">
        <!-- Mi Field -->
        <div class="form-group">
            {!! Form::label('document_certificate', 'Type:') !!}
            {!! Form::select('document_certificate', $options, $selected, ['class'=>'default-select2 form-control']) !!}
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <p>Expired:</p>
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="expired" name="expired" {{ isset($typeDoc) && $typeDoc->expired == 1 ? 'checked' : '' }}>
                <label class="custom-control-label" for="expired">Not Expired - Expired</label>
            </div>
        </div>
    </div>
    <div class="col">
        <!-- Role Id Field -->
        <div class="form-group">
            {!! Form::label('role_id', 'For:') !!}
            <select name='role_id' class="default-select2 form-control">
                @foreach($roles as $role)
                    @if(!empty($role))
                        <option value='{{ $role->id }}' {{ isset($typeDoc) && isset($typeDoc->role_id) && $typeDoc->role_id == $role->id ? 'selected' : (isset($role) && isset($role->id) && $role->id == 1 ? 'selected' : '') }} >{{ $role->name_role }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="col">
        <!-- Service Id Field -->
        <div class="form-group">
            {!! Form::label('service_id', 'Service:') !!}
            <select name='service_id' class="default-select2 form-control">
                <option value='0' {{ isset($typeDoc) && isset($typeDoc->service_id) && $typeDoc->service_id == 0 ? 'selected' : '' }} >ALL</option>
                @foreach($services as $service)
                    @if(!empty($service))
                        <option value='{{ $service->id }}' {{ isset($typeDoc) && isset($typeDoc->service_id) && $typeDoc->service_id == $service->id ? 'selected' : '' }} >{{ $service->name_service }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('typeDocs.index') }}" class="btn btn-secondary">Cancel</a>
</div>

@push('scripts')
    <script>
        $(".default-select2").select2();
    </script>
@endpush