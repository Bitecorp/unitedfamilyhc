	<!-- begin nav-tabs -->
	<ul id="ioniconsTab" class="nav nav-tabs nav-tabs-inverse">
		<li class="nav-item"><a href="#nav-basic-data" data-toggle="tab" class="nav-link active"><i class="fa fa-address-card fa-lg m-r-5"></i><span class="d-none d-lg-inline m-l-5">Basic Data</span>&nbsp;</a></li>
		<li class="nav-item"><a href="#nav-contact-emergency" data-toggle="tab" class="nav-link"><i class="fa fa-phone fa-lg m-r-5"></i><span class="d-none d-lg-inline m-l-5">Emergency Contact</span>&nbsp;</a></li>
		<li class="nav-item"><a href="#nav-guardian" data-toggle="tab" class="nav-link"><i class="fa fa-male fa-lg m-r-5"></i><span class="d-none d-lg-inline m-l-5">Guardian</span>&nbsp;</a></li>
    </ul>
	<!-- end nav-tabs -->

	<!-- begin tab-content -->
	<div id="ioniconsTabContent" class="tab-content">
		<!-- begin tab-pane -->
		<div class="tab-pane fade show active" style="margin-top: 20px;" id="nav-basic-data" >
			<!-- begin row -->
			<div>
                @include('patientes.show_fields')
			</div>
			<!-- end row -->
		</div>
		<!-- end tab-pane -->
		<!-- begin tab-pane -->
		<div class="tab-pane fade" style="margin-top: 20px;" id="nav-contact-emergency">
			<!-- begin row -->
			<div>
                @include('contact_emergencies.show_fields')
			</div>
			<!-- end row -->
		</div>
		<!-- end tab-pane -->
		<!-- begin tab-pane -->
		<div class="tab-pane fade" style="margin-top: 20px;" id="nav-guardian">
			<!-- begin row -->
			<div>
                @include('contact_emergencies.show_guardian_fields')
			</div>
			<!-- end row -->
		</div>
		<!-- end tab-pane -->
        <!-- Submit Field -->
        <div style="margin-top: 20px; margin-bottom: 20px;" class="form-group col-sm-12">
            <a href="{{ route('patientes.edit', [$patiente->id]) }}" class='btn btn-warning'><i class="fa fa-edit"></i> Edit </a>
            <a href="{{ route('patientes.index') }}" class="btn btn-secondary">Back</a>
        </div>
	</div>
	<!-- end tab-content -->
	<!-- end panel -->

