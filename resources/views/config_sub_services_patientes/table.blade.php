<div class="table-responsive-sm">
    <table class="table table-striped" id="configSubServicesPatientes-table">
        <thead>
            <tr>
                <th>Salary Service Assigned Id</th>
        <th>Agent Id</th>
        <th>Code Patiente</th>
        <th>Approved Units</th>
        <th>Date Expedition</th>
        <th>Date Expired</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($configSubServicesPatientes as $configSubServicesPatiente)
            <tr>
                <td>{{ $configSubServicesPatiente->salary_service_assigned_id }}</td>
            <td>{{ $configSubServicesPatiente->agent_id }}</td>
            <td>{{ $configSubServicesPatiente->code_patiente }}</td>
            <td>{{ $configSubServicesPatiente->approved_units }}</td>
            <td>{{ $configSubServicesPatiente->date_expedition }}</td>
            <td>{{ $configSubServicesPatiente->date_expired }}</td>
                <td>
                    {!! Form::open(['route' => ['configSubServicesPatientes.destroy', $configSubServicesPatiente->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('configSubServicesPatientes.show', [$configSubServicesPatiente->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('configSubServicesPatientes.edit', [$configSubServicesPatiente->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>