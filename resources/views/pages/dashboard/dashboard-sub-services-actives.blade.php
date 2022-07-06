	<!-- begin row -->
	<div class="row" id="resultadosActivos">
		@if(isset($dataSearch) && !empty($dataSearch) )	
			@foreach ($dataSearch as $dataS)	
				<div class="col-xl-12 col-md-12">
					<div id="bg_color_{{ $dataS['sub_service_id'] }}" class="widget widget-stats bg-teal">
						<div class="stats-icon stats-icon-lg"><i class="fa fa-clock fa-fw"></i></div>

						<div class="stats-info">
							<h4 id="titleSubService_{{ $dataS['sub_service_id'] }}"> {{ $dataS['service']['name_service'] }} - {{ $dataS['sub_service']['name_sub_service'] }} - {{ $dataS['patiente']['fullNamePatiente'] }} </h4>
						
							<div class="crono_wrapper">
								<h2 id="crono_{{ $dataS['sub_service_id'] }}"></h2>
								<input type="button" value="Empezar" id="boton_{{ $dataS['sub_service_id'] }}" onclick="empezarDetener_{{ $dataS['sub_service_id'] }}(this);" hidden>
							</div>
						</div>
						<div class="stats-link">
							<a id="btn_run_{{ $dataS['sub_service_id'] }}" name="btn_run_{{ $dataS['sub_service_id'] }}" data-status="{ $dataS['status'] }}" onclick="viewAlertStopTime( {{ $dataS["patiente_id"] }}, {{ $dataS["service_id"] }}, {{ $dataS["sub_service_id"] }} );">Stop Time<i class="fa fa-arrow-alt-circle-right"></i></a>
						</div>
					</div>
				</div>
                
                
                <script type="text/javascript">
					var inicio_{{ $dataS["sub_service_id"] }} = 0;
        			var timeout_{{ $dataS["sub_service_id"] }} = 0;

					function empezarDetener_{{ $dataS["sub_service_id"] }}(elemento){
						if(timeout_{{ $dataS["sub_service_id"] }} == 0){
									
							elemento.value = "Detener";
							
							inicio_{{ $dataS["sub_service_id"] }} = new Date().getTime();
							
							localStorage.setItem( 'inicio_{{ $dataS["sub_service_id"] }}', inicio_{{ $dataS["sub_service_id"] }} );
							
							funcionando_{{ $dataS["sub_service_id"] }}();
						}else{
							
							elemento.value = "Empezar";
							clearTimeout( timeout_{{ $dataS["sub_service_id"] }} );
							
							localStorage.removeItem("inicio_{{ $dataS['sub_service_id'] }}");
							timeout_{{ $dataS["sub_service_id"] }} = 0;

							location.reload();
						}
					}

					function funcionando_{{ $dataS["sub_service_id"] }}(){
						var actual_{{ $dataS["sub_service_id"] }} = new Date().getTime();
						var diff_{{ $dataS["sub_service_id"] }} = new Date(actual_{{ $dataS["sub_service_id"] }}-inicio_{{ $dataS["sub_service_id"] }});
						var result_{{ $dataS["sub_service_id"] }} = LeadingZero_{{ $dataS["sub_service_id"] }}(diff_{{ $dataS["sub_service_id"] }}.getUTCHours())+":"+LeadingZero_{{ $dataS["sub_service_id"] }}(diff_{{ $dataS["sub_service_id"] }}.getUTCMinutes())+":"+LeadingZero_{{ $dataS["sub_service_id"] }}(diff_{{ $dataS["sub_service_id"] }}.getUTCSeconds());
						document.getElementById("crono_{{ $dataS['sub_service_id'] }}").innerHTML = result_{{ $dataS["sub_service_id"] }};
						timeout_{{ $dataS["sub_service_id"] }} = setTimeout("funcionando_{{ $dataS['sub_service_id'] }}()",1000);
					}
							

					function LeadingZero_{{ $dataS["sub_service_id"] }}(Time_{{ $dataS["sub_service_id"] }}){
						return (Time_{{ $dataS["sub_service_id"] }} < 10) ? "0" + Time_{{ $dataS["sub_service_id"] }} : + Time_{{ $dataS["sub_service_id"] }};
					}
				</script>
                

			@endforeach			
		@endif

		@if(isset($dataSearch) && !empty($dataSearch) )	
			@foreach ($dataSearch as $dataS)
				<script>
					if(localStorage.getItem("inicio_{{ $dataS['sub_service_id'] }}") != null){
						inicio_{{ $dataS["sub_service_id"] }} = localStorage.getItem("inicio_{{ $dataS['sub_service_id'] }}");
						document.getElementById("boton_{{ $dataS['sub_service_id'] }}").value = "Detener";
						funcionando_{{ $dataS["sub_service_id"] }}();
					}
				</script>
			@endforeach			
		@endif
	</div>
	<!-- end row -->
