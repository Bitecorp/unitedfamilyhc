@push('css')
    <style type="text/css">
        .abs-center {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .enmarcada{
            /* border:5px solid #000; ancho - tipo - color */
            padding:0px; /* distancia entre la img y el borde */
            margin:5px; /* distancia entre el borde y el contenido */
            width:50px; /* el ancho de la img */
            height:36px; /* el ancho de la img */
        }
    </style>
@endpush
<div class="row">
    <div class="col">
        <!-- Name Task Field -->
        <div class="form-group col">
            {!! Form::label('new_password', 'New Password:') !!}
            {!! Form::text('new_password', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
        </div>
    </div>

    <div class="col">
        <!-- Name Task Field -->
        <div class="form-group col">
            {!! Form::label('confirm_password', 'Confirm New Password:') !!}
            {!! Form::text('confirm_password', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <!-- Name Task Field -->
        <div class="form-group col">
            {!! Form::label('avatar', 'Avatar:') !!}
            @if(isset($dataUser) && isset($dataUser->avatar) && !empty($dataUser->avatar))
                <div id="avatar_new">
                    <img src="{{ asset('imgUsers/' . $dataUser->avatar) }}" alt="Su texto alternativo"/>
                </div>
            @else
                <div id="avatar_old">
                    <i class="fa fa-user"></i>
                </div>
            @endif
        </div>
    </div>

    <div class="col">
        <!-- File Field -->
        <div class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">New Avatar:</span>
                </div>
                <div class="custom-file">
                    <input type="file" name="avatar" class="custom-file-input" id="avatar">
                    <label class="custom-file-label" for="avatar">{{ isset($dataUser) && isset($dataUser->avatar) && !empty($dataUser->avatar) ? $dataUser->avatar : 'Choose file' }}</label>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <div class="row">
    <div class="col">
        <div class="form-group col">
            {!! Form::label('avatar', 'Background Avatar:') !!}
            @if(isset($dataUser) && isset($dataUser->avatar) && !empty($dataUser->avatar))
                <div id="avatar_old">
                    {{ asset('imgUsers/' . $dataUser->avatar) }}
                </div>
            @else
                <div id="avatar_old">
                    <i class="fa fa-user"></i>
                </div>
            @endif

        </div>
    </div>

    <div class="col">
        <div class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">New Background Avatar:</span>
                </div>
                <div class="custom-file">
                    <input type="file" name="bg_avatar" class="custom-file-input" id="bg_avatar" {{ isset($dataUser) && isset($dataUser->bg_avatar) ? '' : 'required'}}>
                    <label class="custom-file-label" for="bg_avatar">{{ isset($dataUser) && isset($dataUser->bg_avatar) ? $dataUser->bg_avatar : 'Choose file' }}</label>
                </div>
            </div>
        </div>
    </div>
</div>-->

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('taskSubServices.index') }}" class="btn btn-secondary">Cancel</a>
</div>