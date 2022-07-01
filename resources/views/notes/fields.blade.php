<div class="form-group" hidden>
    {!! Form::label('register_attentions_id', 'register_attentions_id:') !!}
    <input type="text" name="register_attentions_id" class="form-control" readonly value="{{ $note[0]['register_attentions_id'] }}" >
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
            {!! Form::textarea('note', $note[0]['note'], ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255, 'rows' => 5]) !!}
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            {!! Form::label('firma', 'Signature of the Guardian:') !!}
            {!! Form::textarea('firma', $note[0]['firma'], ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255, 'rows' => 5]) !!}
        </div>
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::button('<a>Save</a>', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
    <a href="{{ route('notesSubServices.index') }}" class="btn btn-secondary">Cancel</a>
</div>

<script>
function alerta(){
    var nota = $('#note').val();
    var firma = $('#firma').val();

    if(typeof nota != 'undefined' && nota != '' && nota != null && typeof firma != 'undefined' && firma != '' && firma != null){
        confirm("If you are sure, by saving you will not be able to edit the note again in the future.");
    }
}
</script>