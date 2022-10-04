<table id="tablePatienes" class="table table-striped table-bordered table-td-valign-middle">
    <thead>
        <tr>
            <th class="text-nowrap">Full Name</th>
            <th class="text-nowrap">Home Phone</th>
            <th class="text-nowrap">Role</th>
            <th class="text-nowrap">Status</th>
            <th class="text-nowrap">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($patientes['PA'] as $key => $patiente)
            <tr data-id='{{ $patiente->id }}' id="data_{{ $patiente->id }}">
                <td>{{ $patiente->first_name }} {{ $patiente->last_name }}</td>
                <td>{{ $patiente->home_phone }}</td>
                @foreach($roles as $role)
                    @if($patiente->role_id == $role->id)
                        <td>{{ $role->name_role }}</td>
                    @endif
                @endforeach
                @foreach($status as $statu)
                    @if($patiente->statu_id == $statu->id)
                        @if($patiente->id <= 3)
                            <td>{{ $statu->name_status }}</td>
                        @elseif($patiente->id > 3)
                            <td>
                                {!! Form::model($patiente, ['route' => ['patientes.updateState', $patiente->id], 'method' => 'post', 'id' => "sendForm_$patiente->id"]) !!}
                                <!-- begin custom-switches -->
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" onclick="changeStatus('{{$patiente->id}}');"  class="custom-control-input" data-id="{{ $patiente->id }}" name="{{$patiente->id}}" id="Switch_{{$patiente->id}}" {{ $patiente->statu_id == 1 ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="Switch_{{$patiente->id}}"></label>
                                    </div>
                                <!-- end custom-switches -->
                                {!! Form::close() !!}
                            </td>
                        @endif
                    @endif
                @endforeach
                <td class="with-btn" nowrap>
                    @if($patiente->id > 3 )
                        {!! Form::open(['route' => ['patientes.destroy', $patiente->id], 'method' => 'delete']) !!}
                            <a href="{{ route('patientes.show', [$patiente->id]) }}" class='btn btn-sm btn-primary' ><i class="fa fa-eye"></i> Show </a>
                            @if(Auth::user()->role_id == 1)
                                {!! Form::button('<a><i class="fa fa-trash"></i> Delete </a>', ['type' => 'submit', 'class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('You are about to delete a root record, if the information is not saved all documents attached to this worker will be lost. (Valid Documents and Expired Documents, Signed Contracts, Etc.).')"]) !!}
                            @endif
                        {!! Form::close() !!}
                    @endif
                </td>
            </tr>
        @endforeach

        @foreach($patientes['PI'] as $key => $patienteI)
            <tr data-id='{{ $patienteI->id }}' id="data_{{ $patienteI->id }}">
                <td>{{ $patienteI->first_name }} {{ $patienteI->last_name }}</td>
                <td>{{ $patienteI->home_phone }}</td>
                @foreach($roles as $role)
                    @if($patienteI->role_id == $role->id)
                        <td>{{ $role->name_role }}</td>
                    @endif
                @endforeach
                @foreach($status as $statu)
                    @if($patienteI->statu_id == $statu->id)
                        @if($patienteI->id <= 3)
                            <td>{{ $statu->name_status }}</td>
                        @elseif($patienteI->id > 3)
                            <td>
                                {!! Form::model($patienteI, ['route' => ['patientes.updateState', $patienteI->id], 'method' => 'post', 'id' => "sendForm_$patienteI->id"]) !!}
                                <!-- begin custom-switches -->
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" onclick="changeStatus('{{$patienteI->id}}');"  class="custom-control-input" data-id="{{ $patienteI->id }}" name="{{$patienteI->id}}" id="Switch_{{$patienteI->id}}" {{ $patienteI->statu_id == 1 ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="Switch_{{$patienteI->id}}"></label>
                                    </div>
                                <!-- end custom-switches -->
                                {!! Form::close() !!}
                            </td>
                        @endif
                    @endif
                @endforeach
                <td class="with-btn" nowrap>
                    @if($patienteI->id > 3 )
                        {!! Form::open(['route' => ['patientes.destroy', $patienteI->id], 'method' => 'delete']) !!}
                            <a href="{{ route('patientes.show', [$patienteI->id]) }}" class='btn btn-sm btn-primary' ><i class="fa fa-eye"></i> Show </a>
                            @if(Auth::user()->role_id == 1)
                                {!! Form::button('<a><i class="fa fa-trash"></i> Delete </a>', ['type' => 'submit', 'class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('You are about to delete a root record, if the information is not saved all documents attached to this worker will be lost. (Valid Documents and Expired Documents, Signed Contracts, Etc.).')"]) !!}
                            @endif
                        {!! Form::close() !!}
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
        $(document).ready(function () {
            $('#tablePatienes').DataTable( {
                retrieve: true,
                paging: true,
                autoFill: true,
                responsive: true,
                columnDefs: [
                    { 
                        orderable: false, 
                        targets: 0
                    }
                ],
                order: [
                    [4, 'asc']
                ]
            });
        });
    </script>
@endpush