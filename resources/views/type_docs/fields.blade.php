<?php
    $options = [
        '0' => 'Document',
        '1' => 'Certificate'
    ];

    $selected = isset($typeDoc) && isset($typeDoc->document_certificate) ? $typeDoc->document_certificate : 0;
?>

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
            {!! Form::select('document_certificate', $options, $selected, ['class'=>'form-control']) !!}
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
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('typeDocs.index') }}" class="btn btn-secondary">Cancel</a>
</div>
