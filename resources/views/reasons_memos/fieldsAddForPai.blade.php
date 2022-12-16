<?php 

$urlAct = Request::fullUrl();
//dd(explode('/', $urlAct));

?>
<!-- Name Role Field -->
<div class="row">
    <div class="col">
        <div class="form-group">
            {!! Form::label('worker_id', 'Worker:') !!}
            {!! Form::text('worker_id', infoUser(intval(explode('/', $urlAct)[5]), 'fullName'), ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255, 'required' => true, 'readonly' => true]) !!}
        </div>
    </div>

    <div class="col">
        <!-- Name Role Field -->
        <div class="form-group">
            {!! Form::label('patiente_id', 'Patient:') !!}
            {!! Form::text('patiente_id', infoUser(intval(explode('/', $urlAct)[6]), 'fullName'), ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255, 'required' => true, 'readonly' => true]) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <!-- Name Role Field -->
        <div class="form-group">
            {!! Form::label('service_id', 'Service:') !!}
            {!! Form::text('service_id', infoService(intval(explode('/', $urlAct)[7]), 'name'), ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255, 'required' => true, 'readonly' => true]) !!}
        </div>
    </div>

    <div class="col">
        <!-- Name Role Field -->
        <div class="form-group">
            {!! Form::label('sub_service_id', 'Sub Service:') !!}
            {!! Form::text('sub_service_id', infoSubService(intval(explode('/', $urlAct)[8]), 'name'), ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255, 'required' => true, 'readonly' => true]) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <!-- Name Role Field -->
        <div class="form-group">
            {!! Form::label('desde', 'From:') !!}
            {!! Form::text('desde', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255, 'required' => true, 'readonly' => true]) !!}
        </div>
    </div>
    <div class="col">
        <!-- Name Role Field -->
        <div class="form-group">
            {!! Form::label('hasta', 'To:') !!}
            {!! Form::text('hasta', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255, 'required' => true, 'readonly' => true]) !!}
        </div>
    </div>
</div>

<div class="card mb-3 ml-1 mr-1 mt-1">
    <div class="card-header">
        <strong>Memos</strong>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    {!! Form::label('reason_id', 'Reason Memo:') !!}
                    <select name='reason_id' class="default-select2 form-control">
                        @foreach($reasonMemos as $reasonMemo)
                            <option value='{{ $reasonMemo->id }}'>{{ $reasonMemo->title_reason }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        
            <div class="col" hidden>
                <!-- Name Role Field -->
                <div class="form-group">
                    {!! Form::label('amount_base', 'Base Amount:') !!}
                    {!! Form::text('amount_base', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255, 'required' => true, 'readonly' => true]) !!}
                </div>
            </div>
        
            <div class="col">
                <!-- Name Role Field -->
                <div class="form-group">
                    {!! Form::label('mont_memo', 'Amount Memo:') !!}
                    {!! Form::text('mont_memo', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255, 'required' => true]) !!}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('reasonsMemos.index') }}" class="btn btn-secondary">Cancel</a>
</div>