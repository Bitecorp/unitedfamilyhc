	<!-- begin row -->
	<div class="row" id="resultados">
		@if(isset($dataSearch) && !empty($dataSearch) && isset($subServicesActives) && !empty($subServicesActives))
			@foreach ($subservices as $subservice)
				@foreach($subServicesActives as $subServiceActive)
					@if ($subservice->id == $subServiceActive->sub_service_id)
						<div class="col-xl-12 col-md-12">
							<div id="bg_color_{{ $subservice->id  }}" class="widget widget-stats bg-teal">
								<div class="stats-icon stats-icon-lg"><i class="fa fa-clock fa-fw"></i></div>

								<div class="stats-info">
									<h4 id="titleSubService_{{ $subservice->id  }}">{{ $subservice->name_sub_service }}</h4>
								</div>
								<div class="stats-link">
									<a id="btn_run_{{ $subservice->id  }}" name="btn_run_{{ $subservice->id  }}" onclick="runTime('{{ $subservice->id  }}');">Run Time<i class="fa fa-arrow-alt-circle-right"></i></a>
								</div>
							</div>
						</div>					
					@endif
				@endforeach				
			@endforeach
		@endif
	</div>
	<!-- end row -->
