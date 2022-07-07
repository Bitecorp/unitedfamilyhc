<div class="form-group" hidden>
    {!! Form::label('register_attentions_id', 'register_attentions_id:') !!}
    <input type="text" name="register_attentions_id" class="form-control" readonly  value="{{ $note[0]['register_attentions_id'] }}" >
</div>

<div class="form-group" hidden>
    {!! Form::label('worker_id', 'worker_id:') !!}
    <input type="text" name="worker_id" class="form-control" readonly value="{{ $note[0]['worker_id']['id'] }}" >
</div>

<div class="form-group" hidden>
    {!! Form::label('patiente_id', 'patiente_id:') !!}
    <input type="text" name="patiente_id" class="form-control" readonly value="{{ $note[0]['patiente_id']['id'] }}" >
</div>

<div class="form-group" hidden>
    {!! Form::label('service_id', 'service_id:') !!}
    <input type="text" name="service_id" class="form-control" readonly value="{{ $note[0]['service_id']['id'] }}" >
</div>

<div class="form-group" hidden>
    {!! Form::label('sub_service_id', 'sub_service_id:') !!}
    <input type="text" name="sub_service_id" class="form-control" readonly value="{{ $note[0]['sub_service_id']['id'] }}" >
</div>

<div class="row">
    <div class="col">
        <div class="form-group">
            {!! Form::label('note', 'Post Attention Note:') !!}
            {!! Form::textarea('note', $note[0]['note'], ['class' => 'form-control', 'rows' => 20, 'readonly' => 'true']) !!}
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            {!! Form::label('firma', 'Signature of the Guardian:') !!}
            <div id='view' class="abs-center" >
                @if (isset($note[0]['firma']) && !empty($note[0]['firma']))
                    <img max-height="1000px" width="100%" src="{{ asset('filesUsers/' . $note[0]['firma']) }}">;
                @endif
            </div>
        </div>
    </div>
</div>

<div class="form-group col-sm-12">
    <a href="{{ route('notesSubServices.index') }}" class="btn btn-secondary">Back</a>
</div>