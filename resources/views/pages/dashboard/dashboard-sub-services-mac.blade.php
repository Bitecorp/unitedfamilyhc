	<!-- begin row -->
	<div class="col-6">
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
							<div class="col-xl-6 col-md-6">
								<div class="widget widget-stats {{ $dataFullW->paid == 1 ? 'bg-teal'  : 'bg-red' }}">
									<div class="stats-icon stats-icon-lg"><i class="fa fa-clock fa-fw"></i></div>
									<div class="stats-info">
										<h4>{{ json_decode($dataFullW->worker_id)->first_name }} {{ json_decode($dataFullW->worker_id)->last_name }}</h4>
										<h4>Time: {{ $dataFullW->time_attention }} = {{ $dataFullW->unid_pay_worker }} units </h4>
										<h4>Amount to be paid: {{ $dataFullW->mont_pay }} $ (USD) </h4>												
									</div>
								</div>
							</div>
							
						@endforeach
					@endif
				</div>
			</div>
		</div>
	</div>

	<div class="col-6">
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
							<div class="col-xl-6 col-md-6">
								<div class="widget widget-stats {{ $dataFullP->collected == 1 ? 'bg-teal'  : 'bg-red' }}">
									<div class="stats-icon stats-icon-lg"><i class="fa fa-clock fa-fw"></i></div>
									<div class="stats-info">
										<h4>{{ json_decode($dataFullP->patiente_id)->first_name }}  {{ json_decode($dataFullP->patiente_id)->last_name }}</h4>
										<h4>Time: {{ $dataFullP->time_attention }} = {{ $dataFullP->unid_pay_worker }} units </h4>
										<h4>Amount receivable: {{ $dataFullP->mont_cob }} $ (USD) </h4>
										<h4>Amount to be paid: {{ $dataFullP->mont_pay }} $ (USD) </h4>
										<h4>Company profit: {{ $dataFullP->ganancia_empresa }} $ (USD) </h4>
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
