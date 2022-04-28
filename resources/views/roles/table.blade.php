<div class="table-responsive-sm">
    <table class="table table-striped" id="roles-table">
        <thead>
            <tr>
                <th>Role</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($roles as $role)
            <tr>
                <td>{{ $role->name_role }}</td>
                <td class="with-btn" nowrap>
                    {!! Form::open(['route' => ['roles.destroy', $role->id], 'method' => 'delete']) !!}
                    <div>
                        <a href="{{ route('roles.show', [$role->id]) }}" class='btn btn-sm btn-primary' ><i class="fa fa-eye"></i> Show </a>
                        <a href="{{ route('roles.edit', [$role->id]) }}" class='btn btn-sm btn-warning'><i class="fa fa-edit"></i> Edit </a>
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