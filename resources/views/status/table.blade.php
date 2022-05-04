<div class="table-responsive-sm">
    <table class="table table-striped" id="status-table">
        <thead>
            <tr>
                <th>Status</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($status as $estate)
            <tr>
                <td>{{ $estate->name_status }}</td>
                <td class="with-btn" nowrap>
                    {!! Form::open(['route' => ['status.destroy', $estate->id], 'method' => 'delete']) !!}
                    <div>
                        <a href="{{ route('status.show', [$estate->id]) }}" class='btn btn-sm btn-primary' ><i class="fa fa-eye"></i> Show </a>
                        <a href="{{ route('status.edit', [$estate->id]) }}" class='btn btn-sm btn-warning'><i class="fa fa-edit"></i> Edit </a>
                        @if(Auth::user()->role_id == 1)
                            {!! Form::button('<a><i class="fa fa-trash"></i> Delete </a>', ['type' => 'submit', 'class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                        @endif
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>