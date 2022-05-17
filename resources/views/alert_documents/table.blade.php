<table id="tableWorkersDocumentsExpired" class="table table-striped table-bordered table-td-valign-middle">
    <thead>
        <tr>
            <th width="1%"></th>
            <th class="text-nowrap">Full Name</th>
            <th class="text-nowrap">Home Phone</th>
            <th class="text-nowrap">Email</th>
            <th class="text-nowrap">Role</th>
            <th class="text-nowrap">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($workers as $key => $worker)
            <tr data-id='{{ $worker->id }}' id="data_{{ $key }}">
                <td width="1%" class="f-s-600 text-inverse">{{ $key + 1 }}</td>
                <td>{{ $worker->first_name }} {{ $worker->last_name }}</td>
                <td>{{ $worker->home_phone }}</td>
                <td>{{ $worker->email }}</td>
                @foreach($roles as $role)
                    @if($worker->role_id == $role->id)
                        <td>{{ $role->name_role }}</td>
                    @endif
                @endforeach 
                <td class="with-btn" nowrap>
                    @if($worker->id > 1 )
                        <a href="{{ route('workers.show', [$worker->id]) }}" class='btn btn-sm btn-primary' ><i class="fa fa-eye"></i> Show User </a>
                        <a href="{{ route('alertDocuments.sendEmail', [$worker->id]) }}" class='btn btn-sm btn-success' ><i class="fa fa-envelope"></i> Send Email </a>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@push('scripts')
    <script>
        function changeStatus(dato) {
            $('#Switch_' + dato).change(function() {
                $('#sendForm_' + dato).submit();
            })
        };
    </script>
    <script>
        $(function () {
            if ($('#tableWorkersDocumentsExpired').length !== 0) {
                var options = {
                    dom: '<"dataTables_wrapper dt-bootstrap"<"row"<"col-xl-7 d-block d-sm-flex d-xl-block justify-content-center"<"d-block d-lg-inline-flex mr-0 mr-sm-3"l><"d-block d-lg-inline-flex"B>><"col-xl-5 d-flex d-xl-block justify-content-center"fr>>t<"row"<"col-sm-5"i><"col-sm-7"p>>>',
                    buttons: [
                        { extend: 'copy', className: 'btn-sm' },
                        { extend: 'csv', className: 'btn-sm' },
                        { extend: 'excel', className: 'btn-sm' },
                        { extend: 'pdf', className: 'btn-sm' },
                        { extend: 'print', className: 'btn-sm' }
                    ],
                    responsive: true,retrieve: true,
                    autoFill: true,
                    colReorder: true,
                    keys: true,
                    rowReorder: true,
                    select: true
                };

                if ($(window).width() <= 767) {
                    options.rowReorder = false;
                    options.colReorder = false;
                    options.autoFill = false;
                }
                $('#tableWorkersDocumentsExpired').DataTable(options);
            }
        });
    </script>
@endpush