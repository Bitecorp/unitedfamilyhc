<?php
    $isRequired = isset($typeDoc) && intval($typeDoc->expired) == 1 ? 'true' : 'false';
    $link = "$_SERVER[REQUEST_URI]";
    $stringSeparado = explode('/', $link);
    $urlUser = $stringSeparado[1];
?>
<div class="row">
    <div class="col">
        <!-- File Field -->
        <div class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">File:</span>
                </div>
                <div class="custom-file">
                    <input type="file" name="file" class="custom-file-input" id="inputGroupFile" {{ isset($documentUserFiles) && isset($documentUserFiles->file) ? '' : 'required'}}>
                    <label class="custom-file-label" for="inputGroupFile">{{ isset($documentUserFiles) && isset($documentUserFiles->file) ? $documentUserFiles->file : 'Choose file' }}</label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <!-- Date Expedition Field -->
        <div class="form-group">
            {!! Form::label('date_expedition', 'Date Expedition:') !!}
            <input type="date" placeholder="YYYY-MM-DD" name="date_expedition" id="date_expedition" class="form-control" value="{{ isset($documentUserFiles) && !empty($documentUserFiles) && isset($documentUserFiles->date_expedition) && !empty($documentUserFiles->date_expedition) ? date_format($documentUserFiles->date_expedition, 'Y-m-d') : '' }}" required>
        </div>
    </div>
    <div class="col" {{ isset($typeDoc) && intval($typeDoc->expired) == 1 ? '' : 'hidden' }}>
        <!-- Date Expired Field -->
        <div class="form-group">
            {!! Form::label('date_expired', 'Date Expired:') !!}
            <input type="date" {{ isset($typeDoc) && intval($typeDoc->expired) == 1 ? 'required' : '' }} placeholder="YYYY-MM-DD" name="date_expired" id="date_expired" class="form-control" value="{{ isset($documentUserFiles) && !empty($documentUserFiles) && isset($documentUserFiles->date_expired) && !empty($documentUserFiles->date_expired) ? date_format($documentUserFiles->date_expired, 'Y-m-d') : '' }}">
        </div>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        $(function () {
            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
        });
    </script>
@endpush



<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route($user->role_id == 4 ? 'patientes.show' : 'workers.show', [$userID]) }}?documents" class="btn btn-secondary">Cancel</a>
</div>

