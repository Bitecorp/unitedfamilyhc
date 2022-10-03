<table id="tableAgentsAct" class="table table-striped table-bordered table-td-valign-middle">
    <thead>
        <tr>
            <th width="1%"></th>
            <th class="text-nowrap">Full Name</th>
            <th class="text-nowrap">Home Phone</th>
            <th class="text-nowrap">Email</th>
            <th class="text-nowrap">Role</th>
            <th class="text-nowrap">Status</th>
            <th class="text-nowrap">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($agents['AA'] as $key => $worker)
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
                @foreach($status as $statu)
                    @if($worker->statu_id == $statu->id)
                        @if($worker->id == 1)
                            <td>{{ $statu->name_status }}</td>
                        @elseif($worker->id > 1)
                            <td>
                                {!! Form::model($worker, ['route' => ['agents.updateState', $worker->id], 'method' => 'post', 'id' => "sendForm_$worker->id"]) !!}
                                <!-- begin custom-switches -->
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" onclick="changeStatus('{{$worker->id}}');"  class="custom-control-input" data-id="{{ $worker->id }}" name="{{$worker->id}}" id="Switch_{{$worker->id}}" {{ $worker->statu_id == 1 ? 'checked' : '' }}>
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
                        {!! Form::open(['route' => ['agents.destroy', $worker->id], 'method' => 'delete']) !!}
                            <a href="{{ route('agents.show', [$worker->id]) }}" class='btn btn-sm btn-primary' ><i class="fa fa-eye"></i> Show </a>
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
            $('#tableAgentsAct').DataTable( {
                retrieve: true,
                paging: true,
                autoFill: true,
                responsive: true
            });
        });
    </script>
@endpush