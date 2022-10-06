<div class="table-responsive">
    <table class="table" id="connectionsExternals-table">
        <thead>
        <tr>
            <th>Name Connection</th>
            <th>Server Connection</th>
            <th>Port Connection</th>
            <th>User Connection</th>
            <th>Password Connection</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($connectionsExternals as $connectionsExternals)
            <tr>
                <td>{{ $connectionsExternals->name_connection }}</td>
            <td>{{ $connectionsExternals->server_connection }}</td>
            <td>{{ $connectionsExternals->port_connection }}</td>
            <td>{{ $connectionsExternals->user_connection }}</td>
            <td>{{ $connectionsExternals->password_connection }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['connectionsExternals.destroy', $connectionsExternals->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('connectionsExternals.show', [$connectionsExternals->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('connectionsExternals.edit', [$connectionsExternals->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
