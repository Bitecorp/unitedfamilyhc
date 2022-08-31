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
						@if(strpos(Request::url(), 'generate1099'))
							<div class="col">
								<div class="form-group">
									{!! Form::label('worker_id', 'Worker:') !!}
									<select name='worker_id'id="worker_id" class="form-control" required="true">
										@if (isset($workers) && !empty($workers) && count($workers) >= 1)
											<option data-name-service='' value='' selected>Select Option...</option>
											@foreach($workers->where('role_id', 2) as $key => $worker)
												<option data-name-service='{{ $worker->id }}' value='{{ $worker->id }}' >{{ $worker->first_name }} {{ $worker->last_name }}</option>
											@endforeach
										@endif
									</select>					
								</div>
							</div>
						@elseif(strpos(Request::url(), 'matchAndControl') || strpos(Request::url(), 'manageBillAndPay'))
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
						@endif
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
					@if(strpos(Request::url(), 'generate1099'))
						<div class="row">
							<div class="form-group col-sm-12" id="resulWorMod">

							</div>
						</div>
					@endif
					<!-- Submit Field -->
					<div class="form-group col-sm-12">
						@if(strpos(Request::url(), 'generate1099'))
							<input class="btn btn-primary" type="submit" name="btn_submit_1099" id="btn_submit_1099" value="Search" />
						@else
							<input class="btn btn-primary" type="submit" name="btn_submit" id="btn_submit" value="Search" />
						@endif
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

			@if(strpos(Request::url(), 'generate1099'))
				<div>
					@include('pages.dashboard.dashboard-sub-services-mac-1099')
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
		$('#btn_submit_1099').click(function() {

			$('#resulWorTab').empty();
			$('#resulWorMod').empty();
			
			var url = "/generate1099";
			var worker_id = $('#worker_id').val();
			var service_id = 'all';
			var paid = '1';
			var dateDesde = $('#desde').val() + ' 00:00:00';
			var dateHasta = $('#hasta').val() + ' 23:59:59';
			var token = '{{ csrf_token() }}';
			var roleUser = '{{ Auth::user()->role_id }}';

			var dateDesdeT = new Date(dateDesde).toLocaleString('en-US');
			var dateHastaT = new Date(dateHasta).toLocaleString('en-US');

			if(service_id != '' && paid != '' && dateDesde != '' && dateHasta != ''){
				$.ajax({
					type: "post",
					url: url,
					dataType: 'json',
					data: {
						_token: token,
						worker_id: worker_id,
						service_id: service_id,
						paid: paid,
						desde: dateDesde,
						hasta: dateHasta
					},
					success: function(data) {

						var dataFullW = data['dataW'];
						var Data1099 = data['data1099'];


						if(dataFullW.length < 1){
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

							$('#resulWorTab').empty();
							$('#resulWorMod').empty();
							var htmlResultados = '';
							var htmlResultModal = '';
							var valueInvoice = '';
							var eftorCheck = '';
							var link = '';
							var btnDownload = '';

							for (var i = 0; i < Data1099.length; i++) {//Data1099['independent_contractor']
								//if(index == 0){
									Data1099[i].worker_id = JSON.parse(Data1099[i].worker_id);
							
									if(Data1099[i].independent_contractor.independent_contractor == 1 || Data1099[i].independent_contractor.independent_contractor == '1'){

										if(Data1099[i].invoice_number != '' && typeof Data1099[i].invoice_number != 'undefined' && Data1099[i].invoice_number != null){
											valueInvoice = Data1099[i].invoice_number;
										}

										if(Data1099[i].eftor_check != '' && typeof Data1099[i].eftor_check != 'undefined' && Data1099[i].eftor_check != null){
											eftorCheck = Data1099[i].eftor_check;
										}
										
										if(Data1099[i].file != '' && typeof Data1099[i].file != 'undefined' && Data1099[i].file != null){
											link = Data1099[i].file;
											btnDownload = '<a id="btn_download_'+ Data1099[i].worker_id.id +'" name="btn_download_'+ Data1099[i].worker_id.id +'" target="_blank" class="btn btn-sm btn-primary" href="' + link + '" style="padding: 8.5px; margin-top: 25px; margin-left: 20px;"><i class="fa fa-eye"></i> Show </a>\n';
										}
										
										
										var modal = 
											'<div class="row">\n' +
												'<div class="col-5">\n' +
													'<div class="form-group">\n' +
														'{!! Form::label("eftor_check", "Eft or Check:") !!}\n' +
														'<input type="text" class="form-control" name="eftor_check_'+ Data1099[i].worker_id.id + '" id="eftor_check_'+ Data1099[i].worker_id.id + '" value="' + eftorCheck + '" required>\n' +
													'</div>\n' +
												'</div>\n' +
												'<div class="col-5">\n' +
													'<div class="form-group">\n' +
														'{!! Form::label("invoice_number", "Invoice Number:") !!}\n' +
														'<input type="text" class="form-control" name="invoice_number_'+ Data1099[i].worker_id.id + '" id="invoice_number_'+ Data1099[i].worker_id.id + '" value="' + valueInvoice + '">\n' +
													'</div>\n' +
												'</div>\n' +
												'<div class="col-2">\n' +
													'<button type="button" onclick="generate1099File(' + Data1099[i].worker_id.id + ',' + Data1099[i].id + ')" id="btn_save_'+ Data1099[i].worker_id.id +'" class="btn btn-success" style="margin-top: 25px;" >Generate 1099</button>' + btnDownload
												+ '</div>\n' +
											'</div>\n';

										htmlResultModal = modal;
										$('#resulWorMod').append(htmlResultModal);
									}
								//}

							};

							if(dataFullW.length >= 1){
								for (var i = 0; i < dataFullW.length; i++) {							

									var check =
									'<div class="custom-control custom-switch">\n' +
										'<input type="checkbox"  class="custom-control-input" name="Switch_' + dataFullW[i].id + '" id="Switch_worker_' + dataFullW[i].id + '" checked disabled readonly>\n' +
										'<label class="custom-control-label" for="Switch_worker_' + dataFullW[i].id + '"></label>\n' +
									'</div>\n';

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
												+ check +
											'</td>\n'
										'</tr>\n';

									htmlResultados = dataW;
											
									$('#resulWorTab').append(htmlResultados);
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

			var urlActualMAC = '{{ strpos(Request::url(), "matchAndControl") }}';
			var urlActualBYP = '{{ strpos(Request::url(), "manageBillAndPay") }}';
			
			var url = "/matchAndControl";
			var service_id = $('#service_id').val();
			var paid = $('#paid').val();
			var dateDesde = $('#desde').val() + ' 00:00:00';
			var dateHasta = $('#hasta').val() + ' 23:59:59';
			var token = '{{ csrf_token() }}';
			var roleUser = '{{ Auth::user()->role_id }}';

			var dateDesdeT = new Date(dateDesde).toLocaleString('en-US');
			var dateHastaT = new Date(dateHasta).toLocaleString('en-US');

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
							$('#resulPatTab').empty();
							var htmlResultados = '';

							

							if(dataFullW.length >= 1){
								for (var i = 0; i < dataFullW.length; i++) {

									var check =
									'<div class="custom-control custom-switch">\n' +
										'<input type="checkbox" onclick="'+revertir+'pagar(' + dataFullW[i].patiente_id.id + ',' + dataFullW[i].worker_id.id + ',' + dataFullW[i].service_id.id + ',' + dataFullW[i].sub_service_id.id + ',' + dataFullW[i].status + ',' + dataFullW[i].paid + ');"  class="custom-control-input" name="Switch_' + dataFullW[i].id + '" id="Switch_worker_' + dataFullW[i].id + '" ' + checkCheck + '>\n' +
										'<label class="custom-control-label" for="Switch_worker_' + dataFullW[i].id + '"></label>\n' +
									'</div>\n';

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
												+ check +
											'</td>\n'
										'</tr>\n';

									htmlResultados = dataW;
											
									$('#resulWorTab').append(htmlResultados);
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
		function generate1099File(idWorker, id1099Doc) {
			var dateDesde = $('#desde').val() + ' 00:00:00';
			var dateHasta = $('#hasta').val() + ' 23:59:59';
			var token = '{{ csrf_token() }}';
			var roleUser = '{{ Auth::user()->role_id }}';
			var url = "/generateDocumentOfPai";
			var id1099Document = id1099Doc;

			var worker_id = idWorker;
			var paid = 1;

			var eftor_check = $('#eftor_check_' + worker_id).val();
			var invoice_number = $('#invoice_number_' + worker_id).val();

			var opcion = confirm("Are you sure you want to generate this document?");
			var obj = document.getElementById('btn_submit');
					
			if (opcion == true) {
			
				//setTimeout(
					$.ajax({
						type: "post",
						url: url,
						dataType: 'json',
						data: {
							_token: token,
							worker_id: worker_id,
							fecha_desde: dateDesde,
							fecha_hasta: dateHasta,
							paid: paid,
							document_1099_id: id1099Document,
							eftor_check: eftor_check,
							invoice_number: invoice_number
						},
						success: function(data) {
							var dataT = data['data'];
							$('#btn_download_' + dataT.worker_id).empty().append(
								'<a id="btn_save_'+ dataT.worker_id +'" name="btn_save_'+ dataT.worker_id +'" target="_blank" class="btn btn-sm btn-primary" href="' + dataT.file + '" style="padding: 8.5px; margin-top: 25px; margin-left: 20px;"><i class="fa fa-eye"></i> Show </a>\n' +
							);

							let msjOne = 'The 1099 document was successfully generated.\n\n';
							let msjTwo = 'El documento 1099 fue generado con exito.';
							alert(msjOne + msjTwo);		
						},
						error: function (error) { 
							console.log(error);
						}
					})
				//, 5000);
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