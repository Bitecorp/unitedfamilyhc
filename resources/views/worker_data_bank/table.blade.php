<div class="table-responsive-sm">
    <table class="table table-striped" id="banks-table">
        <thead>
            <tr>
                <th>Bank</th>
                <th>Routing Number</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($banks as $bank)
            <tr>
                <td>{{ $bank->name_bank }}</td>
                <td>{{ $bank->routing_number }}</td>
                <td class="with-btn" nowrap>
                    {!! Form::open(['route' => ['banks.destroy', $bank->id], 'method' => 'delete']) !!}
                    <div>
                        <a href="{{ route('banks.show', [$bank->id]) }}" class='btn btn-sm btn-primary' ><i class="fa fa-eye"></i> Show </a>
                        <a href="{{ route('banks.edit', [$bank->id]) }}" class='btn btn-sm btn-warning'><i class="fa fa-edit"></i> Edit </a>
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