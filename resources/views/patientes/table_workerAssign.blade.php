<div class="panel panel-inverse">
	<!-- begin panel-body -->
	<div class="panel-body">
        <div class="col-xs-12 ">
            <table id="workersForAssign" class="table table-striped table-bordered table-td-valign-middle">
                <thead>
                    <tr>
                        <th width="1%"></th>
                        <th class="text-nowrap">Worker</th>
                        <th class="text-nowrap">Assign</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($workerList as $key => $worker)
                        <tr data-id='{{ $worker->id }}' id="data_{{ $key }}">
                            <td width="1%" class="f-s-600 text-inverse">{{ $key + 1 }}</td>
                            <td>{{ $worker->first_name }} {{ $worker->last_name }}</td>
                            <td>
                                {!! Form::open(['route' => ['patientes.assingWorker', [$patiente->id, $worker->id]], 'method' => 'post', 'id' => "sendForm_$worker->id"]) !!}
                                <!-- begin custom-switches -->
                                    <div class="custom-control custom-switch">
                                        @if (isset($workersAssigneds) && !empty($workersAssigneds) && count($workersAssigneds) >= 1)
                                            @foreach ($workersAssigneds as $workersAssigned)
                                                <input type="checkbox" onclick="changeStatus('{{$worker->id}}');"  class="custom-control-input" data-id="{{ $worker->id }}" name="Switch_{{$worker->id}}" id="Switch_{{$worker->id}}" {{ $worker->id == $workersAssigned->worker_id ? 'checked' : '' }}>
                                            @endforeach
                                        @else
                                            <input type="checkbox" onclick="changeStatus('{{$worker->id}}');"  class="custom-control-input" data-id="{{ $worker->id }}" name="Switch_{{$worker->id}}" id="Switch_{{$worker->id}}">
                                        @endif
                                        <label class="custom-control-label" for="Switch_{{$worker->id}}"></label>
                                    </div>
                                <!-- end custom-switches -->
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach                
                </tbody>
            </table>
        </div>
	</div>
	<!-- end panel-body -->
</div>

@push('scripts')
    <script>
        $(function () {
            $('#workersForAssign').DataTable( {
                retrieve: true,
                paging: true,
                searching: true,
                autoFill: true,
            });
        });
        function changeStatus(dato) {
            $('#Switch_' + dato).change(function() {
                $('#sendForm_' + dato).submit();
            })
        };
    </script>
@endpush