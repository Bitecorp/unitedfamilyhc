@extends('layouts.default')

<?php
    $link = "$_SERVER[REQUEST_URI]";
    $stringSeparado = explode('/', $link);
    $urlUser = $stringSeparado[1];
    $isRequired = $contactEmergency->guardian == 0 ? true : false;
?>

@section('content')
    @include('flash::message')
    @include('coreui-templates::common.errors')
    <div class="progress" style="height: 30px; margin-bottom: 16.67px;">
        @if($urlUser == "workers")
            <div class="progress-bar progress-bar-striped bg-success"
                role="progressbar"
                style="width: 16.67%"
                aria-valuenow="16.67"
                aria-valuemin="0"
                aria-valuemax="100"
            > Worker Data </div>
            <div class="progress-bar progress-bar-striped bg-success"
                role="progressbar"
                style="width: 16.67%"
                aria-valuenow="16.67"
                aria-valuemin="0"
                aria-valuemax="100"
            > Emergency Contact </div>
            <div class="progress-bar progress-bar-striped bg-success"
                role="progressbar"
                style="width: 16.67%"
                aria-valuenow="16.67"
                aria-valuemin="0"
                aria-valuemax="100"
            > Job Information </div>
            <div class="progress-bar progress-bar-striped bg-success"
                role="progressbar"
                style="width: 16.67%"
                aria-valuenow="16.67"
                aria-valuemin="0"
                aria-valuemax="100"
            > Education </div>
            <div class="progress-bar progress-bar-striped bg-success"
                role="progressbar"
                style="width: 16.67%"
                aria-valuenow="16.67"
                aria-valuemin="0"
                aria-valuemax="100"
            > Independent Contractor </div>
        @elseif($urlUser == "patientes" || $contactEmergency->guardian == 1) 
            <div class="progress-bar progress-bar-striped bg-success"
                role="progressbar"
                style="width: 33.33%"
                aria-valuenow="33.33"
                aria-valuemin="0"
                aria-valuemax="100"
            > Patiente Data </div>
            <div class="progress-bar progress-bar-striped bg-success"
                role="progressbar"
                style="width: 33.33%"
                aria-valuenow="33.33"
                aria-valuemin="0"
                aria-valuemax="100"
            > Emergency Contact </div>
            <div class="progress-bar progress-bar-striped bg-success"
                role="progressbar"
                style="width: 33.33%"
                aria-valuenow="33.33"
                aria-valuemin="0"
                aria-valuemax="100"
            > Guardian </div>
        @endif
    </div>
    <!-- begin panel -->
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">  {{ $contactEmergency->guardian == 1 ? 'Guardian' : 'Contact Emergency'}}</h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <!-- <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a> -->
            </div>
        </div>
        <div class="panel-body">
            {!! Form::model($contactEmergency, ['route' => ['contactEmergencies.update', $contactEmergency->user_id], 'method' => 'patch']) !!}
                @include('contact_emergencies.fields')
            {!! Form::close() !!}
        </div>
    </div>
    <!-- end panel -->
@endsection
