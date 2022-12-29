
<!-- Name Role Field -->
<div class="row">
    <div class="col">
        <div class="form-group">
            {!! Form::label('worker', 'Worker:') !!}
            {!! Form::text('worker', infoUser(intval(explode('/', $urlAct)[5]), 'fullName'), ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255, 'required' => true, 'readonly' => true]) !!}
        </div>
    </div>

    <div class="col">
        <!-- Name Role Field -->
        <div class="form-group">
            {!! Form::label('patiente', 'Patient:') !!}
            {!! Form::text('patiente', infoUser(intval(explode('/', $urlAct)[6]), 'fullName'), ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255, 'required' => true, 'readonly' => true]) !!}
        </div>
    </div>
</div>

<div class="row" hidden>
    <div class="col">
        <div class="form-group">
            {!! Form::text('worker_id', intval(explode('/', $urlAct)[5]), ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255, 'required' => true, 'readonly' => true]) !!}
        </div>
    </div>

    <div class="col">
        <!-- Name Role Field -->
        <div class="form-group">
            {!! Form::text('patiente_id', intval(explode('/', $urlAct)[6]), ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255, 'required' => true, 'readonly' => true]) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <!-- Name Role Field -->
        <div class="form-group">
            {!! Form::label('service', 'Service:') !!}
            {!! Form::text('service', infoService(intval(explode('/', $urlAct)[7]), 'name'), ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255, 'required' => true, 'readonly' => true]) !!}
        </div>
    </div>

    <div class="col">
        <!-- Name Role Field -->
        <div class="form-group">
            {!! Form::label('sub_service', 'Sub Service:') !!}
            {!! Form::text('sub_service', infoSubService(intval(explode('/', $urlAct)[8]), 'name'), ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255, 'required' => true, 'readonly' => true]) !!}
        </div>
    </div>
</div>

<div class="row" hidden>
    <div class="col">
        <!-- Name Role Field -->
        <div class="form-group">
            {!! Form::text('service_id', intval(explode('/', $urlAct)[7]), ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255, 'required' => true, 'readonly' => true]) !!}
        </div>
    </div>

    <div class="col">
        <!-- Name Role Field -->
        <div class="form-group">
            {!! Form::text('sub_service_id', intval(explode('/', $urlAct)[8]), ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255, 'required' => true, 'readonly' => true]) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <!-- Name Role Field -->
        <div class="form-group">
            {!! Form::label('desde', 'From:') !!}
            <input type="text" id="desde" name="desde" class="form-control" readonly value="" >
        </div>
    </div>
    <div class="col">
        <!-- Name Role Field -->
        <div class="form-group">
            {!! Form::label('hasta', 'To:') !!}
            <input type="text" id="hasta" name="hasta" class="form-control" readonly value="" >
        </div>
    </div>
    <div class="col">
        <!-- Name Role Field -->
        <div class="form-group">
            {!! Form::label('amount_base', 'Base Amount:') !!}
            <input type="text" id="amount_base" name="amount_base" class="form-control" readonly value="" >
        </div>
    </div>
</div>

<div class="row" hidden>
    <div class="col">
        <!-- Name Role Field -->
        <div class="form-group">
            <input type="text" id="from" name="from" class="form-control" readonly value="" >
        </div>
    </div>
    <div class="col">
        <!-- Name Role Field -->
        <div class="form-group">
            <input type="text" id="to" name="to" class="form-control" readonly value="" >
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
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    {!! Form::label('mont_memo', 'Amount Memo:') !!}
                </div>
            </div>
        </div>
        @if (isset($resonMemosForPai))
            <?php
                $monts = explode('"', $resonMemosForPai->monts_memo);
                $arrayMonts = [];
                for($i = 1; $i < count($monts); $i+=2){
                    array_push($arrayMonts, intval($monts[$i]));
                }

                $reasons = explode('"', $resonMemosForPai->reasons_id);
                $arrayReasons = [];
                for($i = 1; $i < count($reasons); $i+=2){
                    array_push($arrayReasons, intval($reasons[$i]));
                }
            ?>
        @endif

        <div class="field_wrapper">
            @if (isset($resonMemosForPai))
                <div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <select name="reason_id[]" id="reason_id[]" class="default-select2 form-control">
                                    @foreach($reasonMemos as $reasonMemo)
                                        <option value="{{ $reasonMemo->id }}" {{ intval($arrayReasons[0]) == intval($reasonMemo->id) ? 'selected' : '' }}>{{ $reasonMemo->title_reason }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <input type="text" id="mont_meno[]" name="mont_memo[]" class="form-control" value="{{ $arrayMonts[0] ? $arrayMonts[0] : '' }}" required/>
                            </div>
                        </div>
                        <a href="javascript:void(0);" class="add_button btn btn-xs btn-icon btn-circle btn-primary mt-2" title="Add Memo"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
            @elseif (!isset($resonMemosForPai))
                <div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <select name="reason_id[]" id="reason_id[]" class="default-select2 form-control">
                                    @foreach($reasonMemos as $reasonMemo)
                                        <option value='{{ $reasonMemo->id }}'>{{ $reasonMemo->title_reason }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <input type="text" id="mont_meno[]" name="mont_memo[]" class="form-control" value="" required/>
                            </div>
                        </div>
                        <a href="javascript:void(0);" class="add_button btn btn-xs btn-icon btn-circle btn-primary mt-2" title="Add Memo"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
            @endif          
            
            @if (isset($resonMemosForPai))
                @for ($i = 1; $i < count($arrayReasons); $i++)                    
                    <div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <select name="reason_id[]" id="reason_id[]" class="default-select2 form-control">
                                        @foreach($reasonMemos as $reasonMemo)
                                            <option value="{{ $reasonMemo->id }}" {{ intval($arrayReasons[$i]) == intval($reasonMemo->id) ? 'selected' : '' }}>{{ $reasonMemo->title_reason }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <input type="text" id="mont_meno[]" name="mont_memo[]" class="form-control" value="{{ $arrayMonts[$i] ? $arrayMonts[$i] : '' }}" required/>
                                </div>
                            </div>
                            <a href="javascript:void(0);" class="remove_button btn btn-xs btn-icon btn-circle btn-danger mt-2" title="Remove Memo"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                @endfor
            @endif
        </div>
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <button id="btn_back" type="button" class="btn btn-secondary">Back</button>
</div>

@push('scripts')
    <script type="text/javascript">
        let p = document.getElementById("btn_back"); // Encuentra el elemento "p" en el sitio
        p.onclick = muestraAlerta; // Agrega función onclick al elemento
                
        function muestraAlerta(evento) {
            window.history.back();
        }

        $(document).ready(function () {
            var desde = localStorage.getItem('dateDesde');  
            var hasta = localStorage.getItem('dateHasta');  
            var amountBase = (localStorage.getItem('amountBase') - 0.01).toFixed(2);

            document.getElementById('from').value = desde + ' 00:00:01';
            document.getElementById('to').value = hasta + ' 23:59:59';

            document.getElementById('desde').value = new Date(desde + ' 00:00:01').toLocaleDateString();
            document.getElementById('hasta').value = new Date(hasta + ' 23:59:59').toLocaleDateString();
            document.getElementById('amount_base').value = amountBase;
        });

    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.field_wrapper'); //Input field wrapper
            var fieldHTML = 
                '<div>\n'+
                    '<div class="row">\n'+
                        '<div class="col">\n'+
                            '<div class="form-group">\n'+
                                '<select name="reason_id[]" id="reason_id[]" class="default-select2 form-control">\n'+
                                    '@foreach($reasonMemos as $reasonMemo)\n'+
                                        '<option value="{{ $reasonMemo->id }}">{{ $reasonMemo->title_reason }}</option>\n'+
                                    '@endforeach\n'+
                                '</select>\n'+
                            '</div>\n'+
                        '</div>\n'+


                        '<div class="col">\n'+
                            '<div class="form-group">\n'+
                                '<input type="text" id="mont_memo[]" name="mont_memo[]" class="form-control" value="" required/>\n'+
                            '</div>\n'+
                        '</div>\n'+
                        '<a href="javascript:void(0);" class="remove_button btn btn-xs btn-icon btn-circle btn-danger mt-2" title="Remove Memo"><i class="fa fa-minus"></i></a>\n'+
                    '</div>\n'+
                '</div>\n';

            var x = 1; //Initial field counter is 1
            $(addButton).click(function(){ //Once add button is clicked
                if(x < maxField){ //Check maximum number of input fields
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML); // Add field html
                }
            });
            $(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });
    </script>
@endpush