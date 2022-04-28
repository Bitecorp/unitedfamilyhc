<div class="row">
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
            @if(empty($collection))
                <select class="js-example-basic-multiple custom-select" name='documents[]' multiple="multiple" required>
                     @foreach($docs as $doc)
                       <option value='{{ $doc->id }}'>{{ $doc->name_doc }}</option>
                    @endforeach
                </select>
            @else
                <select class="js-example-basic-multiple custom-select" name='documents[]' multiple="multiple" required>
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
                </select>
            @endif
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(function() {
            $(document).ready(function() {
                $('.js-example-basic-multiple').select2();
            });
        });
    </script>
@endpush

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('services.index') }}" class="btn btn-secondary">Cancel</a>
</div>
