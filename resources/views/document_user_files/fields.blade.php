<?php
    $isRequired = isset($typeDoc) && $typeDoc->expired == 1 ? true : false;
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
            {!! Form::text('date_expedition', null, ['class' => 'form-control','id'=>'date_expedition', 'required' => true]) !!}
        </div>
    </div>
    <div class="col" {{ $isRequired == true ? '' : 'hidden' }}>
        <!-- Date Expired Field -->
        <div class="form-group">
            {!! Form::label('date_expired', 'Date Expired:') !!}
            {!! Form::text('date_expired', null, ['class' => 'form-control','id'=>'date_expired', 'required' => $isRequired]) !!}
        </div>
    </div>
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


