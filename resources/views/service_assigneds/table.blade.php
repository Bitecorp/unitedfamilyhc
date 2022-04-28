<div class="table-responsive-sm">
    <table class="table table-striped" id="serviceAssigneds-table">
        <thead>
            <tr>
                <th>User Id</th>
                <th>Services</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($collections as $serviceAssigneds)
            <tr>
                <td>{{ $serviceAssigneds->user_id }}</td>
                <td>{{ $serviceAssigneds->services }}</td>
                <td>
                    {!! Form::open(['route' => ['serviceAssigneds.destroy', $serviceAssigneds->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('serviceAssigneds.show', [$serviceAssigneds->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('serviceAssigneds.edit', [$serviceAssigneds->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>