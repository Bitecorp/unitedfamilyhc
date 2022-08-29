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

			@if (strpos(Request::url(), 'matchAndControl'))
				<div class="row">
					@include('pages.dashboard.dashboard-sub-services-mac')
				</div>
			@endif
			
			@if(strpos(Request::url(), 'manageBillAndPay'))
				<div>
					@include('pages.dashboard.dashboard-sub-services-mac-contable')
				</div>
			@endif
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
		$(function() {
			$('#btn_reset').click(function() {
				$('#service_id').val('all');
				$('#paid').val('');
				$('#desde').val('');
				$('#hasta').val('');
				$('#resulWor').empty();
				$('#resulPat').empty();
				$('#resulWorTab').empty();
				$('#resulWorMod').empty();
				$('#resulPatTab').empty();
			});
		});
	</script>

    <script>
		$('#btn_submit').click(function() {

			$('#resulWor').empty();
			$('#resulPat').empty();
			$('#resulWorTab').empty();
			$('#resulWorMod').empty();
			$('#resulPatTab').empty();
			
			var url = "/matchAndControl";
			var service_id = $('#service_id').val();
			var paid = $('#paid').val();
			var dateDesde = $('#desde').val() + ' 00:00:00';
			var dateHasta = $('#hasta').val() + ' 23:59:59';
			var token = '{{ csrf_token() }}';
			var roleUser = '{{ Auth::user()->role_id }}';

			var dateDesdeT = new Date(dateDesde).toLocaleString('en-US');
			var dateHastaT = new Date(dateHasta).toLocaleString('en-US');

			var urlActualMAC = '{{ strpos(Request::url(), "matchAndControl") }}';
			var urlActualBYP = '{{ strpos(Request::url(), "manageBillAndPay") }}';

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

						var htmlResultados = '';
						var colBG = '';
						var checkCheck = '';
						var block = '';
						var revertir = '';
						

						if(paid == 1){
							colBG = 'bg-teal';
							checkCheck = 'checked';
							block = ' disabled readonly';
							revertir = 'revertir';
						}else if(paid == 0){
							colBG = 'bg-red';
							checkCheck = '';
							block = '';
							revertir = '';
						}

						var dataFullW = data['dataW'];
						var dataFullP = data['dataP'];

						if(dataFullW.length < 1 && dataFullP.length < 1){
							let msjOne = 'There are no matches for the search parameters entered, please enter others..\n\n';
							let msjTwo = 'No existen coincidencias con los parametros de busqueda ingresados , por favor ingrese otros.';
							alert(msjOne + msjTwo);
						}

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

						if(urlActualBYP){

							$('#resulWorTab').empty();
							$('#resulWorMod').empty();
							$('#resulPatTab').empty();
							var htmlResultados = '';
							var htmlResultModal = '';

							if(dataFullW.length >= 1){
								for (var i = 0; i < dataFullW.length; i++) {

									var check =
									'<div class="custom-control custom-switch">\n' +
										'<input type="checkbox" onclick="'+revertir+'pagar(' + dataFullW[i].patiente_id.id + ',' + dataFullW[i].worker_id.id + ',' + dataFullW[i].service_id.id + ',' + dataFullW[i].sub_service_id.id + ',' + dataFullW[i].status + ',' + dataFullW[i].paid + ');"  class="custom-control-input" name="Switch_' + dataFullW[i].id + '" id="Switch_worker_' + dataFullW[i].id + '" ' + checkCheck + '>\n' +
										'<label class="custom-control-label" for="Switch_worker_' + dataFullW[i].id + '"></label>\n' +
									'</div>\n';

									
									var btnModal = '';
									var textBtnOne = 'Generate 1099';
									var textBtnTwo = 'Save';
									var actionGenerateOrDownload = 'saveData';
									var valueInvoice = '';
									var eftorCheck = '';
									//if(paid == 1){
										if(paid == 1 && (dataFullW[i].independent_contractor.independent_contractor == 1 || dataFullW[i].independent_contractor.independent_contractor == '1')){

											if(dataFullW[i].invoice_number != '' && typeof dataFullW[i].invoice_number != 'undefined'){
												valueInvoice = dataFullW[i].invoice_number;
											}

											if(dataFullW[i].eftor_check != '' && typeof dataFullW[i].eftor_check != 'undefined'){
												eftorCheck = dataFullW[i].eftor_check;
												textBtnOne = 'Show 1099';
												textBtnTwo = 'Download';
												actionGenerateOrDownload = 'download1099';
											}
											
											btnModal = 
											'<div id="btnOpenModal_'+ dataFullW[i].worker_id.id + i +'">\n' +
												'<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal_'+ dataFullW[i].worker_id.id + i +'">' + textBtnOne + '</button>\n' +
											'</div>\n';

											var modal = 
											'<div class="modal fade" id="exampleModal_'+ dataFullW[i].worker_id.id + i +'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">\n' +
												'<div class="modal-dialog modal-lg">\n' +
													'<div class="modal-content">\n' +
														'<div class="modal-header">\n' +
															'<h5 class="modal-title" id="exampleModalLabel_'+ dataFullW[i].worker_id.id + i +'">Data to generate 1099 to the worker ' + dataFullW[i].worker_id.first_name + ' ' + dataFullW[i].worker_id.last_name + '</h5>\n' +
															'<button type="button" class="close" data-dismiss="modal" aria-label="Close">\n' +
																'<span aria-hidden="true">&times;</span>\n' +
															'</button>\n' +
														'</div>\n' +
														'<div class="modal-body">\n' +
															'<form id="form_'+ dataFullW[i].worker_id.id + i +'" role="form_'+ dataFullW[i].worker_id.id + i +'">\n' +
															'<div class="row">\n' +
																'<div class="col">\n' +
																	'<div class="form-group">\n' +
																		'{!! Form::label("eftor_check", "Eftor Check:") !!}\n' +
																		'<input type="text" class="form-control" name="eftor_check_'+ dataFullW[i].worker_id.id + i +'" id="eftor_check_'+ dataFullW[i].worker_id.id + i +'" value="' + eftorCheck + '" required="true">\n' +
																	'</div>\n' +
																'</div>\n' +
																'<div class="col">\n' +
																	'<div class="form-group">\n' +
																		'{!! Form::label("invoice_number", "Invoice Number:") !!}\n' +
																		'<input type="text" class="form-control" name="invoice_number_'+ dataFullW[i].worker_id.id + i +'" id="invoice_number_'+ dataFullW[i].worker_id.id + i +'" value="' + valueInvoice + '">\n' +
																	'</div>\n' +
																'</div>\n' +
															'</div>\n' +
															'</form>\n' +


														'</div>\n' +
														'<div class="modal-footer">\n' +
															'<button type="button" id="btn_close_'+ dataFullW[i].worker_id.id + i +'" class="btn btn-secondary" data-dismiss="modal">Close</button>\n' +
															'<div id="btnSaveOrdDownload_'+ dataFullW[i].worker_id.id + i +'">\n' +
																'<button type="button" onclick="' + actionGenerateOrDownload + '(' + dataFullW[i].patiente_id.id + ',' + dataFullW[i].worker_id.id + ',' + dataFullW[i].service_id.id + ',' + dataFullW[i].sub_service_id.id + ',' + dataFullW[i].status + ',' + dataFullW[i].paid + ',' + i +')" id="btn_save_'+ dataFullW[i].worker_id.id + i +'" class="btn btn-primary">' + textBtnTwo + '</button>\n' +
															'</div>\n' +
														'</div>\n' +
													'</div>\n' +
												'</div>\n' +
											'</div>\n';

										}
									//}

									var dataW = 
										'<tr>\n' +
											'<td width="1%" class="f-s-600 text-inverse">' + (i+1) + '</td>\n' +
											'<td>' + dataFullW[i].patiente_id.first_name + ' ' + dataFullW[i].patiente_id.last_name + '</td>\n' +
											'<td>' + dataFullW[i].service_id.name_service + ' - ' + dataFullW[i].sub_service_id.name_sub_service + '</td>\n' +
											'<td>' + dataFullW[i].worker_id.first_name + ' ' + dataFullW[i].worker_id.last_name + '</td>\n' +
											'<td>' + dataFullW[i].unidad_time_worker + ' ' + dataFullW[i].unidad_type_worker + ' - ' + dataFullW[i].unit_value_worker + '$ (USD)</td>\n' +
											'<td>' + dateDesdeT + ' - ' + dateHastaT + '</td>\n' +
											'<td>' + dataFullW[i].time_attention + ' = ' + dataFullW[i].unid_pay_worker + '</td>\n' +
											'<td>' + dataFullW[i].mont_pay + '$ (USD)</td>\n' +
											'<td class="with-btn" nowrap>\n'
												+ check + btnModal +
											'</td>\n'
										'</tr>\n';

									htmlResultados = dataW;
									htmlResultModal = modal;
											
									$('#resulWorTab').append(htmlResultados);
									$('#resulWorMod').append(htmlResultModal);
								};
							}

							if(dataFullP.length >= 1){
								for (var i = 0; i < dataFullP.length; i++) {

									var check =
									'<div class="custom-control custom-switch">\n' +
										'<input type="checkbox" onclick="'+revertir+'cobrar(' + dataFullP[i].patiente_id.id + ',' + dataFullP[i].service_id.id + ',' + dataFullP[i].sub_service_id.id + ',' + dataFullP[i].status + ',' + dataFullP[i].paid + ');"  class="custom-control-input" name="Switch_' + dataFullP[i].id + '" id="Switch_patiente' + dataFullP[i].id + '" ' + checkCheck + '>\n' +
										'<label class="custom-control-label" for="Switch_patiente' + dataFullP[i].id + '"></label>\n' +
									'</div>\n';
									
									var dataP = 
										'<tr>\n' +
											'<td width="1%" class="f-s-600 text-inverse">' + (i+1) + '</td>\n' +
											'<td>' + dataFullP[i].patiente_id.first_name + ' ' + dataFullP[i].patiente_id.last_name + '</td>\n' +
											'<td>' + dataFullP[i].service_id.name_service + ' - ' + dataFullP[i].sub_service_id.name_sub_service + '</td>\n' +
											'<td>' + dataFullP[i].unidad_time_worker + ' ' + dataFullP[i].unidad_type_worker + ' - ' + dataFullP[i].unit_value_patiente + '$ (USD)</td>\n' +
											'<td>' + dateDesdeT + ' - ' + dateHastaT + '</td>\n' +
											'<td>' + dataFullP[i].time_attention + ' = ' + dataFullP[i].unid_pay_worker + '</td>\n' +
											'<td>' + dataFullP[i].mont_cob + '$ (USD) </td>\n' +
											'<td class="with-btn" nowrap>\n'
												+ check +
											'</td>\n' +
										'</tr>\n';

									htmlResultados = dataP;
											
									$('#resulPatTab').append(htmlResultados);
								};
							}

						}else if(urlActualMAC){

							$('#resulWor').empty();
							$('#resulPat').empty();

							if(dataFullW.length >= 1){
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
							}

							if(dataFullP.length >= 1){
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

	<script>
		function download1099(idPatiente, idWorker, idService, idSubService, status, paid) {
			//
		};
	</script>

	<script>
		function saveData(idPatiente, idWorker, idService, idSubService, status, paid, i) {
			var dateDesde = $('#desde').val() + ' 00:00:00';
			var dateHasta = $('#hasta').val() + ' 23:59:59';
			var token = '{{ csrf_token() }}';
			var roleUser = '{{ Auth::user()->role_id }}';
			var url = "/generateDocumentOfPai";
			var valI = i;

			var worker_id = idWorker;
			var patiente_id = idPatiente;
			var service_id = idService;
			var sub_service_id = idSubService;
			var status = status;
			var paid = paid;

			var eftor_check = $('#eftor_check_' + worker_id + valI).val();
			var invoice_number = $('#invoice_number_' + worker_id + valI).val();

			var obj = document.getElementById('btn_close_' + worker_id + valI);

			var opcion = confirm("Are you sure you want to generate this document?");
			if (opcion == true && obj) {
				obj.click();
			
				setTimeout(
					$.ajax({
						type: "post",
						url: url,
						dataType: 'json',
						data: {
							_token: token,
							patiente_id: patiente_id,
							worker_id: worker_id,
							service_id: service_id,
							sub_service_id: sub_service_id,
							fecha_desde: dateDesde,
							fecha_hasta: dateHasta,
							status: status,
							paid: paid,
							eftor_check: eftor_check,
							invoice_number: invoice_number
						},
						success: function(data) {		
							$('#btnOpenModal_' + worker_id + valI)
								.empty()
								.append('<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal_'+ worker_id + valI +'">Show 1099</button>\n');
							$('#btnSaveOrdDownload_' + worker_id + valI)
								.empty()
								.append('<button type="button" onclick="download1099(' + patiente_id + ',' + worker_id + ',' + service_id + ',' + sub_service_id + ',' + status + ',' + paid + ',' + i + ')" id="btn_save_'+ worker_id + valI +'" class="btn btn-primary">Download</button>\n');
							
					
							
							let msjOne = 'The 1099 document was successfully generated.\n\n';
							let msjTwo = 'El documento 1099 fue generado con exito.';
							alert(msjOne + msjTwo);		
						},
						error: function (error) { 
							console.log(error);
						}
					})
				, 5000);
			}else if(opcion == false && obj){
				obj.click();
			}

		};
	</script>

	<script>
		function cobrar(idPatiente, idService, idSubService, status, paid) {
			var dateDesde = $('#desde').val() + ' 00:00:00';
			var dateHasta = $('#hasta').val() + ' 23:59:59';
			var token = '{{ csrf_token() }}';
			var roleUser = '{{ Auth::user()->role_id }}';
			var url = "/cobrarPatiente";

			var patiente_id = idPatiente;
			var service_id = idService;
			var sub_service = idSubService;
			var status = status;
			var paid = paid;

			$.ajax({
				type: "post",
				url: url,
				dataType: 'json',
				data: {
					_token: token,
					patiente_id: patiente_id,
					service_id: service_id,
					sub_service_id: sub_service,
					fecha_desde: dateDesde,
					fecha_hasta: dateHasta,
					status: status,
					paid: paid,
				},
				success: function(data) {
					var obj = document.getElementById('btn_submit');
					if(data['success'] == true){
						if (obj){
							obj.click(); 
						}
					}
					let msjOne = 'The payment process was carried out successfully.\n\n';
					let msjTwo = 'El proceso cobro fue realizado con exito.';
					alert(msjOne + msjTwo);
				},
				error: function (error) { 
					console.log(error);
				}
			});
		};
	</script>

	<script>
		function revertircobrar(idPatiente, idService, idSubService, status, paid) {
			var dateDesde = $('#desde').val() + ' 00:00:00';
			var dateHasta = $('#hasta').val() + ' 23:59:59';
			var token = '{{ csrf_token() }}';
			var roleUser = '{{ Auth::user()->role_id }}';
			var url = "/revertirCobrarPatiente";

			var patiente_id = idPatiente;
			var service_id = idService;
			var sub_service = idSubService;
			var status = status;
			var paid = paid;

			$.ajax({
				type: "post",
				url: url,
				dataType: 'json',
				data: {
					_token: token,
					patiente_id: patiente_id,
					service_id: service_id,
					sub_service_id: sub_service,
					fecha_desde: dateDesde,
					fecha_hasta: dateHasta,
					status: status,
					paid: paid,
				},
				success: function(data) {
					var obj = document.getElementById('btn_submit');
					if(data['success'] == true){
						if (obj){
							obj.click(); 
						}
					}
					let msjOne = 'The payment process was reversed out successfully.\n\n';
					let msjTwo = 'El proceso cobro fue revertido con exito.';
					alert(msjOne + msjTwo);
				},
				error: function (error) { 
					console.log(error);
				}
			});
		};
	</script>

	<script>
		function pagar(idPatiente, idWorker, idService, idSubService, status, paid) {
			var dateDesde = $('#desde').val() + ' 00:00:00';
			var dateHasta = $('#hasta').val() + ' 23:59:59';
			var token = '{{ csrf_token() }}';
			var roleUser = '{{ Auth::user()->role_id }}';
			var url = "/pagarWorker";

			var worker_id = idWorker;
			var patiente_id = idPatiente;
			var service_id = idService;
			var sub_service = idSubService;
			var status = status;
			var paid = paid;

			$.ajax({
				type: "post",
				url: url,
				dataType: 'json',
				data: {
					_token: token,
					patiente_id: idPatiente,
					worker_id: worker_id,
					service_id: service_id,
					sub_service_id: idSubService,
					fecha_desde: dateDesde,
					fecha_hasta: dateHasta,
					status: status,
					paid: paid
				},
				success: function(data) {
					var obj = document.getElementById('btn_submit');
					if(data['success'] == true){
						if (obj){
							obj.click(); 
						}
					}		
					let msjOne = 'The billing process was carried out successfully.\n\n';
					let msjTwo = 'El proceso pago fue realizado con exito.';
					alert(msjOne + msjTwo);		
				},
				error: function (error) { 
					console.log(error);
				}
			});
		};
	</script>

	<script>
		function revertirpagar(idPatiente, idWorker, idService, idSubService, status, paid) {
			var dateDesde = $('#desde').val() + ' 00:00:00';
			var dateHasta = $('#hasta').val() + ' 23:59:59';
			var token = '{{ csrf_token() }}';
			var roleUser = '{{ Auth::user()->role_id }}';
			var url = "/revertirPagarWorker";

			var worker_id = idWorker;
			var patiente_id = idPatiente;
			var service_id = idService;
			var sub_service = idSubService;
			var status = status;
			var paid = paid;

			$.ajax({
				type: "post",
				url: url,
				dataType: 'json',
				data: {
					_token: token,
					patiente_id: idPatiente,
					worker_id: worker_id,
					service_id: service_id,
					sub_service_id: idSubService,
					fecha_desde: dateDesde,
					fecha_hasta: dateHasta,
					status: status,
					paid: paid
				},
				success: function(data) {
					var obj = document.getElementById('btn_submit');
					if(data['success'] == true){
						if (obj){
							obj.click(); 
						}
					}		
					let msjOne = 'The billing process was reversed out successfully.\n\n';
					let msjTwo = 'El proceso pago fue revertido con exito.';
					alert(msjOne + msjTwo);		
				},
				error: function (error) { 
					console.log(error);
				}
			});
		};
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