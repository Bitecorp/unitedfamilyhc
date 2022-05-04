<div class="table-responsive-sm">
    <table class="table table-striped" id="taskSubServices-table">
        <thead>
            <tr>
                <th>Name Task</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($taskSubServices as $taskSubServices)
            <tr>
                <td>{{ $taskSubServices->name_task }}</td>
                <td class="with-btn" nowrap>
                    {!! Form::open(['route' => ['taskSubServices.destroy', $taskSubServices->id], 'method' => 'delete']) !!}
                    <div>
                        <a href="{{ route('taskSubServices.show', [$taskSubServices->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('taskSubServices.edit', [$taskSubServices->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>