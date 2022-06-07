	<!-- begin nav-tabs -->
	<ul id="ioniconsTab" class="nav nav-tabs nav-tabs-inverse">
		<li class="nav-item"><a href="#nav-basic-data" data-toggle="tab" class="nav-link active"><span class="d-none d-lg-inline m-l-5">Basic Data</span>&nbsp;</a></li>
    </ul>
	<!-- end nav-tabs -->

	<!-- begin tab-content -->
	<div id="ioniconsTabContent" class="tab-content">
		<!-- begin tab-pane -->
		<div class="tab-pane fade show active" style="margin-top: 20px;" id="nav-basic-data" >
			<!-- begin row -->
			<div>
                @include('agents.show_fields')
			</div>
			<!-- end row -->
		</div>
		<!-- end tab-pane -->
        <!-- Submit Field -->
        <div style="margin-top: 20px; margin-bottom: 20px;" class="form-group col-sm-12">
            <a href="{{ route('agents.edit', [$worker->id]) }}" class='btn btn-warning'><i class="fa fa-edit"></i> Edit </a>
            <a href="{{ route('agents.index') }}" class="btn btn-secondary">Back</a>
        </div>
	</div>
	<!-- end tab-content -->
	<!-- end panel -->

