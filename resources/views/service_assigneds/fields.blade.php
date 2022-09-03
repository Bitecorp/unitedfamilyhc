<?php
    $isDisable = false;
    if(Auth::user()->role_id === 2){
        $isDisable = true;
    }

?>

<div class="row">
    <div class="col">
        <!-- services Field -->
        <div class="form-group">
            {!! Form::label('services', 'Services:') !!}
            @if($serviceAssigneds == null)
                <select name='services[]' class="multiple-select2 form-control" size="3" multiple required>
                    @foreach($services as $service)
                        <option value='{{ $service->id }}'>{{ $service->name_service }}</option>
                    @endforeach
                </select>
            @else
                <select name='services[]' class="multiple-select2 form-control" size="3" multiple required>
                    @foreach($collection as $collect)
                        <option value='{{ $collect->id }}' selected >{{ $collect->name_service }}</option>
                    @endforeach
                    @foreach($servicesDist as $serviceDist)
                        <option value='{{ $serviceDist->id }}'>{{ $serviceDist->name_service }}</option>
                    @endforeach
                </select>
            @endif
        </div>
    </div>
</div>
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
</div>

@push('scripts')
    <script>
        $(".multiple-select2").select2({ placeholder: "Select option" });
    </script>
@endpush
