<!-- Name Connection Field -->
<div class="col-sm-12">
    {!! Form::label('name_connection', 'Name Connection:') !!}
    <p>{{ $connectionsExternals->name_connection }}</p>
</div>

<!-- Server Connection Field -->
<div class="col-sm-12">
    {!! Form::label('server_connection', 'Server Connection:') !!}
    <p>{{ $connectionsExternals->server_connection }}</p>
</div>

<!-- Port Connection Field -->
<div class="col-sm-12">
    {!! Form::label('port_connection', 'Port Connection:') !!}
    <p>{{ $connectionsExternals->port_connection }}</p>
</div>

<!-- User Connection Field -->
<div class="col-sm-12">
    {!! Form::label('user_connection', 'User Connection:') !!}
    <p>{{ $connectionsExternals->user_connection }}</p>
</div>

<!-- Password Connection Field -->
<div class="col-sm-12">
    {!! Form::label('password_connection', 'Password Connection:') !!}
    <p>{{ $connectionsExternals->password_connection }}</p>
</div>

