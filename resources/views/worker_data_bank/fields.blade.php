<?php
    $link = "$_SERVER[REQUEST_URI]";
    $workerId = explode('/', $link)[2];
    $urlReturn = "/workers/" . $workerId . "?banks";
?>

<div class="form-group" hidden>
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::text('user_id', $workerId, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255, 'required' => true]) !!}
</div>
<div class="row">
    <div class="col">
        <div class="form-group">
            {!! Form::label('bank_id', 'Bank:') !!}
            <select name='bank_id' class="default-select2 form-control">
                @foreach($banks as $bank)
                    @if(empty($workerDataBank) && isset($workerDataBank->bank_id))
                        <option value='{{ $bank->id }}' {{$workerDataBank->bank_id == $bank->id ? 'selected' : ''}}>{{ $bank->name_bank }}</option>
                    @else
                        <option value='{{ $bank->id }}'>{{ $bank->name_bank }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            {!! Form::label('account', 'Account:') !!}
            {!! Form::text('account', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255, 'required' => true]) !!}
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            {!! Form::label('routing_number', 'Routing Number:') !!}
            {!! Form::text('routing_number', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255, 'required' => true]) !!}
        </div>
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href={{ $urlReturn }} class="btn btn-secondary">Cancel</a>
</div>
