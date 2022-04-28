<div class="table-responsive-sm">
    <table class="table table-striped" id="contactEmergencies-table">
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Home Phone</th>
                <th>Alternate Phone</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($contactEmergencies as $contactEmergency)
            <tr>
                <td>{{ $contactEmergency->first_name }} {{ $contactEmergency->last_name }}</td>
                <td>{{ $contactEmergency->home_phone }}</td>
                <td>{{ $contactEmergency->alternate_phone }}</td>
                <td class="with-btn" nowrap>
                    {!! Form::open(['route' => ['contactEmergencies.destroy', $contactEmergency->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('contactEmergencies.show', [$contactEmergency->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('contactEmergencies.edit', [$contactEmergency->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>