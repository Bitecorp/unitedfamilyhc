<div class="panel panel-inverse">
	<!-- begin panel-body -->
	<div class="panel-body">
        <div class="col-xs-12 ">
            <table id="tableSalary{{$value->id}}" class="table table-striped table-bordered table-td-valign-middle">
                <thead>
                    <tr>
                        <th width="1%"></th>
                        <th class="text-nowrap">Name Sub Service</th>
                        <th class="text-nowrap">Assigned</th>
                        <th class="text-nowrap">Type Salary</th>
                        <th class="text-nowrap">Customer Billing</th>
                        <th class="text-nowrap">Worker Payment</th>
                        <th class="text-nowrap">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($subServices))
                        @foreach($subServices AS $keyS => $subServic)
                            @foreach($subServic AS $keySs => $subService)
                                @if($value->id == $subService->service_id)
                                    <tr>
                                        <td width="1%" class="f-s-600 text-inverse">{{ $keySs + 1 }}</td>
                                        <td>{{ $subService->name_sub_service }}</td>
                                        <td>
                                            {!! Form::model($subService, ['route' => ['subServices.assignSubService', $worker->id, $subService->id], 'method' => 'post', 'id' => "sendForm_$subService->id"]) !!}
                                            <!-- begin custom-switches -->
                                                <div class="custom-control custom-switch">
                                                    @foreach($salaryServiceAssigneds AS $salaryServiceAssigned)
                                                        <input type="checkbox" onclick="changeStatus('{{$subService->id}}');"  class="custom-control-input" data-id="{{ $subService->id }}" name="{{$subService->id}}" id="Switch_{{$subService->id}}" {{ isset($salaryServiceAssigned) && isset($salaryServiceAssigned->service_id) && $salaryServiceAssigned->service_id == $subService->id ? 'checked' : '' }}>
                                                    @endforeach
                                                    <label class="custom-control-label" for="Switch_{{$subService->id}}"></label>
                                                </div>
                                            <!-- end custom-switches -->
                                            {!! Form::close() !!}
                                        </td>
                                        <td>
                                            @if(isset($salaryServiceAssigneds))
                                                @foreach($salaryServiceAssigneds AS $keySA => $salaryServiceAssigned)
                                                    @if($subService->id == $salaryServiceAssigned->service_id)
                                                        {{ $salaryServiceAssigned->type_salary ==  0 ? 'Monthly' : 'Per Hour'}}
                                                    @endif
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($salaryServiceAssigneds))
                                                @foreach($salaryServiceAssigneds AS $keySA => $salaryServiceAssigned)
                                                    @if($subService->id == $salaryServiceAssigned->service_id)
                                                        {{ $subService->price_sub_service == $salaryServiceAssigned->customer_payment || $salaryServiceAssigned->customer_payment == ''  ? $subService->price_sub_service : $salaryServiceAssigned->customer_payment  }} $
                                                    @endif
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($salaryServiceAssigneds))
                                                @foreach($salaryServiceAssigneds AS $keySA => $salaryServiceAssigned)
                                                    @if($subService->id == $salaryServiceAssigned->service_id)
                                                        {{ $subService->worker_payment == $salaryServiceAssigned->salary || $salaryServiceAssigned->salary == '' ? $subService->worker_payment : $salaryServiceAssigned->salary }} $
                                                    @endif
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="with-btn" nowrap>
                                            @if(isset($salaryServiceAssigneds))
                                                @foreach($salaryServiceAssigneds AS $keySA => $salaryServiceAssigned)
                                                    @if($subService->id == $salaryServiceAssigned->service_id)
                                                        <a href="{{ route('salaryServiceAssigneds.edit', [$salaryServiceAssigned->id]) }}" class='btn btn-sm btn-info'><i class="fa fa-edit"></i> Add/Edit Salary </a>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
	</div>
	<!-- end panel-body -->
</div>

@push('scripts')
<script>
    function changeStatus(dato) {
        $('#Switch_' + dato).change(function() {
            $('#sendForm_' + dato).submit();
        })
    };

    $(function () {
        $('#tableSalary' + {{ $value->id }}).DataTable( {
            retrieve: true,
            paging: true,
            searching: true
        });
    });
</script>
@endpush