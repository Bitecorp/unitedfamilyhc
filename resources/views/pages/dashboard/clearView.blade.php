@extends('layouts.default')

@section('title', 'Dashboard V')

@push('css')
	<link href="/assets/plugins/jvectormap-next/jquery-jvectormap.css" rel="stylesheet" />
	<link href="/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css" rel="stylesheet" />
	<link href="/assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />

	<style>
		.BG_Class {
			background: inherit;
			background-color:transparent;
		}
	</style>
@endpush

@section('content')


<div class="panel panel-inverse">
	<div class="panel-heading">
        <h4 class="panel-title"></h4>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <!-- <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a> -->
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
			<div class="col">
				<!-- Role Id Field -->
				<div class="form-group">
					{!! Form::label('service_id', 'Service:') !!}
					<select name='service_id'id="service_id" class="form-control">
						@if (isset($services) && !empty($services) && count($services) >= 1)
							<option data-name-service='' value='' selected>Select Option..</option>
							@foreach($services as $service)
								<option data-name-service='{{ $service->name_service }}' value='{{ $service->id }}' >{{ $service->name_service }}</option>
							@endforeach
						@endif
					</select>					
				</div>
			</div>
			<div class="col">
				<!-- Role Id Field -->
				<div class="form-group">
					{!! Form::label('patiente_id', 'Patiente:') !!}
					<select name='patiente_id' id="patiente_id" class="form-control">
						<option value='' selected>Select Service Option..</option>
					</select>
				</div>
			</div>
		</div>
		<!-- Submit Field -->
		<div class="form-group col-sm-12">
			<input class="btn btn-primary" type="submit" name="btn_submit" id="btn_submit" value="Search" disabled/>
			<input class="btn btn-secondary" type="reset" name="btn_reset" id="btn_reset" value="Clear" />
		</div>
    </div>
</div>

<div id="dashboardActives" {{ isset($dataSearch) && !empty($dataSearch) ? '' : 'hidden'}}>
	@include('pages.dashboard.dashboard-sub-services-actives')
</div>

<div id="dashboard">
	@include('pages.dashboard.dashboard-sub-services')
</div>

@endsection


@push('scripts')
    <script>
		$("#service_id").change(function() {
			$("#service_id option:selected").each(function() {
				var url = "/searchPatienteService";
				var service_id = $('#service_id').val();
				var token = '{{ csrf_token() }}';

				$('#patiente_id').empty().append('<option value="" selected="selected">Select Option..</option>');
				
				$.ajax({
					type: "post",
					url: url,
					dataType: 'json',
					data: {
						_token: token,
						service_id: service_id
					},
					success: function(data) {
						//$('#patiente_id').removeAttr('disabled');
						//$('#service_id').attr('disabled', 'disabled');
						$('#patiente_id').attr('required', true);
						var patientes = data['patientes'];


						$.each(patientes, function (ind, elem) {
							$('#patiente_id').append($('<option />', {
								text: elem['first_name'] + ' ' + elem['last_name'],
								value: elem['id'],
							}));
						});
					},
					error: function (error) { 
						console.log(error);
					}
				});				
			});

		});

		$("#patiente_id").change(function() {
			$("#patiente_id option:selected").each(function() {
				$('#btn_submit').removeAttr('disabled');	
			});
		});
	</script>

	

	<script>
		$('#btn_submit').click(function() {

			var url = '/searchSubServicesPatiente';

			var service_id = $('#service_id').val();
			var patiente_id = $('#patiente_id').val();

			//if(patiente_id != '' && patiente_id != null && patiente_id != 'undefined'){
				//$('#patiente_id').attr('disabled', 'disabled');
			//}
			var token = '{{ csrf_token() }}';

			var nameService = $('#service_id').find(':selected').data('name-service');
			
			$.ajax({
				type: "post",
				url: url,
				dataType: 'json',
				data: {
					_token: token,
					service_id: service_id,
					patiente_id: patiente_id
				},
				success: function(data) {
					
					$('#service_id').val('');
					$('#patiente_id').empty().append('<option value="" selected>Select Service Option..</option>');
					$('#btn_submit').attr('disabled', 'disabled');

					var dataTotal = data['subServices'];
					var htmlResultados = '';
					var scriptResultados = '';
					var namePatiente = data['dataPatiente'].first_name + ' ' + data['dataPatiente'].last_name;

					for (var i = 0; i < dataTotal.length; i++) {
							
						htmlResultados =
							'<div class="col-xl-12 col-md-12">\n' +
								'<div id="bg_color_' + dataTotal[i].id + '" class="widget widget-stats bg-blue">\n' +
									'<div class="stats-icon stats-icon-lg"><i class="fa fa-clock fa-fw"></i></div>\n' +
									'<div class="stats-info">\n' +
										'<h4 id="titleSubService_' + dataTotal[i].id + '">' + nameService + ' - ' + dataTotal[i].name_sub_service + ' - ' + namePatiente + '</h4>\n' +
										
										'<div class="crono_wrapper">\n' +
											'<h2 id="crono_' + dataTotal[i].id + '"></h2>\n' +
											'<input type="button" value="Empezar" id="boton_' + dataTotal[i].id + '" onclick="empezarDetener_' + dataTotal[i].id + '(this);" hidden>\n' +
										'</div>\n' +
									
									'</div>\n' +
									'<div class="stats-link" id="btn_onclick_' + dataTotal[i].id + '">\n' +
										'<a id="btn_run_' + dataTotal[i].id + '" name="btn_run_' + dataTotal[i].id + '" data-status="0" onclick="runTime(' + data['dataPatiente'].id + ',' + dataTotal[i].service_id + ',' + dataTotal[i].id + ');">Start Time<i class="fa fa-arrow-alt-circle-right"></i></a>\n' +
									'</div>\n' +
								'</div>\n' +
							'</div>\n';
						$('#resultados').append(htmlResultados);

						scriptResultados = '<script type="text/javascript">\n'+
							'var inicio_' + dataTotal[i].id + ' = 0;\n'+
        					'var timeout_' + dataTotal[i].id + ' = 0;\n'+

							'function empezarDetener_' + dataTotal[i].id + '(elemento){\n'+
								'if(timeout_' + dataTotal[i].id + ' == 0){\n'+
									
									'elemento.value = "Detener";\n'+
							
									'inicio_' + dataTotal[i].id + ' = new Date().getTime();\n'+
							
									'localStorage.setItem("inicio_' + dataTotal[i].id + '", inicio_' + dataTotal[i].id + ');\n'+
							
									'funcionando_' + dataTotal[i].id + '();\n'+
								'}else{\n'+
							
									'elemento.value = "Empezar";\n'+
									'clearTimeout(timeout_' + dataTotal[i].id + ');\n'+
							
									'localStorage.removeItem("inicio_' + dataTotal[i].id + '");\n'+
									'timeout_' + dataTotal[i].id + ' = 0;\n'+
								'}\n'+
							'}\n'+

							'function funcionando_' + dataTotal[i].id + '(){\n'+

								'var actual_' + dataTotal[i].id + ' = new Date().getTime();\n'+
								'var diff_' + dataTotal[i].id + ' = new Date(actual_' + dataTotal[i].id + '-inicio_' + dataTotal[i].id + ');\n'+
								'var result_' + dataTotal[i].id + ' = LeadingZero_' + dataTotal[i].id + '(diff_' + dataTotal[i].id + '.getUTCHours())+":"+LeadingZero_' + dataTotal[i].id + '(diff_' + dataTotal[i].id + '.getUTCMinutes())+":"+LeadingZero_' + dataTotal[i].id + '(diff_' + dataTotal[i].id + '.getUTCSeconds());\n'+
								'$("#crono_' + dataTotal[i].id + '").text(result_' + dataTotal[i].id + ');\n'+
								'timeout_' + dataTotal[i].id + ' = setTimeout("funcionando_' + dataTotal[i].id + '()",1000);\n'+
							'}\n'+
							

							'function LeadingZero_' + dataTotal[i].id + '(Time_' + dataTotal[i].id + '){\n'+
								'return (Time_' + dataTotal[i].id + ' < 10) ? "0" + Time_' + dataTotal[i].id + ' : + Time_' + dataTotal[i].id + ';\n'+
							'}\n'+
							
							'window.onload = function(){\n'+
								'if(localStorage.getItem("inicio_' + dataTotal[i].id + '") != null){\n'+
									'inicio_' + dataTotal[i].id + ' = localStorage.getItem("inicio_' + dataTotal[i].id + '");\n'+
									'document.getElementById("boton_' + dataTotal[i].id + '").value = "Detener";\n'+
									'funcionando_' + dataTotal[i].id + '();\n'+
								'}\n'+
							'}\n'+
						'<\/script>\n';
						
						$('#resultados').append(scriptResultados);
						

					};
				},
				error: function (error) { 
					console.log(error);
				}
			});
		});
	</script>

	

	<script>
		$(function() {
			$('#btn_reset').click(function() {
				var subServicesActives = localStorage.getItem('subServicesActives');
				let msjOne = 'If you have active services please close them before starting another visit.\n\n';
				let msjTwo = 'Posee servicios activos por favor cierrelos antes de iniciar otra visita.';

				if(typeof subServicesActives != 'undefined' && subServicesActives != null && subServicesActives == 1){
					alert(msjOne + msjTwo);
				}else{
					$('#service_id').val('')
					$('#patiente_id').empty().append('<option value="" selected>Select Service Option..</option>');
					$('#btn_submit').attr('disabled', 'disabled');
				}
			});
		});
	</script>

	<script>
		function runTime(patiente, service, subService) {
			GeoPosition();

			var url = '/registerAttentions';

			var idUser = '{{ Auth::user()->id }}';
			var service_id = service;
			var patiente_id = patiente;
			var idSubService = subService;
			var long = localStorage.getItem('long');
			var lat = localStorage.getItem('lat');
			var token = '{{ csrf_token() }}';

			var subServicesActives = localStorage.getItem('subServicesActives');

			var valueStatus = $('#btn_run_' + subService).data('status');

			$.ajax({
				type: "post",
				url: url,
				dataType: 'json',
				data: {
					_token: token,
					worker_id: idUser,
					service_id: service_id,
					patiente_id: patiente_id,
					sub_service_id: idSubService,
					lat: lat,
					long: long
				},
				success: function(data) {
					var dataTotal = data['data'];

					if(dataTotal.status == 1){
						$('#bg_color_' + subService).removeClass('bg-blue');
						$('#bg_color_' + subService).addClass('bg-teal');

						$('#btn_run_' + subService).removeAttr( "data-status");
						$('#btn_run_' + subService).attr("data-status", dataTotal.status);

						$('#btn_run_' + subService).removeAttr( "onclick");
						var newOnclick = ' viewAlertStopTime(' + patiente + ',' + service + ',' + subService + '); ';
						$('#btn_run_' + subService).attr("onclick", newOnclick);

						$('#btn_run_' + subService).text('Stop Time');

						var obj = document.getElementById('boton_' + subService);
						if (obj){
							obj.click(); 
						}
						$('#btn_run_' + subService).text('Stop Time');

						if(data['subServicesActives'] == true){
							localStorage.setItem('subServicesActives', 1);
						}

					}else if(dataTotal.status == 2){
						$('#bg_color_' + subService).removeClass('bg-teal');
						$('#bg_color_' + subService).addClass('bg-blue');

						$('#btn_run_' + subService).removeAttr( "data-status");
						$('#btn_run_' + subService).attr("data-status", 0);
						
						$('#btn_run_' + subService).removeAttr( "onclick");
						var newOnclick = 'runTime(' + patiente + ',' + service + ',' + subService + ')';
						$('#btn_run_' + subService).attr("onclick", newOnclick);

						var obj = document.getElementById('boton_' + subService);
						if (obj){
							obj.click(); 
						}

						$('#crono_' + subService).text('');
						$('#btn_run_' + subService).text('Start Time');

						if(data['subServicesActives'] == false){
							localStorage.removeItem('subServicesActives');
						}
					}
		
				},
				error: function (error) { 
					console.log(error);
				}
			});
		};

		
		function viewAlertStopTime(patiente, service, subService){

			var opcion = confirm("Are you sure you want to terminate the service?");
			if (opcion == true) {
				runTime(patiente, service, subService);
			}
		}
		
		function GeoPosition() {
			if (!"geolocation" in navigator) {
				msjOne = "Your browser does not support location access. Try another one. \n\n";
				msjTwo = "Tu navegador no soporta el acceso a la ubicación. Intenta con otro"
				return alert(msjOne + msjTwo);
			}

			const onUbicacionConcedida = (ubicacion) => {
				console.log("Tengo la ubicación: ", ubicacion);
				var long = localStorage.getItem('long');
				var lat = localStorage.getItem('lat');
				if(typeof lat != 'undefined' && typeof long != 'undefined' && lat != null && long != null && lat != '' && long != ''){
					localStorage.removeItem('lat');
					localStorage.removeItem('long');
				}
				localStorage.setItem('lat', ubicacion.coords.latitude);
				localStorage.setItem('long', ubicacion.coords.longitude);
			}
		
			const onErrorDeUbicacion = err => {
				console.log("Error obteniendo ubicación: ", err);
			}

			const opcionesDeSolicitud = {
				enableHighAccuracy: true, // Alta precisión
				maximumAge: 0, // No queremos caché
				timeout: 5000 // Esperar solo 5 segundos
			};
			// Solicitar
			navigator.geolocation.getCurrentPosition(onUbicacionConcedida, onErrorDeUbicacion, opcionesDeSolicitud);
		};
	</script>


	<script src="/assets/plugins/gritter/js/jquery.gritter.js"></script>
	<script src="/assets/plugins/flot/jquery.flot.js"></script>
	<script src="/assets/plugins/flot/jquery.flot.time.js"></script>
	<script src="/assets/plugins/flot/jquery.flot.resize.js"></script>
	<script src="/assets/plugins/flot/jquery.flot.pie.js"></script>
	<script src="/assets/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>
	<script src="/assets/plugins/jvectormap-next/jquery-jvectormap.min.js"></script>
	<script src="/assets/plugins/jvectormap-next/jquery-jvectormap-world-mill.js"></script>
	<script src="/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>
	<script src="/assets/js/demo/dashboard.js"></script>
@endpush