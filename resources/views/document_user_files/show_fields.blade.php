<!-- User Id Field -->
<div class="form-group">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $documentUserFiles->user_id }}</p>
</div>

<!-- Document Id Field -->
<div class="form-group">
    {!! Form::label('document_id', 'Document Id:') !!}
    <p>{{ $documentUserFiles->document_id }}</p>
</div>

<!-- Date Expedition Field -->
<div class="form-group">
    {!! Form::label('date_expedition', 'Date Expedition:') !!}
    <p>{{ $documentUserFiles->date_expedition }}</p>
</div>

<!-- Date Expired Field -->
<div class="form-group">
    {!! Form::label('date_expired', 'Date Expired:') !!}
    <p>{{ $documentUserFiles->date_expired }}</p>
</div>

<!-- File Field -->
<div class="form-group">
    {!! Form::label('file', 'File:') !!}
    <p>{{ $documentUserFiles->file }}</p>
</div>

