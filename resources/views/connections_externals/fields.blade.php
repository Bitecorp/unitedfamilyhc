<!-- Name Connection Field -->
<div class="form-group">
    {!! Form::label('name_connection', 'Name Connection:') !!}
    {!! Form::text('name_connection', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<div class="row">
    <div class="col">
        <!-- Server Connection Field -->
        <div class="form-group">
            {!! Form::label('server_connection', 'Server Connection:') !!}
            {!! Form::text('server_connection', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
        </div>
    </div>

    <div class="col">
        <!-- Port Connection Field -->
        <div class="form-group">
            {!! Form::label('port_connection', 'Port Connection:') !!}
            {!! Form::text('port_connection', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
        </div>
    </div>

    <div class="col">
        <!-- User Connection Field -->
        <div class="form-group">
            {!! Form::label('user_connection', 'User Connection:') !!}
            {!! Form::text('user_connection', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
        </div>
    </div>

    <div class="col">
        <!-- Password Connection Field -->
        <div class="form-group">
            {!! Form::label('password_connection', 'Password Connection:') !!}
            {!! Form::text('password_connection', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('connectionsExternals.index') }}" class="btn btn-secondary">Cancel</a>
</div>