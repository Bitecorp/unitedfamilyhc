<div class="table-responsive-sm">
    <table class="table table-striped" id="referencesPersonalesTwos-table">
        <thead>
            <tr>
                <th>User Id</th>
        <th>Reference Number</th>
        <th>Name Job</th>
        <th>Address</th>
        <th>Phone</th>
        <th>Ocupation</th>
        <th>Time</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($referencesPersonalesTwos as $referencesPersonalesTwo)
            <tr>
                <td>{{ $referencesPersonalesTwo->user_id }}</td>
            <td>{{ $referencesPersonalesTwo->reference_number }}</td>
            <td>{{ $referencesPersonalesTwo->name_job }}</td>
            <td>{{ $referencesPersonalesTwo->address }}</td>
            <td>{{ $referencesPersonalesTwo->phone }}</td>
            <td>{{ $referencesPersonalesTwo->ocupation }}</td>
            <td>{{ $referencesPersonalesTwo->time }}</td>
                <td>
                    {!! Form::open(['route' => ['referencesPersonalesTwos.destroy', $referencesPersonalesTwo->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('referencesPersonalesTwos.show', [$referencesPersonalesTwo->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('referencesPersonalesTwos.edit', [$referencesPersonalesTwo->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>