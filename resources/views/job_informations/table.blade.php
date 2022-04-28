<div class="table-responsive-sm">
    <table class="table table-striped" id="jobInformations-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Supervisor</th>
                <th>Work Phone</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($jobInformations as $jobInformation)
            <tr>
                <td>{{ $jobInformation->title }}</td>
                <td>{{ $jobInformation->supervisor }}</td>
                <td>{{ $jobInformation->work_phone }}</td>
                <td class="with-btn" nowrap>
                    {!! Form::open(['route' => ['jobInformations.destroy', $jobInformation->id], 'method' => 'delete']) !!}
                    <div>
                        <a href="{{ route('jobInformations.show', [$jobInformation->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('jobInformations.edit', [$jobInformation->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>