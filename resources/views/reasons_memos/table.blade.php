<div class="table-responsive-sm">
    <table class="table table-striped" id="reasonMemos-table">
        <thead>
            <tr>
                <th>Reason Memo</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($reasonMemos as $reasonMemo)
            <tr>
                <td>{{ $reasonMemo->name_reasonMemo }}</td>
                <td class="with-btn" nowrap>
                    {!! Form::open(['route' => ['reasonsMemos.destroy', $reasonMemo->id], 'method' => 'delete']) !!}
                    <div>
                        <a href="{{ route('reasonsMemos.show', [$reasonMemo->id]) }}" class='btn btn-sm btn-primary' ><i class="fa fa-eye"></i> Show </a>
                        <a href="{{ route('reasonsMemos.edit', [$reasonMemo->id]) }}" class='btn btn-sm btn-warning'><i class="fa fa-edit"></i> Edit </a>
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