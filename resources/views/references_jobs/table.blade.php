<div class="table-responsive-sm">
    <table class="table table-striped" id="referencesJobs-table">
        <thead>
            <tr>
                <th>User Id</th>
        <th>Name And Address</th>
        <th>Position</th>
        <th>Supervisor</th>
        <th>Phone Supervisor</th>
        <th>Dates Employed</th>
        <th>To Dates Employed</th>
        <th>Reason Leaving</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($referencesJobs as $referencesJobs)
            <tr>
                <td>{{ $referencesJobs->user_id }}</td>
            <td>{{ $referencesJobs->name_and_address }}</td>
            <td>{{ $referencesJobs->position }}</td>
            <td>{{ $referencesJobs->supervisor }}</td>
            <td>{{ $referencesJobs->phone_supervisor }}</td>
            <td>{{ $referencesJobs->dates_employed }}</td>
            <td>{{ $referencesJobs->to_dates_employed }}</td>
            <td>{{ $referencesJobs->reason_leaving }}</td>
                <td>
                    {!! Form::open(['route' => ['referencesJobs.destroy', $referencesJobs->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('referencesJobs.show', [$referencesJobs->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('referencesJobs.edit', [$referencesJobs->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>