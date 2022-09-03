@push('css')
	<link href="../assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
	<script src="../assets/plugins/select2/dist/js/select2.min.js"></script>
@endpush

<div class="row">
    <div class="col-2">
        <div class="form-group">
            {!! Form::label('num_prov', 'Provider Number:') !!}
            {!! Form::text('num_prov', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
        </div>
    </div>
    <div class="col">
        <!-- Name Service Field -->
        <div class="form-group">
            {!! Form::label('name_service', 'Name Service:') !!}
            {!! Form::text('name_service', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => true]) !!}
        </div>
    </div>
    <div class="col">
        <!-- Documents Field -->
        <div class="form-group">
            {!! Form::label('documents', 'Documents:') !!}
            <select name='documents[]' class="multiple-select2 form-control" size="3" multiple required>
                @if(empty($collection))
                    @foreach($docs as $doc)
                        <option value='{{ $doc->id }}'>{{ $doc->name_doc }}</option>
                    @endforeach
                @else
                    @foreach($docs as $doc)
                        @foreach($collection as $collect)
                            @if( $doc->id == $collect->id)
                                <option value='{{ $doc->id }}' selected>{{ $doc->name_doc }}</option>
                            @endif
                        @endforeach
                    @endforeach
                    @foreach($docDist as $distD)
                        <option value='{{ $distD->id }}'>{{ $distD->name_doc }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('services.index') }}" class="btn btn-secondary">Cancel</a>
</div>

@push('scripts')
    <script>
        $(".multiple-select2").select2({ placeholder: "Select option" });
    </script>
@endpush