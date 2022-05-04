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
                    <input type="file" name="file" class="custom-file-input" id="inputGroupFile" required>
                    <label class="custom-file-label" for="inputGroupFile">Choose file</label>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <!-- Role Id Field -->
        <div class="form-group">
            {!! Form::label('role_id', 'For:') !!}
            <select name='role_id' class="form-control">
                @foreach($roles as $role)
                    @if(empty($externalsDocuments))
                        <option value='{{ $role->id }}' {{ $role->id == '2' ? 'selected' : '' }} >{{ $role->name_role }}</option>
                    @else
                        <option value='{{ $role->id }}' {{ $externalsDocuments->role_id == $role->id ? 'selected' : '' }} >{{ $role->name_role }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="col">
        <!-- Service Id Field -->
        <div class="form-group">
            {!! Form::label('service_id', 'Service:') !!}
            <select name='service_id' class="form-control">
                @foreach($services as $service)
                    @if(empty($externalsDocuments))
                        <option value='{{ $service->id }}' {{ $service->id == '1' ? 'selected' : '' }} >{{ $service->name_service }}</option>
                    @else
                        <option value='{{ $service->id }}' {{ $externalsDocuments->service_id == $service->id ? 'selected' : '' }} >{{ $service->name_service }}</option>
                    @endif
                @endforeach
            </select>
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
    <a href="{{ route('externalsDocuments.index') }}" class="btn btn-secondary">Cancel</a>
</div>
