	<!-- begin nav-tabs -->
	<ul id="ioniconsTab" class="nav nav-tabs nav-tabs-inverse">
		<li class="nav-item"><a href="#nav-basic-data" data-toggle="tab" class="nav-link active"><span class="d-none d-lg-inline m-l-5">Basic Data</span>&nbsp;</a></li>
		<li class="nav-item"><a href="#nav-contact-emergency" data-toggle="tab" class="nav-link"><span class="d-none d-lg-inline m-l-5">Emergency Contact</span>&nbsp;</a></li>
		<li class="nav-item"><a href="#nav-job-information" data-toggle="tab" class="nav-link"><span class="d-none d-lg-inline m-l-5">Job Information</span>&nbsp;</a></li>
        <li class="nav-item"><a href="#nav-education" data-toggle="tab" class="nav-link"><span class="d-none d-lg-inline m-l-5">Education</span>&nbsp;</a></li>
		<li class="nav-item"><a href="#nav-references" data-toggle="tab" class="nav-link"><span class="d-none d-lg-inline m-l-5">References</span>&nbsp;</a></li>
        <li class="nav-item"><a href="#nav-independent-contractor" data-toggle="tab" class="nav-link"><span class="d-none d-lg-inline m-l-5">Independent Contractor</span>&nbsp;</a></li>
    </ul>
	<!-- end nav-tabs -->

	<!-- begin tab-content -->
	<div id="ioniconsTabContent" class="tab-content">
		<!-- begin tab-pane -->
		<div class="tab-pane fade show active" style="margin-top: 20px;" id="nav-basic-data" >
			<!-- begin row -->
			<div>
                @include('workers.show_fields')
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
		<div class="tab-pane fade" style="margin-top: 20px;" id="nav-job-information">
			<!-- begin row -->
			<div>
                @include('job_informations.show_fields')
			</div>
			<!-- end row -->
		</div>
		<!-- end tab-pane -->
        <!-- begin tab-pane -->
		<div class="tab-pane fade" id="nav-education">
			<!-- begin row -->
			<div>
                @include('education.show_fields')
			</div>
			<!-- end row -->
		</div>
		<!-- end tab-pane -->
		<!-- begin tab-pane -->
		<div class="tab-pane fade" style="margin-top: 20px;" id="nav-references">
			<!-- begin row -->
			<div>
                <div class="container-fluid">
                    <div class="animated fadeIn">
                        <div class="row">
                            <div class="col">
                                <div class="card">
                                    <div class="card-header">
                                        <i class="fa fa-plus-square-o fa-lg"></i>
                                        <strong>Personales N#1</strong>
                                    </div>
                                    @include('references_personales.show_fields')
                                    <div class="card-header">
                                        <i class="fa fa-plus-square-o fa-lg"></i>
                                        <strong>Personales N# 2</strong>
                                    </div>
                                    @include('references_personales_twos.show_fields')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </br>
                @if(isset($referencesJobs) || isset($referencesJobsTwo))
                <div class="container-fluid">
                    <div class="animated fadeIn">
                        <div class="row">
                            <div class="col">
                                <div class="card">
                                    <div class="card-header">
                                        <i class="fa fa-plus-square-o fa-lg"></i>
                                        <strong>Job N#1</strong>
                                    </div>
                                    @include('references_jobs.show_fields')
                                    <div class="card-header">
                                        <i class="fa fa-plus-square-o fa-lg"></i>
                                        <strong>Job N# 2</strong>
                                    </div>
                                    @include('references_jobs_twos.show_fields')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
			</div>
			<!-- end row -->
		</div>
		<!-- end tab-pane -->
		<!-- begin tab-pane -->
		<div class="tab-pane fade" style="margin-top: 20px;" id="nav-independent-contractor">
			<!-- begin row -->
			<div>
                @include('confirmation_independents.show_fields')
			</div>
			<!-- end row -->
		</div>
		<!-- end tab-pane -->

        <!-- Submit Field -->
        <div style="margin-top: 20px; margin-bottom: 20px;" class="form-group col-sm-12">
            <a href="{{ route('workers.edit', [$worker->id]) }}" class='btn btn-warning'><i class="fa fa-edit"></i> Edit </a>
            @if(Auth::user()->role_id != 2)
                <a href="{{ route('workers.index') }}" class="btn btn-secondary">Back</a>
            @endif
        </div>
	</div>
	<!-- end tab-content -->
	<!-- end panel -->

