<table id="patientsSinServicio" class="table table-striped table-bordered table-td-valign-middle">
    <thead>
        <tr>
            <th class="text-nowrap">Patient</th>
        </tr>
    </thead>
    <tbody>
        @foreach($patientsSinServicio as $key => $patientSinServicio)
            <tr data-id='{{ $key + 1 }}' id="data_{{ $key + 1 }}">
                <td>{{ $patientSinServicio->first_name }} {{ $patientSinServicio->last_name }}</td>
            </tr>   
        @endforeach
    </tbody>
</table>

@push('scripts')
    <script>
        $(function () {
            $('#patientsSinServicio').DataTable( {
                retrieve: true,
                paging: true,
                autoFill: true,
                searching: true
            });
        });
    </script>
@endpush