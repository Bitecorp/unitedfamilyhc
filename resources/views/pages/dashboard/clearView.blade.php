@extends('layouts.default')

@section('title', 'Dashboard V')

@push('css')
	<link href="/assets/plugins/jvectormap-next/jquery-jvectormap.css" rel="stylesheet" />
	<link href="/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css" rel="stylesheet" />
	<link href="/assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
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

				$('#patiente_id').empty()
				$('#patiente_id').append('<option value="" selected="selected">Select Option..</option>'); 
				
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
					$('#btn_submit').attr('disabled', 'disabled');

					var dataTotal = data['subServices'];
					var htmlResultados = '';
					var elementoHtml = $('#resultados');
						
					var namePatiente = data['dataPatiente'].first_name + ' ' + data['dataPatiente'].last_name;

					for (var i = 0; i < dataTotal.length; i++) {
							
						htmlResultados =
							'<div class="col-xl-12 col-md-12">\n' +
								'<div id="bg_color_' + dataTotal[i].id + '" class="widget widget-stats bg-blue">\n' +
									'<div class="stats-icon stats-icon-lg"><i class="fa fa-clock fa-fw"></i></div>\n' +
									'<div class="stats-info">\n' +
										'<h4 id="titleSubService_' + dataTotal[i].id + '">' + nameService + ' - ' + dataTotal[i].name_sub_service + ' - ' + namePatiente + '</h4>\n' +
									'</div>\n' +
									'<div class="stats-link">\n' +
										'<a id="btn_run_' + dataTotal[i].id + '" name="btn_run_' + dataTotal[i].id + '" onclick="runTime(' + dataTotal[i].id + ');">Run Time<i class="fa fa-arrow-alt-circle-right"></i></a>\n' +
									'</div>\n' +
								'</div>\n' +
							'</div>\n';

						elementoHtml.append(htmlResultados);
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
					$('#patiente_id').empty()
					$('#patiente_id').append('<option value="" selected>Select Service Option..</option>'); 
					$('#btn_submit').attr('disabled', 'disabled');
				}
			});
		});
	</script>

	<script>
		function offTime(patiente, service, subService) {
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

						if(data['subServicesActives'] == true){
							localStorage.setItem('subServicesActives', 1);
						}
						//stopStart(subService);
					}else if(dataTotal.status == 2){
						$('#bg_color_' + subService).removeClass('bg-teal');
						$('#bg_color_' + subService).addClass('bg-blue');

						if(data['subServicesActives'] == false){
							localStorage.removeItem('subServicesActives');
						}

						//stopStart(subService);
					}		
				},
				error: function (error) { 
					console.log(error);
				}
			});
		};

		function runTime(subService) {
			GeoPosition();

			var url = '/registerAttentions';

			var idUser = '{{ Auth::user()->id }}';
			var service_id = $('#service_id').val();
			var patiente_id = $('#patiente_id').val();
			var idSubService = subService;
			var long = localStorage.getItem('long');
			var lat = localStorage.getItem('lat');
			var token = '{{ csrf_token() }}';

			var subServicesActives = localStorage.getItem('subServicesActives');

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

						if(data['subServicesActives'] == true){
							localStorage.setItem('subServicesActives', 1);
						}
						//stopStart(subService);
					}else if(dataTotal.status == 2){
						$('#bg_color_' + subService).removeClass('bg-teal');
						$('#bg_color_' + subService).addClass('bg-blue');

						if(data['subServicesActives'] == false){
							localStorage.removeItem('subServicesActives');
						}

						//stopStart(subService);
					}		
				},
				error: function (error) { 
					console.log(error);
				}
			});
		};
		
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

	<script type="text/javascript">
		//'<h4 id="time_' + dataTotal[i].id + '"></h4>\n' +
		//'<input type="text" id="minutes_' + dataTotal[i].id + '" value="0" />' +
		//'<input type="text" id="seconds_' + dataTotal[i].id + '" value="0" />\n' +

		var time; 
		var on = false; 
		var seconds = 0; 
		var minutes = 0;

		function startTime(subService){
				seconds++;
				time = setTimeout(startTime(subService),1000);
				if(seconds > 59)  {seconds = 0; minutes++;}
				document.getElementById("minutes_" + subService).value = minutes;
				// Mostar segundos
				document.getElementById("seconds_" + subService).value = seconds;
				// Mostar segundos
		}

		function stopStart(subService){
				document.getElementById("time_" + subService).innerHTML = !on ? "Stop" : "Start";
				if(!on){
					on = true;	startTime();
				}else{
					on = false;	clearTimeout(time);
				}
		}
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