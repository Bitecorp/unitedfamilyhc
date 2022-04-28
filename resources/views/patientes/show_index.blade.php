@extends('layouts.default')

@section('content')

	<!-- begin nav-tabs -->
	<ul class="nav nav-tabs nav-tabs-inverse">
		<li class="nav-item"><a href="#nav-information" data-toggle="tab" class="nav-link active"><span class="d-none d-lg-inline m-l-5">Information</span>&nbsp;</a></li>
        @if(isset($education))
            @if($education->user_id == $patiente->id && !is_null($education->high_school))
                <li class="nav-item"><a href="#nav-assign-service" data-toggle="tab" class="nav-link"><span class="d-none d-lg-inline m-l-5">Assign Services</span>&nbsp;</a></li>
                <li class="nav-item"><a href="#nav-documents" data-toggle="tab" class="nav-link"><span class="d-none d-lg-inline m-l-5">Documents</span>&nbsp;</a></li>
            @endif
        @endif
    </ul>
	<!-- end nav-tabs -->

	<!-- begin tab-content -->
	<div class="tab-content">
		<!-- begin tab-pane -->
		<div class="tab-pane fade show active" id="nav-information" >
			<!-- begin row -->
			<div>
                @include('patientes.show')
			</div>
			<!-- end row -->
		</div>
		<!-- end tab-pane -->
        @if(isset($education))
            @if($education->user_id == $userID && !is_null($education->high_school))
                <!-- begin tab-pane -->
                <div class="tab-pane fade"  id="nav-assign-service">
                    <!-- begin row -->
                    <div>
                        @include('service_assigneds.acordion')
                    </div>
                    <!-- end row -->
                </div>
                <!-- end tab-pane -->
                <!-- begin tab-pane -->
                <div class="tab-pane fade" id="nav-documents">
                    <!-- begin row -->
                    <div>
                        @include('document_user_files.table')
                    </div>
                    <!-- end row -->
                </div>
                <!-- end tab-pane -->
            @endif
        @endif
	</div>
	<!-- end panel -->
@endsection
