<table id="tableWorkers" class="table table-striped table-bordered table-td-valign-middle">
    <thead>
        <tr>
            <th class="text-nowrap">Full Name</th>
            <th class="text-nowrap">Home Phone</th>
            <th class="text-nowrap">Email</th>
            <th class="text-nowrap">Role</th>
            <th class="text-nowrap">Status</th>
            <th class="text-nowrap">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($workers['WA'] as $key => $worker)
            <tr data-id='{{ $worker->id }}' id="data_{{ $worker->id }}">
                <td>{{ $worker->first_name }} {{ $worker->last_name }}</td>
                <td>{{ $worker->home_phone }}</td>
                <td>{{ $worker->email }}</td>
                @foreach($roles as $role)
                    @if($worker->role_id == $role->id)
                        <td>{{ $role->name_role }}</td>
                    @endif
                @endforeach
                @foreach($status as $statu)
                    @if($worker->statu_id == $statu->id)
                        @if($worker->id == 1)
                            <td>{{ $statu->name_status }}</td>
                        @elseif($worker->id > 1)
                            <td>
                                {!! Form::model($worker, ['route' => ['workers.updateState', $worker->id], 'method' => 'post', 'id' => "sendForm_$worker->id"]) !!}
                                <!-- begin custom-switches -->
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" onclick="changeStatus('{{$worker->id}}');"  class="custom-control-input" data-id="{{ $worker->id }}" name="Switch_{{$worker->id}}" id="Switch_{{$worker->id}}" {{ $worker->statu_id == 1 ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="Switch_{{$worker->id}}"></label>
                                    </div>
                                <!-- end custom-switches -->
                                {!! Form::close() !!}
                            </td>
                        @endif
                    @endif
                @endforeach
                <td class="with-btn" nowrap>
                    @if($worker->id > 1 )
                        {!! Form::open(['route' => ['workers.destroy', $worker->id], 'method' => 'delete']) !!}
                            <a href="{{ route('workers.show', [$worker->id]) }}" class='btn btn-sm btn-primary' ><i class="fa fa-eye"></i> Show </a>
                            @if(Auth::user()->role_id == 1)
                                {!! Form::button('<a><i class="fa fa-trash"></i> Delete </a>', ['type' => 'submit', 'class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('You are about to delete a root record, if the information is not saved all documents attached to this worker will be lost. (Valid Documents and Expired Documents, Signed Contracts, Etc.).')"]) !!}
                            @endif
                        {!! Form::close() !!}
                    @endif
                </td>
            </tr>
        @endforeach

        @foreach($workers['WI'] as $key => $workerI)
            <tr data-id='{{ $workerI->id }}' id="data_{{ $workerI->id }}">
                <td>{{ $workerI->first_name }} {{ $workerI->last_name }}</td>
                <td>{{ $workerI->home_phone }}</td>
                <td>{{ $workerI->email }}</td>
                @foreach($roles as $role)
                    @if($workerI->role_id == $role->id)
                        <td>{{ $role->name_role }}</td>
                    @endif
                @endforeach
                @foreach($status as $statu)
                    @if($workerI->statu_id == $statu->id)
                        @if($workerI->id == 1)
                            <td>{{ $statu->name_status }}</td>
                        @elseif($workerI->id > 1)
                            <td>
                                {!! Form::model($workerI, ['route' => ['workers.updateState', $workerI->id], 'method' => 'post', 'id' => "sendForm_$workerI->id"]) !!}
                                <!-- begin custom-switches -->
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" onclick="changeStatus('{{$workerI->id}}');"  class="custom-control-input" data-id="{{ $workerI->id }}" name="Switch_{{$workerI->id}}" id="Switch_{{$workerI->id}}" {{ $workerI->statu_id == 1 ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="Switch_{{$workerI->id}}"></label>
                                    </div>
                                <!-- end custom-switches -->
                                {!! Form::close() !!}
                            </td>
                        @endif
                    @endif
                @endforeach
                <td class="with-btn" nowrap>
                    @if($workerI->id > 1 )
                        {!! Form::open(['route' => ['workers.destroy', $workerI->id], 'method' => 'delete']) !!}
                            <a href="{{ route('workers.show', [$workerI->id]) }}" class='btn btn-sm btn-primary' ><i class="fa fa-eye"></i> Show </a>
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
            $('#tableWorkers').DataTable( {
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