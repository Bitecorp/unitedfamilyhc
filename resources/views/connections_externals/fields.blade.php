<!-- Name Connection Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name_connection', 'Name Connection:') !!}
    {!! Form::text('name_connection', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Server Connection Field -->
<div class="form-group col-sm-6">
    {!! Form::label('server_connection', 'Server Connection:') !!}
    {!! Form::text('server_connection', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Port Connection Field -->
<div class="form-group col-sm-6">
    {!! Form::label('port_connection', 'Port Connection:') !!}
    {!! Form::text('port_connection', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- User Connection Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_connection', 'User Connection:') !!}
    {!! Form::text('user_connection', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Password Connection Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password_connection', 'Password Connection:') !!}
    {!! Form::text('password_connection', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('connectionsExternals.index') }}" class="btn btn-secondary">Cancel</a>
</div>