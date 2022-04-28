<div class="table-responsive-sm">
    <table class="table table-striped" id="maritalStatuses-table">
        <thead>
            <tr>
                <th>Name Marital Status</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($maritalStatuses as $maritalStatus)
            <tr>
                <td>{{ $maritalStatus->name_marital_status }}</td>
                <td class="with-btn" nowrap>
                    {!! Form::open(['route' => ['maritalStatuses.destroy', $maritalStatus->id], 'method' => 'delete']) !!}
                    <div>
                        <a href="{{ route('maritalStatuses.show', [$maritalStatus->id]) }}" class='btn btn-sm btn-success'><i class="fa fa-eye"></i> Show </a>
                        <a href="{{ route('maritalStatuses.edit', [$maritalStatus->id]) }}" class='btn btn-sm btn-info'><i class="fa fa-edit"></i> Edit </a>
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