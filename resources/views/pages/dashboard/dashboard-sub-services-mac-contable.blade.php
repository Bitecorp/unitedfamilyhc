<!-- begin row -->



				<div class="panel panel-inverse">
					<!-- begin panel-heading -->
					<div class="panel-heading">
						<h4 class="panel-title">
							Patient
							
						</h4>
						<div class="panel-heading-btn">
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						</div>
					</div>
					<!-- end panel-heading -->
					<!-- begin panel-body -->
					<div class="panel-body">
						<div class="col-xs-12 ">
							<table id="contable-table-pat" class="table table-striped table-bordered table-td-valign-middle">
								<thead>
									<tr>
										<th class="text-nowrap">Patient</th>	
										<th class="text-nowrap">Service - Sub Service</th>
										<th class="text-nowrap">Unit - Value</th>
										<th class="text-nowrap">Time of attention = Units</th>
										<th class="text-nowrap">Value receivable</th>
										<th class="text-nowrap">Status/Action</th>
									</tr>
								</thead>
								<tbody id="resulPatTab">
									@if (isset($dataMensual) && !empty($dataMensual) && isset($dataMensual['dataP']) && !empty($dataMensual['dataP']))
										@foreach ($dataMensual['dataP'] as $key => $dataFullP )
											<?php
												$checkCheck = $dataFullP->collected == true ? 'checked' : '';
												$revertir = $dataFullP->collected == true ? 'revertir' : '';
												$valCollected = $dataFullP->collected == true ? 'true' : 'false';
											?>
											<tr>
												<td>{{ json_decode($dataFullP->patiente_id)->first_name }}  {{ json_decode($dataFullP->patiente_id)->last_name }}</td>	
												<td>{{ json_decode($dataFullP->service_id)->name_service }} - {{ json_decode($dataFullP->sub_service_id)->name_sub_service }}</td>
												<td>{{ $dataFullP->unidad_time_worker }} {{ $dataFullP->unidad_type_worker }} - {{ $dataFullP->unit_value_worker }} $ (USD)</td>
												<td>{{ $dataFullP->time_attention }} = {{ $dataFullP->unid_pay_worker }}</td>
												<td>{{ $dataFullP->mont_cob }} $ (USD)</td>
												<td>
													<div class="custom-control custom-switch">
														<input type="checkbox" onclick="{{ $revertir }}cobrar({{ json_decode($dataFullP->worker_id)->id }}, {{ json_decode($dataFullP->patiente_id)->id }}, {{ json_decode($dataFullP->service_id)->id }}, {{ json_decode($dataFullP->sub_service_id)->id }});"  class="custom-control-input" name="Switch_patiente{{ $dataFullP->id }}" id="Switch_patiente{{$dataFullP->id }}" {{ $checkCheck }}>
														<label class="custom-control-label" for="Switch_patiente{{ $dataFullP->id }}"></label>
													</div>
												</td>
											</tr>											
										@endforeach
									@endif	
								</tbody>
							</table>
						</div>
					</div>
					<!-- end panel-body -->
				</div>
				<div id="resulPatMod">
				</div>


				<div class="panel panel-inverse">
					<!-- begin panel-heading -->
					<div class="panel-heading">
						<h4 class="panel-title">
							Workers
						</h4>
						<div class="panel-heading-btn">
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						</div>
					</div>
					<!-- end panel-heading -->
					<!-- begin panel-body -->
					<div class="panel-body">
						<div class="col-xs-12 ">
							<table id="contable-table-wor" class="table table-striped table-bordered table-td-valign-middle">
								<thead>
									<tr>
										<th class="text-nowrap">Worker</th>
										<th class="text-nowrap">Service - Sub Service</th>
										<th class="text-nowrap">Patient</th>	
										<th class="text-nowrap">Unit - Value</th>
										<th class="text-nowrap">Time of attention = Units</th>
										<th class="text-nowrap">Memo</th>
										<th class="text-nowrap">Value to by paid</th>
										<th class="text-nowrap">Status/Action</th>
									</tr>
								</thead>
								<tbody id="resulWorTab">
									@if (isset($dataMensual) && !empty($dataMensual) && isset($dataMensual['dataW']) && !empty($dataMensual['dataW']))
										@foreach ($dataMensual['dataW'] as $key => $dataFullW )
											<?php 
												$checkCheck = $dataFullW->paid == true ? 'checked' : '';
												$revertir = $dataFullW->paid == true ? 'revertir' : '';
												$valPay = $dataFullW->paid == true ? 'true' : 'false';
												$hiddenBtnXml = $dataFullW->paid == true ? '' : 'hidden';
												$explodeIM = isset(explode(' ', json_decode($dataFullW->sub_service_id)->name_sub_service)[0]) && !empty(explode(' ', json_decode($dataFullW->sub_service_id)->name_sub_service)[0]) ? explode(' ', json_decode($dataFullW->sub_service_id)->name_sub_service)[0] : '';
												$nameFile = json_decode($dataFullW->worker_id)->first_name . '_' . json_decode($dataFullW->worker_id)->last_name . '_' . str_replace(' ', '_', json_decode($dataFullW->sub_service_id)->name_sub_service) . '_from_' . date_format(date_create(data_previa_month_day_first()), 'd_m_Y') . '_to_' . date_format(date_create(data_previa_month_day_last()), 'd_m_Y') . '.zip';
												$memo = json_decode($dataFullW->patiente_id)->first_name . ' ' . json_decode($dataFullW->patiente_id)->last_name . ' ' . $explodeIM . ' ' .$dataFullW->time_attention . ' = ' . $dataFullW->unid_pay_worker;

											?>
											<tr>
												<td>{{ json_decode($dataFullW->worker_id)->first_name }} {{ json_decode($dataFullW->worker_id)->last_name }}</td>
												<td>{{ json_decode($dataFullW->service_id)->name_service }} - {{ json_decode($dataFullW->sub_service_id)->name_sub_service }}</td>
												<td>{{ json_decode($dataFullW->patiente_id)->first_name }}  {{ json_decode($dataFullW->patiente_id)->last_name }}</td>	
												<td>{{ $dataFullW->unidad_time_worker }} {{ $dataFullW->unidad_type_worker }} - {{ $dataFullW->unit_value_worker }} $ (USD)</td>
												<td>{{ $dataFullW->time_attention }} = {{ $dataFullW->unid_pay_worker }}</td>
												<td>{{ $memo }}</td>
												<td>{{ $dataFullW->mont_pay }} (USD)</td>
												<td>

													<div class="custom-control custom-switch">
														<input type="checkbox" onclick="{{ $revertir }}pagar({{ json_decode($dataFullW->worker_id)->id }}, {{ json_decode($dataFullW->patiente_id)->id }}, {{ json_decode($dataFullW->service_id)->id }}, {{ json_decode($dataFullW->sub_service_id)->id }}, {{ $dataFullW->id }});"  class="custom-control-input" name="Switch_worker_{{ $dataFullW->id }}" id="Switch_worker_{{ $dataFullW->id }}" {{ $checkCheck }}>
														<label class="custom-control-label" for="Switch_worker_{{ $dataFullW->id }}"></label>
													</div>
													<button onclick="redirectAddMemoForPai({{ json_decode($dataFullW->worker_id)->id }}, {{ json_decode($dataFullW->patiente_id)->id }}, {{ json_decode($dataFullW->service_id)->id }}, {{ json_decode($dataFullW->sub_service_id)->id }}, {{ $dataFullW->mont_pay }});" id="redirectAddMemoForPai" name="redirectAddMemoForPai" type="button" class="btn btn-success" style="margin-top: 5px;">Memo</button>
													<a type="button" href="{{ asset('filesXml/' . str_replace(' ', '_', $nameFile)) }}"  download="{{ str_replace(' ', '_', $nameFile) }}" {{ $hiddenBtnXml }} id="btn_send_xml_{{ $dataFullW->id }}" class="btn btn-success" style="margin-top: 5px;" ><i class="fa fa-download"></i> Download Xml </a>
												</td>

											</tr>											
										@endforeach
									@endif
								</tbody>
							</table>
						</div>
					</div>
					<!-- end panel-body -->
				</div>
				<div id="resulWorMod">
				</div>

		
	
<!-- end row -->

