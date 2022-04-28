<div class="table-responsive-sm">
    <table class="table table-striped" id="companies-table">
        <thead>
            <tr>
                <th>Name</th>
        <th>Street Addres</th>
        <th>Apartment Unit</th>
        <th>City</th>
        <th>State</th>
        <th>Zip Code</th>
        <th>Home Phone</th>
        <th>Alternate Phone</th>
        <th>Ssn</th>
        <th>Email</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($companies as $companies)
            <tr>
                <td>{{ $companies->name }}</td>
            <td>{{ $companies->street_addres }}</td>
            <td>{{ $companies->apartment_unit }}</td>
            <td>{{ $companies->city }}</td>
            <td>{{ $companies->state }}</td>
            <td>{{ $companies->zip_code }}</td>
            <td>{{ $companies->home_phone }}</td>
            <td>{{ $companies->alternate_phone }}</td>
            <td>{{ $companies->ssn }}</td>
            <td>{{ $companies->email }}</td>
                <td>
                    {!! Form::open(['route' => ['companies.destroy', $companies->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('companies.show', [$companies->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('companies.edit', [$companies->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>