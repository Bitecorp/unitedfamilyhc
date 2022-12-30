@extends('layouts.default')

@push('css')
	<link href="/assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables.net-select-bs4/css/select.bootstrap4.min.css" rel="stylesheet" />
	<link href="../assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
	<script src="../assets/plugins/select2/dist/js/select2.min.js"></script>
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
									<select name='worker_id'id="worker_id" class="default-select2 form-control" required="true">
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
									<select name='service_id'id="service_id" class="default-select2 form-control" required="true">
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
									<select name='paid' id="paid" class="default-select2 form-control" required="true">
										@if(strpos(Request::url(), 'matchAndControl') || strpos(Request::url(), 'manageBillAndPay'))
											<option value='all' selected>All</option>
										@elseif(strpos(Request::url(), 'generate1099'))
											<option value='' selected>Select Option..</option>
										@endif
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
							<div class="form-group col-sm-12" id="extraDataGen1099">

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
	$(".default-select2").select2();
	</script>
	<script>
		var urlDoc = "{{ strpos(Request::url(), 'generate1099') }}";
		var urlBAP = "{{ strpos(Request::url(), 'manageBillAndPay') }}";
		var urlDash = "{{ strpos(Request::url(), 'matchAndControl') }}";
	</script>

	<script>
        $(function () {
            $('#contable-table-wor').DataTable( {
				dom: '<"dataTables_wrapper dt-bootstrap"<"row"<"col-xl-7 d-block d-sm-flex d-xl-block justify-content-center"<"d-block d-lg-inline-flex mr-0 mr-sm-3"l><"d-block d-lg-inline-flex"B>><"col-xl-5 d-flex d-xl-block justify-content-center"fr>>t<"row"<"col-sm-5"i><"col-sm-7"p>>>',
				buttons: [
					
					{ extend: 'csv', className: 'btn-sm' },
					{ extend: 'excel', className: 'btn-sm' },
					{ extend: 'pdf', className: 'btn-sm' },
					{ extend: 'print', className: 'btn-sm' }
				],
                retrieve: true,
                paging: true,
                autoFill: true,
				responsive: true,
            });
        });
    </script>

	<script>
        $(function () {
            $('#contable-table-pat').DataTable( {
				dom: '<"dataTables_wrapper dt-bootstrap"<"row"<"col-xl-7 d-block d-sm-flex d-xl-block justify-content-center"<"d-block d-lg-inline-flex mr-0 mr-sm-3"l><"d-block d-lg-inline-flex"B>><"col-xl-5 d-flex d-xl-block justify-content-center"fr>>t<"row"<"col-sm-5"i><"col-sm-7"p>>>',
				buttons: [
					
					{ extend: 'csv', className: 'btn-sm' },
					{ extend: 'excel', className: 'btn-sm' },
					{ extend: 'pdf', className: 'btn-sm' },
					{ extend: 'print', className: 'btn-sm' }
				],
                retrieve: true,
                paging: true,
                autoFill: true,
				responsive: true,
            });
        });
    </script>

	<script>
		$('#btn_submit_1099').click(function() {
			$('#btn_submit_1099').attr('disabled', 'disabled');
			$('#btn_reset').attr('disabled', 'disabled');
			$('#resulWorTab').empty();
			$('#extraDataGen1099').empty();
			
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
						$('#btn_submit_1099').removeAttr('disabled');
						$('#btn_reset').removeAttr('disabled');
						var dataFullW = data['dataW'];
						var Data1099 = data['data1099'];


						if(dataFullW.length < 1){
							let msjOne = 'There are no matches for the search parameters entered, please enter others.\n\n';
							let msjTwo = 'No existen coincidencias con los parametros de busqueda ingresados , por favor ingrese otros.';
							alert(msjOne + msjTwo);
						}

						dataFullW.forEach(function(valor, indice, array) {
							dataFullW[indice].worker_id = JSON.parse(dataFullW[indice].worker_id);
							dataFullW[indice].patiente_id = JSON.parse(dataFullW[indice].patiente_id);
							dataFullW[indice].service_id = JSON.parse(dataFullW[indice].service_id);
							dataFullW[indice].sub_service_id = JSON.parse(dataFullW[indice].sub_service_id);
						});

							$('#contable-table-wor').DataTable({
								retrieve: true,
								paging: true,
								autoFill: true,
								responsive: true,
							}).clear();
							$('#extraDataGen1099').empty();
							var htmlResultextraDataGen1099 = '';
							var valueInvoice = '';
							var eftorCheck = '';
							var link = '';
							var btnDownload = '';
							var txtBtn1099 = ' Generate';

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
											btnDownload = '<a id="btn_download_'+ Data1099[i].worker_id.id +'" name="btn_download_'+ Data1099[i].worker_id.id +'" target="_blank" class="btn btn-sm btn-primary" href="' + link + '" style="padding: 8.5px; margin-top: 25px; margin-left: 10px;"><i class="fa fa-eye"></i> Show</a>\n';
											txtBtn1099 = ' Update'
										}
										
										
										var addExtraDataGen1099 = 
											'<div class="row">\n' +
												'<div class="col-4">\n' +
													'<div class="form-group">\n' +
														'{!! Form::label("eftor_check", "EFT OR CHECK:") !!}\n' +
														'<input type="text" class="form-control" name="eftor_check_'+ Data1099[i].worker_id.id + '" id="eftor_check_'+ Data1099[i].worker_id.id + '" value="' + eftorCheck + '" required>\n' +
													'</div>\n' +
												'</div>\n' +
												'<div class="col-4 pl-3">\n' +
													'<div class="form-group">\n' +
														'{!! Form::label("invoice_number", "Invoice Number:") !!}\n' +
														'<input type="text" class="form-control" name="invoice_number_'+ Data1099[i].worker_id.id + '" id="invoice_number_'+ Data1099[i].worker_id.id + '" value="' + valueInvoice + '">\n' +
													'</div>\n' +
												'</div>\n' +
												'<div class="col-4 pl-3" id="btnDownloadBtn">\n' +
													'<button type="button" onclick="generate1099File(' + Data1099[i].id + ')" id="btn_save_'+ Data1099[i].worker_id.id +'" class="btn btn-success" style="margin-top: 25px;" ><i class="fa fa-file"></i>' + txtBtn1099 + ' 1099</button>\n' + 
													btnDownload +
												'</div>\n' +
											'</div>\n';

										htmlResultextraDataGen1099 = addExtraDataGen1099;
										$('#extraDataGen1099').append(htmlResultextraDataGen1099);
									}
								//}

							};

							if(dataFullW.length >= 1){
								for (var i = 0; i < dataFullW.length; i++) {		
									
									var explodeIM = dataFullW[i].sub_service_id.name_sub_service.split(' ')[0] ? dataFullW[i].sub_service_id.name_sub_service.split(' ')[0] : '';
									var crediMemo = dataFullW[i].montMemos > 0 ? ' / Credi Memos = ' + parseFloat(dataFullW[i].montMemos) : '';
									var memo = dataFullW[i].patiente_id.first_name + ' ' + dataFullW[i].patiente_id.last_name + ' ' + explodeIM + ' ' + dataFullW[i].time_attention + ' = ' + dataFullW[i].unid_pay_worker + crediMemo;
									var valToPai = parseFloat(parseFloat(dataFullW[i].mont_pay) - parseFloat(dataFullW[i].montMemos)).toFixed(2);

									var check =
									'<div class="custom-control custom-switch">\n' +
										'<input type="checkbox"  class="custom-control-input" name="Switch_worker_' + dataFullW[i].id + '" id="Switch_worker_' + dataFullW[i].id + '" checked disabled readonly>\n' +
										'<label class="custom-control-label" for="Switch_worker_' + dataFullW[i].id + '"></label>\n' +
									'</div>\n';


									$('#contable-table-wor').DataTable({
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
											[0, 'asc']
										]
									}).row.add([
										dataFullW[i].patiente_id.first_name + ' ' + dataFullW[i].patiente_id.last_name, 
										dataFullW[i].service_id.name_service + ' - ' + dataFullW[i].sub_service_id.name_sub_service, 
										dataFullW[i].worker_id.first_name + ' ' + dataFullW[i].worker_id.last_name,
										dataFullW[i].unidad_time_worker + ' ' + dataFullW[i].unidad_type_worker + ' - ' + dataFullW[i].unit_value_worker + '$ (USD)',
										dataFullW[i].time_attention + ' = ' + dataFullW[i].unid_pay_worker,
										memo,
										valToPai + '$ (USD)',
										check
									]).draw(null, false);
								};
							}
						
					},
					error: function (error) {
						$('#btn_submit_1099').removeAttr('disabled');
						$('#btn_reset').removeAttr('disabled');
						console.log(error);
					}
				});	
			}else{
				$('#btn_submit_1099').removeAttr('disabled');
				$('#btn_reset').removeAttr('disabled');
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

				location.reload();
			});
		});
	</script>

    <script>
		$('#btn_submit').click(function() {

			$('#btn_submit').attr('disabled', 'disabled');
			$('#btn_reset').attr('disabled', 'disabled');

			$('#resulWor').empty();
			$('#resulPat').empty();
			$('#resulWorTab').empty();
			$('#extraDataGen1099').empty();
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

			var dateDesdeTT = $('#desde').val().split('-');
			var dateHastaTT = $('#hasta').val().split('-');

			var newDesde = dateDesdeTT[2] + '_' + dateDesdeTT[1] + '_' + dateDesdeTT[0];
			var newHasta = dateHastaTT[2] + '_' + dateHastaTT[1] + '_' + dateHastaTT[0];

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
						$('#btn_submit').removeAttr('disabled');
						$('#btn_reset').removeAttr('disabled');	

						var htmlResultados = '';
						var colBG = '';
						var checkCheck = '';
						var block = '';
						var revertir = '';			
						var btnSendXml = '';
						var hiddenBtnXml = '';
						var nameFile = '';
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

							$('#contable-table-pat').DataTable({
								dom: '<"dataTables_wrapper dt-bootstrap"<"row"<"col-xl-7 d-block d-sm-flex d-xl-block justify-content-center"<"d-block d-lg-inline-flex mr-0 mr-sm-3"l><"d-block d-lg-inline-flex"B>><"col-xl-5 d-flex d-xl-block justify-content-center"fr>>t<"row"<"col-sm-5"i><"col-sm-7"p>>>',
								buttons: [
									
									{ extend: 'csv', className: 'btn-sm' },
									{ extend: 'excel', className: 'btn-sm' },
									{ extend: 'pdf', className: 'btn-sm' },
									{ extend: 'print', className: 'btn-sm' }
								],
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
							}).clear();	

							$('#contable-table-wor').DataTable({
								dom: '<"dataTables_wrapper dt-bootstrap"<"row"<"col-xl-7 d-block d-sm-flex d-xl-block justify-content-center"<"d-block d-lg-inline-flex mr-0 mr-sm-3"l><"d-block d-lg-inline-flex"B>><"col-xl-5 d-flex d-xl-block justify-content-center"fr>>t<"row"<"col-sm-5"i><"col-sm-7"p>>>',
								buttons: [
									
									{ extend: 'csv', className: 'btn-sm' },
									{ extend: 'excel', className: 'btn-sm' },
									{ extend: 'pdf', className: 'btn-sm' },
									{ extend: 'print', className: 'btn-sm' }
								],
								retrieve: true,
								paging: true,
								autoFill: true,
								responsive: true,
								columnDefs: [
									{ 
										orderable: false, 
										targets: 0
									}
								]
							}).clear();
							
							if(dataFullP.length >= 1){
								for (var i = 0; i < dataFullP.length; i++) {

									checkCheck = dataFullP[i].collected == true ? 'checked' : '';
									colBG = dataFullP[i].collected == true ? 'bg-teal' : 'bg-red';
									block = dataFullP[i].collected == true ? ' disabled readonly' : '';
									revertir = dataFullP[i].collected == true ? 'revertir' : '';

									var check =
									'<div class="custom-control custom-switch">\n' +
										'<input type="checkbox" onclick="'+revertir+'cobrar(' + dataFullP[i].worker_id.id + ',' + dataFullP[i].patiente_id.id + ',' + dataFullP[i].service_id.id + ',' + dataFullP[i].sub_service_id.id + ');"  class="custom-control-input" name="Switch_patiente_' + dataFullP[i].id + '" id="Switch_patiente' + dataFullP[i].id + '" ' + checkCheck + '>\n' +
										'<label class="custom-control-label" for="Switch_patiente' + dataFullP[i].id + '"></label>\n' +
									'</div>\n';

									$('#contable-table-pat').DataTable({
										dom: '<"dataTables_wrapper dt-bootstrap"<"row"<"col-xl-7 d-block d-sm-flex d-xl-block justify-content-center"<"d-block d-lg-inline-flex mr-0 mr-sm-3"l><"d-block d-lg-inline-flex"B>><"col-xl-5 d-flex d-xl-block justify-content-center"fr>>t<"row"<"col-sm-5"i><"col-sm-7"p>>>',
										buttons: [
											
											{ extend: 'csv', className: 'btn-sm' },
											{ extend: 'excel', className: 'btn-sm' },
											{ extend: 'pdf', className: 'btn-sm' },
											{ extend: 'print', className: 'btn-sm' }
										],
										retrieve: true,
										paging: true,
										autoFill: true,
										responsive: true,
										columnDefs: [
											{ 
												orderable: false, 
												targets: 0
											}
										]
									}).row.add([
										dataFullP[i].patiente_id.first_name + ' ' + dataFullP[i].patiente_id.last_name, 
										dataFullP[i].service_id.name_service + ' - ' + dataFullP[i].sub_service_id.name_sub_service, 
										dataFullP[i].unidad_time_worker + ' ' + dataFullP[i].unidad_type_worker + ' - ' + dataFullP[i].unit_value_patiente + '$ (USD)',
										dataFullP[i].time_attention + ' = ' + dataFullP[i].unid_pay_worker,
										dataFullP[i].mont_cob + '$ (USD)',
										check
									]).draw(null, false);
								};
							}

							if(dataFullW.length >= 1){
								for (var i = 0; i < dataFullW.length; i++) {

									checkCheck = dataFullW[i].paid == true ? 'checked' : '';
									colBG = dataFullW[i].paid == true ? 'bg-teal' : 'bg-red';
									block = dataFullW[i].paid == true ? ' disabled readonly' : '';
									revertir = dataFullW[i].paid == true ? 'revertir' : '';
									hiddenBtnXml = dataFullW[i].paid == true ? '' : 'hidden';
									nameFile = dataFullW[i].worker_id.first_name + '_' + dataFullW[i].worker_id.last_name + '_' + dataFullW[i].sub_service_id.name_sub_service.split(" ").join("_") + '_from_' + newDesde + '_to_' + newHasta + '.zip';
									linkDownload = '{{ asset("filesXml") }}/' + nameFile.split(" ").join("_");

									btnSendXml = '<a type="button" ' + hiddenBtnXml + ' href="' + linkDownload + '"  download="' + nameFile.split(" ").join("_") + '" id="btn_send_xml_'+ dataFullW[i].id +'" class="btn btn-success" style="margin-top: 5px;" ><i class="fa fa-download"></i> Download Xml </a>\n';

									var hiddenBtnMemo = isset(dataFullW[i].credi_memos) ? 'hidden' : '';
									btnRedirectAddMemo = '<button' + hiddenBtnMemo + 'onclick="redirectAddMemoForPai(' + dataFullW[i].worker_id.id + ',' + dataFullW[i].patiente_id.id + ',' + dataFullW[i].service_id.id + ',' + dataFullW[i].sub_service_id.id + ',' + ((parseFloat(dataFullW[i].mont_pay) + 0.01)).toString() + ');" id="redirectAddMemoForPai_'+ dataFullW[i].id +'" name="redirectAddMemoForPai_'+ dataFullW[i].id +'" type="button" class="btn btn-success" style="margin-top: 5px;">Memo</button>\n'

									var check =
									'<div class="custom-control custom-switch">\n' +
										'<input type="checkbox" onclick="'+revertir+'pagar(' + dataFullW[i].worker_id.id + ',' + dataFullW[i].patiente_id.id + ',' + dataFullW[i].service_id.id + ',' + dataFullW[i].sub_service_id.id + ',' + dataFullW[i].id + ');"  class="custom-control-input" name="Switch_worker_' + dataFullW[i].id + '" id="Switch_worker_' + dataFullW[i].id + '" ' + checkCheck + '>\n' +
										'<label class="custom-control-label" for="Switch_worker_' + dataFullW[i].id + '"></label>\n' +
									'</div>\n';

									var explodeIM = dataFullW[i].sub_service_id.name_sub_service.split(' ')[0] ? dataFullW[i].sub_service_id.name_sub_service.split(' ')[0] : '';
									var crediMemo = dataFullW[i].montMemos > 0 ? ' / Credi Memos = ' + parseFloat(dataFullW[i].montMemos) : '';
									var memo = dataFullW[i].patiente_id.first_name + ' ' + dataFullW[i].patiente_id.last_name + ' ' + explodeIM + ' ' + dataFullW[i].time_attention + ' = ' + dataFullW[i].unid_pay_worker + crediMemo;
									var valToPai = parseFloat(parseFloat(dataFullW[i].mont_pay) - parseFloat(dataFullW[i].montMemos)).toFixed(2);

									dataFullW[i].sub_service_id.name_sub_service.split(' ')[0]
									$('#contable-table-wor').DataTable({
										dom: '<"dataTables_wrapper dt-bootstrap"<"row"<"col-xl-7 d-block d-sm-flex d-xl-block justify-content-center"<"d-block d-lg-inline-flex mr-0 mr-sm-3"l><"d-block d-lg-inline-flex"B>><"col-xl-5 d-flex d-xl-block justify-content-center"fr>>t<"row"<"col-sm-5"i><"col-sm-7"p>>>',
										buttons: [
											
											{ extend: 'csv', className: 'btn-sm' },
											{ extend: 'excel', className: 'btn-sm' },
											{ extend: 'pdf', className: 'btn-sm' },
											{ extend: 'print', className: 'btn-sm' }
										],
										retrieve: true,
										paging: true,
										autoFill: true,
										responsive: true,
										columnDefs: [
											{ 
												orderable: false, 
												targets: 0
											}
										]
									}).row.add([
										dataFullW[i].worker_id.first_name + ' ' + dataFullW[i].worker_id.last_name,
										dataFullW[i].service_id.name_service + ' - ' + dataFullW[i].sub_service_id.name_sub_service, 
										dataFullW[i].patiente_id.first_name + ' ' + dataFullW[i].patiente_id.last_name, 
										dataFullW[i].unidad_time_worker + ' ' + dataFullW[i].unidad_type_worker + ' - ' + dataFullW[i].unit_value_worker + '$ (USD)',
										dataFullW[i].time_attention + ' = ' + dataFullW[i].unid_pay_worker,
										memo,
										valToPai + '$ (USD)',
										check + btnRedirectAddMemo + btnSendXml
									]).draw(null, false);
								};
							}

						}else if(urlActualMAC){

							$('#resulWor').empty();
							$('#resulPat').empty();

							if(dataFullW.length >= 1){
								for (var i = 0; i < dataFullW.length; i++) {

									checkCheck = dataFullW[i].paid == true ? 'checked' : '';
									colBG = dataFullW[i].paid == true ? 'bg-teal' : 'bg-red';
									block = dataFullW[i].paid == true ? ' disabled readonly' : '';
									revertir = dataFullW[i].paid == true ? 'revertir' : '';				
									
										var dataW = 
											'<div class="col-xl-4 col-md-4">\n' +
												'<div class="widget widget-stats ' + colBG + '">\n' +
													'<div class="stats-icon stats-icon-lg"><i class="fa fa-clock fa-fw"></i></div>\n' +
													'<div class="stats-info">\n' +
														'<p style="font-size: 100%">' + dataFullW[i].worker_id.first_name + ' ' + dataFullW[i].worker_id.last_name + '</p>\n' +
														'<p style="font-size: 100%">' + dataFullW[i].sub_service_id.name_sub_service + '</p>\n' +
														'<p style="font-size: 100%">Hours: <span style="font-size: 100%">' + dataFullW[i].time_attention + '</span></h4>\n' +
														'<p style="font-size: 225%"><span style="font-size: 225%">$ ' + dataFullW[i].mont_pay  + '</span></h4>\n' +												
													'</div>\n' +
												'</div>\n' +
											'</div>\n';
											
									htmlResultados = dataW;
											
									$('#resulWor').append(htmlResultados);
								};
							}

							if(dataFullP.length >= 1){
								for (var i = 0; i < dataFullP.length; i++) {	

									checkCheck = dataFullP[i].collected == true ? 'checked' : '';
									colBG = dataFullP[i].collected == true ? 'bg-teal' : 'bg-red';
									block = dataFullP[i].collected == true ? ' disabled readonly' : '';
									revertir = dataFullP[i].collected == true ? 'revertir' : '';

										var dataP = 
											'<div class="col-xl-4 col-md-4">\n' +
												'<div class="widget widget-stats ' + colBG + '">\n' +
													'<div class="stats-icon stats-icon-lg"><i class="fa fa-clock fa-fw"></i></div>\n' +
													'<div class="stats-info">\n' +
														'<p style="font-size: 100%">'+ dataFullP[i].patiente_id.first_name + ' ' + dataFullP[i].patiente_id.last_name + '</p>\n' +
														'<p style="font-size: 100%">' + dataFullP[i].sub_service_id.name_sub_service + '</p>\n' +
														'<p style="font-size: 100%">Hours: <span style="font-size: 100%">' + dataFullP[i].time_attention + '</span></p>\n' +
														'<p style="font-size: 225%"><span style="font-size: 225%">$ ' + dataFullP[i].mont_cob + '</span></p>\n' +
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
						$('#btn_submit').removeAttr('disabled');
						$('#btn_reset').removeAttr('disabled');	
						console.log(error);
					}
				});	
			}else{
				$('#btn_submit').removeAttr('disabled');
				$('#btn_reset').removeAttr('disabled');	
				let msjOne = 'You must fill in all the fields for a more accurate search.\n\n';
				let msjTwo = 'Debe llenar todos los campos para una busqueda mas precisa.';
				alert(msjOne + msjTwo);
			}
		});
	</script>
	<script type="text/javascript">
		function redirectAddMemoForPai(idWorker, idPatiente, idService, idSubservice, amountBase) {
			var dateDesde = $('#desde').val() != '' ? $('#desde').val() + ' 00:00:00' : '{{ data_previa_month_day_first() }}';
			var dateHasta = $('#hasta').val() != '' ? $('#hasta').val() + ' 23:59:59' : '{{ data_previa_month_day_last() }}';
			var serviceFilter = $('#service_id').val();
			var paidFilter = $('#paid').val();
			var worker_id = idWorker;
			var patiente_id = idPatiente;
			var service_id = idService;
			var sub_service_id = idSubservice;
			var token = '{{ csrf_token() }}';
			var datosAnid = worker_id + '/' + patiente_id + '/' + service_id + '/' + sub_service_id;
			var amountBase = amountBase.toString();

			localStorage.setItem('dateDesde', dateDesde.split(' ')[0]);
			localStorage.setItem('dateHasta', dateHasta.split(' ')[0]);
			localStorage.setItem('amountBase', amountBase.toString());

			let filters = new Array(serviceFilter, paidFilter, dateDesde.split(' ')[0], dateHasta.split(' ')[0]);

			var qs = dateDesde.split(' ')[0] + ',' + dateHasta.split(' ')[0] + ',' + amountBase;
			var qse = btoa(qs);

			var url = '/reasonMemo/addMemoForPai/';

			var urlTotal = url + datosAnid + '?token=' + qse + '&r=1';

			$.ajax({
				type: "get",
				url: url,
				dataType: 'json',
				data: {
					_token: token,
					desde: dateDesde,
					hasta: dateHasta,
					worker_id: worker_id,
					patiente_id: patiente_id,
					service_id: service_id,
					sub_service_id: sub_service_id
				},
				success: function(data) {
					if(data['success'] == true){
						window.location.href = urlTotal;
						console.log(true);
					}
				},
				error: function (error) { 
					console.log(error);
				}
			});
		};
	</script>
	<script type="text/javascript">
		function generate1099File(id1099Doc) {
			var dateDesde = $('#desde').val() + ' 00:00:00';
			var dateHasta = $('#hasta').val() + ' 23:59:59';
			var token = '{{ csrf_token() }}';
			var roleUser = '{{ Auth::user()->role_id }}';
			var url = "/generateDocumentOfPai";
			var id1099Document = id1099Doc;

			var worker_id = $('#worker_id').val();
			var paid = 1;

			var eftor_check = $('#eftor_check_' + worker_id).val();
			var invoice_number = $('#invoice_number_' + worker_id).val();

			var opcion = confirm("Are you sure you want to generate this document?");
			var obj = document.getElementById('btn_submit_1099');
					
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
							if (obj){
								obj.click();
							}},
						error: function (error) { 
							console.log(error);
						}
					})
				//, 5000);
			}

		};
	</script>

	<script>
		function cobrar(idWorker, idPatiente, idService, idSubservice) {
			var dateDesde = $('#desde').val() != '' ? $('#desde').val() + ' 00:00:00' : '{{ data_previa_month_day_first() }}';
			var dateHasta = $('#hasta').val() != '' ? $('#hasta').val() + ' 23:59:59' : '{{ data_previa_month_day_last() }}';
			var worker_id = idWorker;
			var patiente_id = idPatiente;
			var service_id = idService;
			var sub_service_id = idSubservice;
			var token = '{{ csrf_token() }}';
			var roleUser = '{{ Auth::user()->role_id }}';
			var url = "/cobrarPatiente";

			$.ajax({
				type: "post",
				url: url,
				dataType: 'json',
				data: {
					_token: token,
					desde: dateDesde,
					hasta: dateHasta,
					worker_id: worker_id,
					patiente_id: patiente_id,
					service_id: service_id,
					sub_service_id: sub_service_id,
					collected: 0
				},
				success: function(data) {
					var obj = document.getElementById('btn_submit');
					if(data['success'] == true){
						//if($('#desde').val() == '' && $('#hasta').val() == ''){
							//location.reload();
						//}else if(obj){
							//obj.click(); 
						//}
						let msjOne = 'The payment process was carried out successfully.\n\n';
						let msjTwo = 'El proceso cobro fue realizado con exito.';
						alert(msjOne + msjTwo);
					}
				},
				error: function (error) { 
					console.log(error);
				}
			});
		};
	</script>

	<script>
		function revertircobrar(idWorker, idPatiente, idService, idSubservice) {
			var dateDesde = $('#desde').val() != '' ? $('#desde').val() + ' 00:00:00' : '{{ data_previa_month_day_first() }}';
			var dateHasta = $('#hasta').val() != '' ? $('#hasta').val() + ' 23:59:59' : '{{ data_previa_month_day_last() }}';
			var worker_id = idWorker;
			var patiente_id = idPatiente;
			var service_id = idService;
			var sub_service_id = idSubservice;
			var token = '{{ csrf_token() }}';
			var roleUser = '{{ Auth::user()->role_id }}';
			var url = "/revertirCobrarPatiente";

			$.ajax({
				type: "post",
				url: url,
				dataType: 'json',
				data: {
					_token: token,
					desde: dateDesde,
					hasta: dateHasta,
					worker_id: worker_id,
					patiente_id: patiente_id,
					service_id: service_id,
					sub_service_id: sub_service_id,
					collected: 1
				},
				success: function(data) {
					var obj = document.getElementById('btn_submit');
					if(data['success'] == true){
						//if($('#desde').val() == '' && $('#hasta').val() == ''){
							//location.reload();
						//}else if(obj){
							//obj.click(); 
						//}

						let msjOne = 'The payment process was reversed out successfully.\n\n';
						let msjTwo = 'El proceso cobro fue revertido con exito.';
						alert(msjOne + msjTwo);
					}
				},
				error: function (error) { 
					console.log(error);
				}
			});
		};
	</script>

	<script>
		function pagar(idWorker, idPatiente, idService, idSubservice, id) {
			var dateDesde = $('#desde').val() != '' ? $('#desde').val() + ' 00:00:00' : '{{ data_previa_month_day_first() }}';
			var dateHasta = $('#hasta').val() != '' ? $('#hasta').val() + ' 23:59:59' : '{{ data_previa_month_day_last() }}';
			var worker_id = idWorker;
			var patiente_id = idPatiente;
			var service_id = idService;
			var sub_service_id = idSubservice;
			var token = '{{ csrf_token() }}';
			var roleUser = '{{ Auth::user()->role_id }}';
			var url = "/pagarWorker";
			var id = id;
			var btnXmlid = 'btn_send_xml_' + id;
			var swichPagar = '#Switch_worker_' + id;
			var newFunction = 'revertirpagar(' + worker_id + ',' + patiente_id + ',' + service_id + ',' + sub_service_id + ',' + id +');';

			$.ajax({
				type: "post",
				url: url,
				dataType: 'json',
				data: {
					_token: token,
					desde: dateDesde,
					hasta: dateHasta,
					worker_id: worker_id,
					patiente_id: patiente_id,
					service_id: service_id,
					sub_service_id: sub_service_id,
					paid: 0
				},
				success: function(data) {
					var obj = document.getElementById('btn_submit');
					if(data['success'] == true){
						//if($('#desde').val() == '' && $('#hasta').val() == ''){
							//location.reload();
						//}else if(obj){
							//obj.click(); 
						//}$('#btn_submit_1099').attr('disabled', 'disabled');
						document.getElementById('redirectAddMemoForPai_' + id).setAttribute('hidden', 'true');
						$(swichPagar).removeAttr('onclick');
						$(swichPagar).attr('onclick', newFunction);
						document.getElementById(btnXmlid).removeAttribute('hidden');
						//$(btnXmlid).removeAttr('hidden');	

						let msjOne = 'The billing process was carried out successfully.\n\n';
						let msjTwo = 'El proceso pago fue realizado con exito.';
						alert(msjOne + msjTwo);
					}
						
				},
				error: function (error) { 
					console.log(error);
				}
			});
		};
	</script>
	
	<script>
		function revertirpagar(idWorker, idPatiente, idService, idSubservice, id) {
			var dateDesde = $('#desde').val() != '' ? $('#desde').val() + ' 00:00:00' : '{{ data_previa_month_day_first() }}';
			var dateHasta = $('#hasta').val() != '' ? $('#hasta').val() + ' 23:59:59' : '{{ data_previa_month_day_last() }}';
			var worker_id = idWorker;
			var patiente_id = idPatiente;
			var service_id = idService;
			var sub_service_id = idSubservice;
			var token = '{{ csrf_token() }}';
			var roleUser = '{{ Auth::user()->role_id }}';
			var url = "/revertirPagarWorker";
			var id = id;
			var btnXmlid = 'btn_send_xml_' + id;
			var swichPagar = '#Switch_worker_' + id;
			var newFunction = 'pagar(' + worker_id + ',' + patiente_id + ',' + service_id + ',' + sub_service_id + ',' + id +');';

			$.ajax({
				type: "post",
				url: url,
				dataType: 'json',
				data: {
					_token: token,
					desde: dateDesde,
					hasta: dateHasta,
					worker_id: worker_id,
					patiente_id: patiente_id,
					service_id: service_id,
					sub_service_id: sub_service_id,
					paid: 1
				},
				success: function(data) {
					var obj = document.getElementById('btn_submit');
					if(data['success'] == true){
						//if($('#desde').val() == '' && $('#hasta').val() == ''){
							//location.reload();
						//}else if(obj){
							//obj.click(); 
						//}
						$('#redirectAddMemoForPai_' + id).removeAttr('hidden');
						$(swichPagar).removeAttr('onclick');
						$(swichPagar).attr('onclick', newFunction);
						document.getElementById(btnXmlid).setAttribute('hidden', 'true');
						//$(btnXmlid).attr('hidden',true);

						let msjOne = 'The billing process was reversed out successfully.\n\n';
						let msjTwo = 'El proceso pago fue revertido con exito.';
						alert(msjOne + msjTwo);	
					}	
				},
				error: function (error) { 
					console.log(error);
				}
			});
		};
	</script>

<script>
	function generateZipXmls(idWorker, idPatiente, idService, idSubservice) {
		var dateDesde = $('#desde').val() != '' ? $('#desde').val() + ' 00:00:00' : '{{ data_previa_month_day_first() }}';
		var dateHasta = $('#hasta').val() != '' ? $('#hasta').val() + ' 23:59:59' : '{{ data_previa_month_day_last() }}';
		var worker_id = idWorker;
		var patiente_id = idPatiente;
		var service_id = idService;
		var sub_service_id = idSubservice;
		var token = '{{ csrf_token() }}';
		var url = "/downloadXmlZip";

		$.ajax({
			type: "post",
			url: url,
			dataType: 'json',
			data: {
				_token: token,
				desde: dateDesde,
				hasta: dateHasta,
				worker_id: worker_id,
				patiente_id: patiente_id,
				service_id: service_id,
				sub_service_id: sub_service_id,
				collected: 1
			},
			success: function(data) {
				event.preventDefault();	
			},
			error: function (error) { 
				console.log(error);
			}
		});
	};
</script>
<script type="text/javascript">
    function DownloadFromUrl(fileName) {
		var localURL = '{{ asset("filesXml/") }}';
		var fileURL = localURL + fileName;
		console.log(localURL, fileURL);

		var link = document.createElement('a');
		link.href = fileURL;
		link.download = fileName;
		document.body.appendChild(link);
		link.click();
		document.body.removeChild(link);

		console.log('sali');
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