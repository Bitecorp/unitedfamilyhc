<table id="workersSinNotas" class="table table-striped table-bordered table-td-valign-middle">
    <thead>
        <tr>
            <th class="text-nowrap">Worker</th>
            <th class="text-nowrap">Patient</th>
        </tr>
    </thead>
    <tbody>
        @foreach($sinNotas as $key => $sinNota)
            <tr data-id='{{ $key + 1 }}' id="data_{{ $key + 1 }}">
                <td>{{ $sinNota['worker_id'] }}</td>
                <td>{{ $sinNota['patiente_id'] }}</td>
            </tr>   
        @endforeach
    </tbody>
</table>

@push('scripts')
    <script>
        $(function () {
            $('#workersSinNotas').DataTable( {
                retrieve: true,
                paging: true,
                autoFill: true,
                searching: true
            });
        });
    </script>
@endpush