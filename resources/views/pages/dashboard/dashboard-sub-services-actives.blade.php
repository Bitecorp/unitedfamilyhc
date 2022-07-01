	<!-- begin row -->
	<div class="row" id="resultadosActivos">
		@if(isset($dataSearch) && !empty($dataSearch) )	
			@foreach ($dataSearch as $dataS)	
				<div class="col-xl-12 col-md-12">
                    <div id="bg_color_{{ $dataS['sub_service_id'] }}" class="widget widget-stats bg-teal">
                        <div class="stats-icon stats-icon-lg"><i class="fa fa-clock fa-fw"></i></div>

                        <div class="stats-info">
                            <h4 id="titleSubService_{{ $dataS['sub_service_id']   }}"> {{ $dataS['service']['name_service'] }} - {{ $dataS['sub_service']['name_sub_service'] }} - {{ $dataS['patiente']['fullNamePatiente'] }} </h4>
                        </div>
                        <div class="stats-link">
                            <a id="btn_run_{{ $dataS['sub_service_id']   }}" name="btn_run_{{ $dataS['sub_service_id']   }}" onclick="runTime( {{ $dataS["patiente_id"] }}, {{ $dataS["service_id"] }}, {{ $dataS["sub_service_id"] }} );">Run Time<i class="fa fa-arrow-alt-circle-right"></i></a>
                        </div>
                    </div>
                </div>
			@endforeach			
		@endif
	</div>
	<!-- end row -->
