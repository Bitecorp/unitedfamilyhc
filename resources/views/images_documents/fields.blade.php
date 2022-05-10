<div class="row">
    <div class="col">
        <!-- High School Field -->
        <div class="form-group">
            {!! Form::label('title', 'Title File:') !!}
            {!! Form::text('title', null, ['class' => 'form-control','maxlength' => 255, 'required' => true]) !!}
        </div>
    </div>
    <div class="col">
        <!-- File Field -->
        <div class="form-group">
            {!! Form::label('file', 'File:') !!}
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">File:</span>
                </div>
                <div class="custom-file">
                    <input type="file" name="file" class="custom-file-input" id="inputGroupFile" {{ isset($imagesDocuments) && isset($imagesDocuments->file) ? '' : 'required' }}>
                    <label class="custom-file-label" for="inputGroupFile">{{ isset($imagesDocuments) && isset($imagesDocuments->file) ? $imagesDocuments->file : 'Choose file' }}</label>
                </div>
            </div>
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
    <a href="{{ route('imagesDocuments.index') }}" class="btn btn-secondary">Cancel</a>
</div>
