<table id="tableDocumentsExpired" class="table table-striped table-bordered table-td-valign-middle">
    <thead>
        <tr>
            <th class="text-nowrap">Full Name</th>
            <th class="text-nowrap">Home Phone</th>
            <th class="text-nowrap" {{ isset($stringSeparado) && !empty($stringSeparado) && $stringSeparado == 'patientes' ? 'hidden' : ''}}>Email</th>
            <th class="text-nowrap" {{ isset($stringSeparado) && !empty($stringSeparado) && $stringSeparado == 'patientes' ? 'hidden' : ''}}>Role</th>
            <th class="text-nowrap">Number of expired</th>
            <th class="text-nowrap">Action</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($stringSeparado) && !empty($stringSeparado) && $stringSeparado == 'workers')
            @foreach($workers as $key => $worker)
                @if (($worker->role_id == 2 || $worker->role_id == 3) && $worker->countExpired > 0)
                    <tr data-id='{{ $worker->id }}' id="data_{{ $worker->id }}">
                        <td>{{ $worker->first_name }} {{ $worker->last_name }}</td>
                        <td>{{ $worker->home_phone }}</td>
                        <td>{{ $worker->email }}</td>
                        @foreach($roles as $role)
                            @if($worker->role_id == $role->id)
                                <td>{{ $role->name_role }}</td>
                            @endif
                        @endforeach 
                        <td>{{ $worker->countExpired }}</td>
                        <td class="with-btn" nowrap>
                            @if($worker->id > 1 )
                                <a href="{{ route('workers.show', [$worker->id]) }}" class='btn btn-sm btn-primary' ><i class="fa fa-eye"></i> Show User </a>
                                <a href="{{ route('alertDocuments.sendEmail', [$worker->id]) }}" class='btn btn-sm btn-success' ><i class="fa fa-envelope"></i> Send Email </a>
                            @endif
                        </td>
                    </tr>
                @endif
            @endforeach
        @endif

        @if (isset($stringSeparado) && !empty($stringSeparado) && $stringSeparado == 'patientes')
            @foreach($workers as $key => $worker)
                @if ($worker->role_id == 4 && $worker->countExpired > 0)
                    <tr data-id='{{ $worker->id }}' id="data_{{ $worker->id }}">
                        <td>{{ $worker->first_name }} {{ $worker->last_name }}</td>
                        <td>{{ $worker->home_phone }}</td>
                        <td>{{ $worker->countExpired }}</td>
                        <td {{ isset($stringSeparado) && !empty($stringSeparado) && $stringSeparado == 'patientes' ? 'hidden' : ''}}>{{ $worker->email }}</td>
                        @foreach($roles as $role)
                            @if($worker->role_id == $role->id)
                                <td {{ isset($stringSeparado) && !empty($stringSeparado) && $stringSeparado == 'patientes' ? 'hidden' : ''}}>{{ $role->name_role }}</td>
                            @endif
                        @endforeach 
                        <td class="with-btn" nowrap>
                            @if($worker->id > 1 )
                                <a href="{{ route('patientes.show', [$worker->id]) }}" class='btn btn-sm btn-primary' ><i class="fa fa-eye"></i> Show User </a>
                                <!-- <a href="{{ route('alertDocuments.sendEmail', [$worker->id]) }}" class='btn btn-sm btn-success' ><i class="fa fa-envelope"></i> Send Email </a> -->
                            @endif
                        </td>
                    </tr>
                @endif
            @endforeach
        @endif
    </tbody>
</table>

@push('scripts')
    <script>
        $(function () {
            $('#tableDocumentsExpired').DataTable( {
                retrieve: true,
                paging: true,
                autoFill: true,
                searching: true
            });
        });
    </script>
@endpush