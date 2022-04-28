<div class="table-responsive-sm">
    <table class="table table-striped" id="referencesJobsTwos-table">
        <thead>
            <tr>
                <th>User Id</th>
        <th>Reference Number</th>
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
        @foreach($referencesJobsTwos as $referencesJobsTwo)
            <tr>
                <td>{{ $referencesJobsTwo->user_id }}</td>
            <td>{{ $referencesJobsTwo->reference_number }}</td>
            <td>{{ $referencesJobsTwo->name_and_address }}</td>
            <td>{{ $referencesJobsTwo->position }}</td>
            <td>{{ $referencesJobsTwo->supervisor }}</td>
            <td>{{ $referencesJobsTwo->phone_supervisor }}</td>
            <td>{{ $referencesJobsTwo->dates_employed }}</td>
            <td>{{ $referencesJobsTwo->to_dates_employed }}</td>
            <td>{{ $referencesJobsTwo->reason_leaving }}</td>
                <td>
                    {!! Form::open(['route' => ['referencesJobsTwos.destroy', $referencesJobsTwo->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('referencesJobsTwos.show', [$referencesJobsTwo->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('referencesJobsTwos.edit', [$referencesJobsTwo->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>