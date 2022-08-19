@extends('layouts.default')

@push('css')
	<link href="/assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables.net-select-bs4/css/select.bootstrap4.min.css" rel="stylesheet" />
@endpush

@section('content')
<!-- begin page-header -->
        <!-- end page-header -->
        @include('flash::message')
        <!-- begin panel -->
			<div class="panel panel-inverse">
				<!-- begin panel-heading -->
				<div class="panel-heading">
                    <h4 class="panel-title">
                        Filters
                    </h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                </div>
				<!-- end panel-heading -->
				<!-- begin panel-body -->
				<div class="panel-body">
					<div class="row">
						<div class="col">
							<!-- Role Id Field -->
							<div class="form-group">
								{!! Form::label('service_id', 'Service:') !!}
								<select name='service_id'id="service_id" class="form-control" required="true">
									@if (isset($services) && !empty($services) && count($services) >= 1)
										<option data-name-service='all' value='all' selected>All</option>
										@foreach($services as $key => $service)
											<option data-name-service='{{ $service->name_service }}' value='{{ $service->id }}' >{{ $service->name_service }}</option>
										@endforeach
									@endif
								</select>					
							</div>
						</div>
						<div class="col">
							<!-- Role Id Field -->
							<div class="form-group">
								{!! Form::label('paid', 'Status Pay:') !!}
								<select name='paid' id="paid" class="form-control" required="true">
									<option value='' selected>Select Option..</option>
									<option value='1' >Yes</option>
									<option value='0' >No</option>
								</select>
							</div>
						</div>
						<div class="col">
							<div class="form-group">
								{!! Form::label('desde', 'From:') !!}
								<input type="date" name="desde" id="desde" class="form-control" value="" required="true">
							</div>
						</div>
						<div class="col">
							<div class="form-group">
								{!! Form::label('hasta', 'To:') !!}
								<input type="date" name="hasta" id="hasta" class="form-control" value="" required="true">
							</div>
						</div>
					</div>
					<!-- Submit Field -->
					<div class="form-group col-sm-12">
						<input class="btn btn-primary" type="submit" name="btn_submit" id="btn_submit" value="Search" />
						<input class="btn btn-secondary" type="reset" name="btn_reset" id="btn_reset" value="Clear" />
					</div>
				</div>
				<!-- end panel-body -->
			</div>

			<div class="row">
				@include('pages.dashboard.dashboard-sub-services-mac')
			</div>

			<div>
				@include('pages.dashboard.dashboard-sub-services-mac-contable')
			</div>
@endsection

@push('scripts')

	<script>
        $(function () {
            $('#contable-table-wor').DataTable( {
                retrieve: true,
                paging: true,
                autoFill: true,
            });
        });
    </script>

	<script>
        $(function () {
            $('#contable-table-pat').DataTable( {
                retrieve: true,
                paging: true,
                autoFill: true,
            });
        });
    </script>

    <script>
		$('#btn_submit').click(function() {
			
			var url = "/matchAndControl";
			var service_id = $('#service_id').val();
			var paid = $('#paid').val();
			var dateDesde = $('#desde').val();
			var dateHasta = $('#hasta').val();
			var token = '{{ csrf_token() }}';
			var roleUser = '{{ Auth::user()->role_id }}';

			if(service_id != '' && paid != '' && dateDesde != '' && dateHasta != ''){
				$.ajax({
					type: "post",
					url: url,
					dataType: 'json',
					data: {
						_token: token,
						service_id: service_id,
						paid: paid,
						desde: dateDesde,
						hasta: dateHasta
					},
					success: function(data) {

						if(data['success'] == false){
							$('#resulWor').empty();
							$('#resulPat').empty();
							$('#resulWorTab').empty();
							$('#resulPatTab').empty();

							let msjOne = 'There are no matches for the search parameters entered, please enter others..\n\n';
							let msjTwo = 'No existen coincidencias con los parametros de busqueda ingresados , por favor ingrese otros.';
							alert(msjOne + msjTwo);
						}

						var dataFullW = data['dataW'];
						var dataFullP = data['dataP'];

						dataFullW.forEach(function(valor, indice, array) {
							dataFullW[indice].worker_id = JSON.parse(dataFullW[indice].worker_id);
							dataFullW[indice].patiente_id = JSON.parse(dataFullW[indice].patiente_id);
							dataFullW[indice].service_id = JSON.parse(dataFullW[indice].service_id);
							dataFullW[indice].sub_service_id = JSON.parse(dataFullW[indice].sub_service_id);
						});

						dataFullP.forEach(function(valor, indice, array) {
							dataFullP[indice].worker_id = JSON.parse(dataFullP[indice].worker_id);
							dataFullP[indice].patiente_id = JSON.parse(dataFullP[indice].patiente_id);
							dataFullP[indice].service_id = JSON.parse(dataFullP[indice].service_id);
							dataFullP[indice].sub_service_id = JSON.parse(dataFullP[indice].sub_service_id);
						});

						if(roleUser == 1){

							var htmlResultados = '';

							for (var i = 0; i < dataFullW.length; i++) {

								$('#resulWorTab').empty();
								$('#resulPatTab').empty();

								var dataW = 
									'<tr>\n' +
										'<td>' + dataFullW[i].patiente_id.first_name + ' ' + dataFullW[i].patiente_id.last_name + '</td>\n' +
										'<td>' + dataFullW[i].service_id.name_service + ' - ' + dataFullW[i].sub_service_id.name_sub_service + '</td>\n' +
										'<td>' + dataFullW[i].worker_id.first_name + ' ' + dataFullW[i].worker_id.last_name + '</td>\n' +
										'<td>' + dataFullW[i].unidad_time_worker + ' ' + dataFullW[i].unidad_type_worker + ' - ' + dataFullW[i].unit_value_worker + '$ (USD)</td>\n' +
										'<td>' + dateDesde + ' - ' + dateHasta + '</td>\n' +
										'<td>' + dataFullW[i].time_attention + ' = ' + dataFullW[i].unid_pay_worker + '</td>\n' +
										'<td>' + dataFullW[i].mont_pay + '$ (USD)' + + '</td>\n' +
										'<td> lol </td>\n' +
									'</tr>\n';

								htmlResultados = dataW;
										
								$('#resulWorTab').append(htmlResultados);
							};

							for (var i = 0; i < dataFullP.length; i++) {
								
								var dataP = 
									'<tr>\n' +
										'<td>' + dataFullP[i].patiente_id.first_name + ' ' + dataFullP[i].patiente_id.last_name + '</td>\n' +
										'<td>' + dataFullP[i].service_id.name_service + ' - ' + dataFullP[i].sub_service_id.name_sub_service + '</td>\n' +
										'<td>' + dataFullP[i].unidad_time_worker + ' ' + dataFullP[i].unidad_type_worker + ' - ' + dataFullP[i].unit_value_patiente + '$ (USD)</td>\n' +
										'<td>' + dateDesde + ' - ' + dateHasta + '</td>\n' +
										'<td>' + dataFullP[i].time_attention + ' = ' + dataFullP[i].unid_pay_worker + '</td>\n' +
										'<td>' + dataFullP[i].mont_cob + '$ (USD) </td>\n' +
										'<td> lol </td>\n' +
									'</tr>\n';

								htmlResultados = dataP;
										
								$('#resulPatTab').append(htmlResultados);
							};

						}else{

							$('#resulWor').empty();
							$('#resulPat').empty();

							var htmlResultados = '';
							var colBG = ''

							if(paid == 1){
								colBG = 'bg-teal';
							}else if(paid == 0){
								colBG = 'bg-red';
							}

							var arrayW = [];
							for (var i = 0; i < dataFullW.length; i++) {							

									var dataW = 
										'<div class="col-xl-6 col-md-6">\n' +
											'<div class="widget widget-stats ' + colBG + '">\n' +
												'<div class="stats-icon stats-icon-lg"><i class="fa fa-clock fa-fw"></i></div>\n' +
												'<div class="stats-info">\n' +
													'<h4>' + dataFullW[i].patiente_id.first_name + ' ' + dataFullW[i].patiente_id.last_name + '</h4>\n' +
													'<h4>WK: ' + dataFullW[i].worker_id.first_name + ' ' + dataFullW[i].worker_id.last_name + '</h4>\n' +
													'<h4>' + dataFullW[i].service_id.name_service + ' - ' + dataFullW[i].sub_service_id.name_sub_service + '</h4>\n' +
													'<h4>Unit of: ' + dataFullW[i].unidad_time_worker + ' ' + dataFullW[i].unidad_type_worker + ' - Unit value: ' + dataFullW[i].unit_value_worker + '$ (USD)</h4>\n' +
													'<h4>Time: ' + dataFullW[i].time_attention + ' = ' + dataFullW[i].unid_pay_worker + ' units </h4>\n' +
													'<h4>Amount to be paid: ' + dataFullW[i].mont_pay + '$ (USD) </h4>\n' +												
												'</div>\n' +
											'</div>\n' +
										'</div>\n';
										
								htmlResultados = dataW;
										
								$('#resulWor').append(htmlResultados);
							};

							for (var i = 0; i < dataFullP.length; i++) {
				
									var dataP = 
										'<div class="col-xl-6 col-md-6">\n' +
											'<div class="widget widget-stats ' + colBG + '">\n' +
												'<div class="stats-icon stats-icon-lg"><i class="fa fa-clock fa-fw"></i></div>\n' +
												'<div class="stats-info">\n' +
													'<h4>'+ dataFullP[i].patiente_id.first_name + ' ' + dataFullP[i].patiente_id.last_name + '</h4>\n' +
													'<h4>' + dataFullP[i].service_id.name_service + ' - ' + dataFullP[i].sub_service_id.name_sub_service + '</h4>\n' +
													'<h4>Unit of: ' + dataFullP[i].unidad_time_worker + ' ' + dataFullP[i].unidad_type_worker + ' - Unit value: ' + dataFullP[i].unit_value_patiente + '$ (USD)</h4>\n' +
													'<h4>Time: ' + dataFullP[i].time_attention + ' = ' + dataFullP[i].unid_pay_worker + ' units </h4>\n' +
													'<h4>Amount receivable: ' + dataFullP[i].mont_cob + '$ (USD) </h4>\n' +
													'<h4>Amount to be paid: ' + dataFullP[i].mont_pay + '$ (USD) </h4>\n' +
													'<h4>Company profit: ' + dataFullP[i].ganancia_empresa +  '$ (USD) </h4>\n' +	
												'</div>\n' +
											'</div>\n' +
										'</div>\n';

								htmlResultados = dataP;
										
								$('#resulPat').append(htmlResultados)
							};
						}
						
					},
					error: function (error) { 
						console.log(error);
					}
				});	
			}else{
				let msjOne = 'You must fill in all the fields for a more accurate search.\n\n';
				let msjTwo = 'Debe llenar todos los campos para una busqueda mas precisa.';
				alert(msjOne + msjTwo);
			}
		});
	</script>
@endpush

@push('scripts')
	<script src="/assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="/assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="/assets/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
	<script src="/assets/plugins/datatables.net-select/js/dataTables.select.min.js"></script>
	<script src="/assets/plugins/datatables.net-select-bs4/js/select.bootstrap4.min.js"></script>
	<script src="/assets/plugins/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
	<script src="/assets/plugins/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
	<script src="/assets/plugins/datatables.net-buttons/js/buttons.colVis.min.js"></script>
	<script src="/assets/plugins/datatables.net-buttons/js/buttons.flash.min.js"></script>
	<script src="/assets/plugins/datatables.net-buttons/js/buttons.html5.min.js"></script>
	<script src="/assets/plugins/datatables.net-buttons/js/buttons.print.min.js"></script>
	<script src="/assets/plugins/pdfmake/build/pdfmake.min.js"></script>
	<script src="/assets/plugins/pdfmake/build/vfs_fonts.js"></script>
	<script src="/assets/plugins/jszip/dist/jszip.min.js"></script>
	<script src="/assets/js/demo/table-manage-combine.demo.js"></script>
@endpush