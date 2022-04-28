<div class="panel panel-inverse">
	<!-- begin panel-body -->
	<div class="panel-body">
        <div class="col-xs-12 ">
            <table id="tableSalary" class="table table-striped table-bordered table-td-valign-middle">
                <thead>
                    <tr>
                        <th width="1%"></th>
                        <th class="text-nowrap">Service Id</th>
                        <th class="text-nowrap">Type Salary</th>
                        <th class="text-nowrap">Salary</th>
                        <th class="text-nowrap">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salaryServiceAssigneds as $key => $salaryServiceAssigneds)
                        <tr>
                            <td width="1%" class="f-s-600 text-inverse">{{ $key + 1 }}</td>
                            @foreach($services AS $key => $value)
                                @if($salaryServiceAssigneds->service_id == $value->id)
                                    <td>{{ $value->name_service }}</td>
                                @endif
                            @endforeach
                            @if($salaryServiceAssigneds->type_salary == 0)
                                <td>Monthly</td>
                            @else
                                <td>Per Hour</td>
                            @endif
                            <td>{{ $salaryServiceAssigneds->salary != '' ? $salaryServiceAssigneds->salary : 0 }} $ {{ $salaryServiceAssigneds->type_salary == 0 ? 'Monthly' : ''}} {{ $salaryServiceAssigneds->type_salary == 1 ? 'Per Hour' : ''}}</td>
                            <td class="with-btn" nowrap>
                                {!! Form::open(['route' => ['salaryServiceAssigneds.destroy', $salaryServiceAssigneds->id], 'method' => 'delete']) !!}
                                    <!-- <a href="{{ route('salaryServiceAssigneds.show', [$salaryServiceAssigneds->id]) }}" class='btn btn-sm btn-primary' ><i class="fa fa-eye"></i> Show </a> -->
                                    <a href="{{ route('salaryServiceAssigneds.edit', [$salaryServiceAssigneds->id]) }}" class='btn btn-sm btn-info'><i class="fa fa-edit"></i> Add/Edit Salary </a>
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
        $('#tableSalary').DataTable( {
            retrieve: true,
            paging: true,
            searching: true
        });
    });
</script>
@endpush