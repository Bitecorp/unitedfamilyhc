<?php
    // solo para saber el nombre del servicio
    $start      =   '@foreach($services as $key => $service)
                        @if($service->id == ';
    $midle      =   ')
                <p>{{ $service->name_service }}</p>';
    $end        =   '   @endif
                    @endforeach';

    // si se desea saber el monto y tipo de negociacion echa para un servicio con un worker especifico
    $startTwo      =   '@foreach($services as $key => $service)
                            @foreach($salaryServices as $keySalary => $salaryService)
                                @if($service->id == $salaryService->service_id';
    $midleTwo     =   ')
                <p>{{ $salaryService->salary }}{{ $salaryService->type_salary == 0 ? "$ Monthly" : "$ Per Hour"}}</p>';
    $endTwo        =   '       @endif
                            @endforeach
                        @endforeach';
?>

<div class="panel panel-inverse">
	<!-- end panel-heading -->
	<!-- begin panel-body -->
	<div class="panel-body">
        <div class="col-xs-12 ">
            <table id="tableVariablesServices" class="table table-striped table-bordered table-td-valign-middle">
                <thead>
                    <tr>
                        <th class="text-nowrap">Service</th>
                        <th class="text-nowrap">Called name</th>
                        <th class="text-nowrap">salary call</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($services as $key => $service)
                        <tr>
                            <td>{{ $service->name_service }}</td>
                            <td>{{ $start }}{{ $service->id }}{{ $midle }}{{ $end }}</td>
                            <td>{{ $startTwo }}{{ $midleTwo }}{{ $endTwo }}</td>
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
        $('#tableVariablesServices').DataTable( {
            ordering: true,
            retrieve: true,
            paging: true,
            searching: true,
        });
    });
</script>
@endpush