@extends('layouts.default')

@section('content')

<?php
    $isVisibiliti = false;
    $link = "$_SERVER[REQUEST_URI]";
    $stringSeparado = parse_url($link, PHP_URL_QUERY );

    if(isset($stringSeparado) && !empty($stringSeparado) && $stringSeparado == 'documents'){
        $isVisibiliti = true;
    }else if(isset($stringSeparado) && !empty($stringSeparado) && $stringSeparado == 'services'){
        $isVisibiliti = true;
    }else if(isset($stringSeparado) && !empty($stringSeparado) && $stringSeparado == 'assignWorker'){
        $isVisibiliti = true;
    }

    $isVisibilitiValue = isset($stringSeparado) && !empty($stringSeparado) && $stringSeparado == 'documents' || $stringSeparado == 'services' || $stringSeparado == 'assignWorker' ? $stringSeparado : '';

?>

	<!-- begin nav-tabs -->
	<ul class="nav nav-tabs nav-tabs-inverse">
		<li class="nav-item"><a href="#nav-information" data-toggle="tab" class="nav-link {{ $isVisibiliti == false ? 'active' : ''}} "><i class="fa fa-address-book fa-lg m-r-5"></i><span class="d-none d-lg-inline m-l-5">Information</span>&nbsp;</a></li>
        @if(isset($contactEmergencyGuardian))
            @if($contactEmergencyGuardian->user_id == $patiente->id)
                <li class="nav-item"><a href="#nav-assign-service" data-toggle="tab" class="nav-link {{ $isVisibiliti == true && $isVisibilitiValue == 'services' ? 'active' : ''}}"><i class="fa fa-tags fa-lg m-r-5"></i><span class="d-none d-lg-inline m-l-5">Assign Services</span>&nbsp;</a></li>
                <li class="nav-item"><a href="#nav-documents" data-toggle="tab" class="nav-link {{ $isVisibiliti == true && $isVisibilitiValue == 'documents' ? 'active' : ''}}"><i class="fa fa-folder fa-lg m-r-5"></i><span class="d-none d-lg-inline m-l-5">Documents</span>&nbsp;</a></li>
                <li class="nav-item"><a href="#nav-assign-worker" data-toggle="tab" class="nav-link {{ $isVisibiliti == true && $isVisibilitiValue == 'assignWorker' ? 'active' : ''}}"><i class="fa fa-user-md fa-lg m-r-5"></i><span class="d-none d-lg-inline m-l-5">Assign Worker</span>&nbsp;</a></li>
            @endif
        @endif
    </ul>
	<!-- end nav-tabs -->

	<!-- begin tab-content -->
	<div class="tab-content">
		<!-- begin tab-pane -->
		<div class="tab-pane fade {{ $isVisibiliti == false ? 'show active' : ''}}" id="nav-information" >
			<!-- begin row -->
			<div>
                @include('patientes.show')
			</div>
			<!-- end row -->
		</div>
		<!-- end tab-pane -->
        @if(isset($contactEmergencyGuardian))
            @if($contactEmergencyGuardian->user_id == $userID)
                <!-- begin tab-pane -->
                <div class="tab-pane fade {{ $isVisibiliti == true && $isVisibilitiValue == 'services' ? 'show active' : ''}}"  id="nav-assign-service">
                    <!-- begin row -->
                    <div>
                        @include('service_assigneds.acordion')
                    </div>
                    <!-- end row -->
                </div>
                <!-- end tab-pane -->
                <!-- begin tab-pane -->
                <div class="tab-pane fade {{ $isVisibiliti == true && $isVisibilitiValue == 'documents' ? 'show active' : ''}}" id="nav-documents">
                    <!-- begin row -->
                    <div>
                        @include('document_user_files.table')
                    </div>
                    <!-- end row -->
                </div>
                <!-- end tab-pane -->
                <!-- begin tab-pane -->
                <div class="tab-pane fade {{ $isVisibiliti == true && $isVisibilitiValue == 'assignWorker' ? 'show active' : ''}}" id="nav-assign-worker">
                    <!-- begin row -->
                    <div>
                        @include('patientes.table_workerAssign')
                        
                    </div>
                    <!-- end row -->
                </div>
                <!-- end tab-pane -->
            @endif
        @endif
	</div>
	<!-- end panel -->
@endsection