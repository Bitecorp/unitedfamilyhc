@extends('layouts.default')

@section('title', 'Dashboard')

<?php 
	$dataPagCobGanActual = dataPayUnitsServicesForWorker(null, data_first_month_day(), data_last_month_day(), 1, true);

	$dataPagCobGanLast = dataPayUnitsServicesForWorker(null, data_first_month_day_last(), data_last_month_day_last(), 1, true);

	$dataPagCobGanTri = dataPayUnitsServicesForWorker(null, data_first_month_day_Tri(), data_last_month_day_last(), 1, true);

	dd(data_first_month_day(), data_last_month_day(), data_first_month_day_last(), data_last_month_day_last(), data_first_month_day_Tri(), data_last_month_day_last());
	//dd($dataPagCobGanActual, $dataPagCobGanLast, $dataPagCobGanTri);
?>

@push('css')
	<link href="/assets/plugins/jvectormap-next/jquery-jvectormap.css" rel="stylesheet" />
	<link href="/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css" rel="stylesheet" />
	<link href="/assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
@endpush

@section('content')
	<!-- begin row -->
	<div class="row">
		<!-- begin col-3 -->
		<div class="col-xl-4 col-md-6">
			<div class="widget widget-stats bg-info">
				<div class="stats-icon stats-icon-lg"><i class="fa fa-dollar-sign fa-fw"></i><!-- <i class="fa fa-desktop"></i> --></div>
				<div class="stats-info">
					<h4>COLLECTED - PAY -> CURRENT MONTH</h4>
					<h5>{{ isset($dataPagCobGanActual) && !empty($dataPagCobGanActual) && isset($dataPagCobGanActual['montoCobroTotal']) && !empty($dataPagCobGanActual['montoCobroTotal']) ? number_format((float)$dataPagCobGanActual['montoCobroTotal'], 2, ".", ",") : '0.00' }} - {{ isset($dataPagCobGanActual) && !empty($dataPagCobGanActual) && isset($dataPagCobGanActual['montoPagoTotal']) && !empty($dataPagCobGanActual['montoPagoTotal']) ? number_format((float)$dataPagCobGanActual['montoPagoTotal'], 2, ".", ",") : '0.00' }}</h5>
				
					<h4>PROFITS</h4>
					<p>{{ isset($dataPagCobGanActual) && !empty($dataPagCobGanActual) && isset($dataPagCobGanActual['montoGananciaTotal']) && !empty($dataPagCobGanActual['montoGananciaTotal']) ? number_format((float)$dataPagCobGanActual['montoGananciaTotal'], 2, ".", ",") : '0.00' }}</p>
				</div>
			</div>
		</div>
		<!-- end col-3 -->
		<!-- begin col-3 -->
		<div class="col-xl-4 col-md-6">
			<div class="widget widget-stats bg-info">
				<div class="stats-icon stats-icon-lg"><i class="fa fa-dollar-sign fa-fw"></i><!-- <i class="fa fa-desktop"></i> --></div>
				<div class="stats-info">
					<h4>COLLECTED - PAY -> LAST MONTH</h4>
					<h5>{{ isset($dataPagCobGanLast) && !empty($dataPagCobGanLast) && isset($dataPagCobGanLast['montoCobroTotal']) && !empty($dataPagCobGanLast['montoCobroTotal']) ? number_format((float)$dataPagCobGanLast['montoCobroTotal'], 2, ".", ",") : '0.00' }} - {{ isset($dataPagCobGanLast) && !empty($dataPagCobGanLast) && isset($dataPagCobGanLast['montoPagoTotal']) && !empty($dataPagCobGanLast['montoPagoTotal']) ? number_format((float)$dataPagCobGanLast['montoPagoTotal'], 2, ".", ",") : '0.00' }}</h5>
				
					<h4>PROFITS</h4>
					<p>{{ isset($dataPagCobGanLast) && !empty($dataPagCobGanLast) && isset($dataPagCobGanLast['montoGananciaTotal']) && !empty($dataPagCobGanLast['montoGananciaTotal']) ? number_format((float)$dataPagCobGanLast['montoGananciaTotal'], 2, ".", ",") : '0.00' }}</p>
				</div>
			</div>
		</div>
		<!-- end col-3 -->
		<!-- begin col-3 -->
		<div class="col-xl-4 col-md-6">
			<div class="widget widget-stats bg-info">
				<div class="stats-icon stats-icon-lg"><i class="fa fa-dollar-sign fa-fw"></i><!-- <i class="fa fa-desktop"></i> --></div>
				<div class="stats-info">
					<h4>COLLECTED - PAY -> PREVIOUS THREE MONTHS</h4>
					<h5>{{ isset($dataPagCobGanTri) && !empty($dataPagCobGanTri) && isset($dataPagCobGanTri['montoCobroTotal']) && !empty($dataPagCobGanTri['montoCobroTotal']) ? number_format((float)$dataPagCobGanTri['montoCobroTotal'], 2, ".", ",") : '0.00' }} - {{ isset($dataPagCobGanTri) && !empty($dataPagCobGanTri) && isset($dataPagCobGanTri['montoPagoTotal']) && !empty($dataPagCobGanTri['montoPagoTotal']) ? number_format((float)$dataPagCobGanTri['montoPagoTotal'], 2, ".", ",") : '0.00' }}</h5>
				
					<h4>PROFITS</h4>
					<p>{{ isset($dataPagCobGanTri) && !empty($dataPagCobGanTri) && isset($dataPagCobGanTri['montoGananciaTotal']) && !empty($dataPagCobGanTri['montoGananciaTotal']) ? number_format((float)$dataPagCobGanTri['montoGananciaTotal'], 2, ".", ",") : '0.00' }}</p>
				</div>
			</div>
		</div>
		<!-- end col-3 -->
	</div>
	<!-- end row -->
    <!-- begin row -->
	<div class="row">
		<!-- begin col-3 -->
		<div class="col-xl-3 col-md-6">
			<div class="widget widget-stats bg-teal">
				<div class="stats-icon stats-icon-lg"><i class="fa fa-users"></i></div>
                <div class="stats-content">
					<div class="stats-title">WORKEERS ACTIVE</div>
					<div class="stats-number">{{ $workersCount }}</div>
					<div class="stats-link">
                        <a href="{{ route('workers.index') }}">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                    </div>
				</div>
			</div>
		</div>
		<!-- end col-3 -->
		<!-- begin col-3 -->
		<div class="col-xl-3 col-md-6">
			<div class="widget widget-stats bg-teal">
				<div class="stats-icon stats-icon-lg"><i class="fa fa-users"></i></div>
                <div class="stats-content">
                    <div class="stats-title">PATIENTS ACTIVE</div>
                    <div class="stats-number">{{ $patientesCount }}</div>
                    <div class="stats-link">
                        <a href="{{ route('patientes.index') }}">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                    </div>
                </div>
			</div>
		</div>
		<!-- end col-3 -->
		<!-- begin col-3 -->
		<div class="col-xl-3 col-md-6">
			<div class="widget widget-stats {{ $countDocumentsWorkers >= 1 ? 'bg-red' : 'bg-teal'}}">
				<div class="stats-icon stats-icon-lg"><i class="fa fa-file fa-fw"></i></div>
				<div class="stats-content">
					<div class="stats-title">DOCUMENTS WORKERS TO EXPIRED</div>
					<div class="stats-number">{{ $countDocumentsWorkers }}</div>
					<div class="stats-link">
                        <a href="{{ route('alertDocuments.index', ['workers']) }}">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                    </div>
				</div>
			</div>
		</div>
		<!-- end col-3 -->
		<!-- begin col-3 -->
		<div class="col-xl-3 col-md-6">
			<div class="widget widget-stats {{ $countDocumentsPatientes >= 1 ? 'bg-red' : 'bg-teal'}}">
				<div class="stats-icon stats-icon-lg"><i class="fa fa-file fa-fw"></i></div>
				<div class="stats-content">
					<div class="stats-title">DOCUMENTS PATIENTS TO EXPIRED</div>
					<div class="stats-number">{{ $countDocumentsPatientes }}</div>
					<div class="stats-link">
                        <a href="{{ route('alertDocuments.index', ['patientes']) }}">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                    </div>
				</div>
			</div>
		</div>
		<!-- end col-3 -->
	</div>
	<!-- end row -->
	<!-- begin row -->
	<div class="row">
		<!-- begin col-8 -->
		<div class="col-xl-8">
			<!-- begin panel -->
			<div class="panel panel-inverse" data-sortable-id="index-1">
				<div class="panel-heading">
					<h4 class="panel-title">Website Analytics (Last 7 Days)</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
					</div>
				</div>
				<div class="panel-body pr-1">
					<div id="interactive-chart" class="height-sm"></div>
				</div>
			</div>
			<!-- end panel -->
		</div>
		<!-- end col-8 -->
		<!-- begin col-4 -->
		<div class="col-xl-4">
            <!-- begin panel -->
			<div class="panel panel-inverse" data-sortable-id="index-7">
				<div class="panel-heading">
					<h4 class="panel-title">Visitors User Agent</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
					</div>
				</div>
				<div class="panel-body">
					<div id="donut-chart" class="height-sm"></div>
				</div>
			</div>
			<!-- end panel -->
			<!-- begin panel -->
			<div class="panel panel-inverse" data-sortable-id="index-6">
				<div class="panel-heading">
					<h4 class="panel-title">Analytics Details</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-valign-middle table-panel mb-0">
						<thead>
							<tr>
								<th>Source</th>
								<th>Total</th>
								<th>Trend</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><label class="label label-danger">Unique Visitor</label></td>
								<td>13,203 <span class="text-success"><i class="fa fa-arrow-up"></i></span></td>
								<td><div id="sparkline-unique-visitor"></div></td>
							</tr>
							<tr>
								<td><label class="label label-warning">Bounce Rate</label></td>
								<td>28.2%</td>
								<td><div id="sparkline-bounce-rate"></div></td>
							</tr>
							<tr>
								<td><label class="label label-success">Total Page Views</label></td>
								<td>1,230,030</td>
								<td><div id="sparkline-total-page-views"></div></td>
							</tr>
							<tr>
								<td><label class="label label-primary">Avg Time On Site</label></td>
								<td>00:03:45</td>
								<td><div id="sparkline-avg-time-on-site"></div></td>
							</tr>
							<tr>
								<td><label class="label label-default">% New Visits</label></td>
								<td>40.5%</td>
								<td><div id="sparkline-new-visits"></div></td>
							</tr>
							<tr>
								<td><label class="label label-inverse">Return Visitors</label></td>
								<td>73.4%</td>
								<td><div id="sparkline-return-visitors"></div></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<!-- end panel -->
		</div>
		<!-- end col-4 -->
	</div>
	<!-- end row -->
@endsection

@push('scripts')
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
