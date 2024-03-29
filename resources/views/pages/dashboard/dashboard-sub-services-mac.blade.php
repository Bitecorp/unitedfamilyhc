	<!-- begin row -->
	<div class="col-12">
		<div class="panel panel-inverse">
			<div class="panel-heading">
                <h4 class="panel-title">
                        Workers
                </h4>
            	<div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                </div>
            </div>
			<div class="panel-body">
				<div class="row" id="resulWor">
					@if (isset($dataMensualDasboard) && !empty($dataMensualDasboard) && isset($dataMensualDasboard['dataW']) && !empty($dataMensualDasboard['dataW']))
						@foreach ($dataMensualDasboard['dataW'] as $key => $dataFullW )
							<div class="col-xl-4 col-md-4">
								<div class="widget widget-stats {{ $dataFullW->paid == 1 ? 'bg-teal'  : 'bg-red' }}">
									<div class="stats-icon stats-icon-lg"><i class="fa fa-clock fa-fw"></i></div>
									<div class="stats-info">
										<p style="font-size: 100%">{{ json_decode($dataFullW->worker_id)->first_name }} {{ json_decode($dataFullW->worker_id)->last_name }}</p>
										<p style="font-size: 100%">{{ json_decode($dataFullW->sub_service_id)->name_sub_service }}</p>
										<p style="font-size: 100%">Hours: <span style="font-size: 100%">{{ $dataFullW->time_attention }}</span></p>
										<p style="font-size: 225%"><span style="font-size: 225%">$ {{ $dataFullW->mont_pay }}</span></p>												
									</div>
								</div>
							</div>
						@endforeach
					@endif
				</div>
			</div>
		</div>
	</div>

	<div class="col-12">
		<div class="panel panel-inverse">
			<div class="panel-heading">
                <h4 class="panel-title">
                        Patients
                </h4>
            	<div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                </div>
            </div>
			<div class="panel-body">
				<div class="row" id="resulPat" >
					@if (isset($dataMensualDasboard) && !empty($dataMensualDasboard) && isset($dataMensualDasboard['dataP']) && !empty($dataMensualDasboard['dataP']))
						@foreach ($dataMensualDasboard['dataP'] as $key => $dataFullP )
							<div class="col-xl-4 col-md-4">
								<div class="widget widget-stats {{ $dataFullP->collected == 1 ? 'bg-teal'  : 'bg-red' }}">
									<div class="stats-icon stats-icon-lg"><i class="fa fa-clock fa-fw"></i></div>
									<div class="stats-info">
										<p style="font-size: 100%">{{ json_decode($dataFullP->patiente_id)->first_name }}  {{ json_decode($dataFullP->patiente_id)->last_name }}</p>
										<p style="font-size: 100%">{{ json_decode($dataFullP->sub_service_id)->name_sub_service }}</p>
										<p style="font-size: 100%">Hours: <span style="font-size: 100%">{{ $dataFullP->time_attention }}</span></p>
										<p style="font-size: 225%"><span style="font-size: 225%">$ {{ $dataFullP->mont_cob }}</span></p>
									</div>
								</div>
							</div>
							
						@endforeach
					@endif						
				</div>
			</div>
		</div>
	</div>
	<!-- end row -->
