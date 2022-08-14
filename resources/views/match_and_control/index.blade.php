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
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-primary" class="pull-right"><i class="fa fa-plus"></i></a>
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
								{!! Form::label('paid', 'Paid ?:') !!}
								<select name='paid' id="paid" class="form-control" required="true">
									<option value='' selected>Select Option..</option>
									<option value='1' >Yes</option>
									<option value='0' >Not</option>
								</select>
							</div>
						</div>
						<div class="col">
							<!-- Role Id Field -->
							<div class="form-group">
								{!! Form::label('service_id', 'Service:') !!}
								<select name='service_id'id="service_id" class="form-control" required="true">
									@if (isset($services) && !empty($services) && count($services) >= 1)
										<option data-name-service='' value='' selected>Select Service..</option>
										@foreach($services as $key => $service)
											<option data-name-service='{{ $service->name_service }}' value='{{ $service->id }}' >{{ $service->name_service }}</option>
											@if (count($services) == $key + 1)
												<option data-name-service='all' value='all' >All</option>
											@endif
										@endforeach
									@endif
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

			<div id="dashboard">
				@include('pages.dashboard.dashboard-sub-services-mac')
			</div>
@endsection

@push('scripts')
    <script>
		$('#btn_submit').click(function() {
			
			var url = "/matchAndControl";
			var service_id = $('#service_id').val();
			var paid = $('#paid').val();
			var dateDesde = $('#desde').val();
			var dateHasta = $('#hasta').val();
			var token = '{{ csrf_token() }}';

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
						var dataFull = data['data'];
						dataFull.forEach(function(valor, indice, array) {
							dataFull[indice].worker_id = JSON.parse(dataFull[indice].worker_id);
							dataFull[indice].patiente_id = JSON.parse(dataFull[indice].patiente_id);
							dataFull[indice].service_id = JSON.parse(dataFull[indice].service_id);
							dataFull[indice].sub_service_id = JSON.parse(dataFull[indice].sub_service_id);
						});

						$('#resultados').empty();

						if(dataFull == '' || dataFull.length == 0 || data['success'] == false){
							let msjOne = 'There are no matches for the search parameters entered, please enter others..\n\n';
							let msjTwo = 'No existen coincidencias con los parametros de busqueda ingresados , por favor ingrese otros.';
							alert(msjOne + msjTwo);
						}

						var htmlResultados = '';

						for (var i = 0; i < dataFull.length; i++) {
							if(paid == 1){
			
								var dataW = 
									'<div class="col-xl-6 col-md-6">\n' +
										'<div class="widget widget-stats bg-teal">\n' +
											'<div class="stats-icon stats-icon-lg"><i class="fa fa-clock fa-fw"></i></div>\n' +
											'<div class="stats-info">\n' +
												'<h4>' + dataFull[i].service_id.name_service + ' - ' + dataFull[i].sub_service_id.name_sub_service + ' - ' + dataFull[i].worker_id.first_name + ' ' + dataFull[i].worker_id.last_name +'</h4>\n' +
												'<h4>Unit of: ' + dataFull[i].unidad_time_worker + ' ' + dataFull[i].unidad_type_worker + ' - Unit value: ' + dataFull[i].unit_value_worker + '</h4>\n' +
												'<h4>Time: ' + dataFull[i].time_attention + ' = ' + dataFull[i].unid_pay_worker + ' units </h4>\n' +
												'<h4>Amount to be paid: ' + dataFull[i].mont_pay + ' $ (USD) </h4>\n' +												
											'</div>\n' +
										'</div>\n' +
									'</div>\n';

								var dataP = 
									'<div class="col-xl-6 col-md-6">\n' +
										'<div class="widget widget-stats bg-teal">\n' +
											'<div class="stats-icon stats-icon-lg"><i class="fa fa-clock fa-fw"></i></div>\n' +
											'<div class="stats-info">\n' +
												'<h4>' + dataFull[i].service_id.name_service + ' - ' + dataFull[i].sub_service_id.name_sub_service + ' - ' + dataFull[i].patiente_id.first_name + ' ' + dataFull[i].patiente_id.last_name +'</h4>\n' +
												'<h4>Unit of: ' + dataFull[i].unidad_time_patiente + ' ' + dataFull[i].unidad_type_patiente + ' - Unit value: ' + dataFull[i].unid_cob_patiente + '</h4>\n' +
												'<h4>Time: ' + dataFull[i].time_attention + ' = ' + dataFull[i].unid_pay_worker + ' units </h4>\n' +
												'<h4>Amount receivable: ' + dataFull[i].mont_cob + ' $ (USD) </h4>\n' +
											'</div>\n' +
										'</div>\n' +
									'</div>\n';

								htmlResultados =
									'<tr id="tr_' + dataFull[i].id + '">\n' +
										'<td>' + dataW + '</td>\n' +
										'<td>' + dataP + '</td>\n' +
									'</tr>\n';
								
								$('#resultados').append(htmlResultados);

							}else if(paid == 0){

								var dataW = 
									'<div class="col-xl-6 col-md-6">\n' +
										'<div class="widget widget-stats bg-red">\n' +
											'<div class="stats-icon stats-icon-lg"><i class="fa fa-clock fa-fw"></i></div>\n' +
											'<div class="stats-info">\n' +
												'<h4>' + dataFull[i].service_id.name_service + ' - ' + dataFull[i].sub_service_id.name_sub_service + ' - ' + dataFull[i].worker_id.first_name + ' ' + dataFull[i].worker_id.last_name +'</h4>\n' +
												'<h4>Unit of: ' + dataFull[i].unidad_time_worker + ' ' + dataFull[i].unidad_type_worker + ' - Unit value: ' + dataFull[i].unit_value_worker + '</h4>\n' +
												'<h4>Time: ' + dataFull[i].time_attention + ' = ' + dataFull[i].unid_pay_worker + ' units </h4>\n' +
												'<h4>Amount to be paid: ' + dataFull[i].mont_pay + ' $ (USD) </h4>\n' +
											'</div>\n' +
										'</div>\n' +
									'</div>\n';

								var dataP = 
									'<div class="col-xl-6 col-md-6">\n' +
										'<div class="widget widget-stats bg-red">\n' +
											'<div class="stats-icon stats-icon-lg"><i class="fa fa-clock fa-fw"></i></div>\n' +
											'<div class="stats-info">\n' +
												'<h4>' + dataFull[i].service_id.name_service + ' - ' + dataFull[i].sub_service_id.name_sub_service + ' - ' + dataFull[i].patiente_id.first_name + ' ' + dataFull[i].patiente_id.last_name + '</h4>\n' +
												'<h4>Unit of: ' + dataFull[i].unidad_time_patiente + ' ' + dataFull[i].unidad_type_patiente + ' - Unit value: ' + dataFull[i].unit_value_patiente + '</h4>\n' +
												'<h4>Time: ' + dataFull[i].time_attention + ' = ' + dataFull[i].unid_pay_worker + ' units </h4>\n' +
												'<h4>Amount receivable: ' + dataFull[i].mont_cob + ' $ (USD) </h4>\n' +
											'</div>\n' +
										'</div>\n' +
									'</div>\n';

								htmlResultados =
									'<tr id="tr_' + dataFull[i].id + '">\n' +
										'<td>' + dataW + '</td>\n' +
										'<td>' + dataP + '</td>\n' +
									'</tr>\n';
								
								$('#resultados').append(htmlResultados);
							}
						
						};
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