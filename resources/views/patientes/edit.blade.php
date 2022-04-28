@extends('layouts.default')

@push('css')
	<link href="/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css" rel="stylesheet" />
@endpush

@section('content')
    @include('flash::message')
    @include('coreui-templates::common.errors')
    <div class="progress" style="height: 30px; margin-bottom: 20px;">
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
    </div>
    <!-- begin panel -->
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title"> Basic Data</h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <!-- <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a> -->
            </div>
        </div>
        <div class="panel-body">
            {!! Form::model($patiente, ['route' => ['patientes.update', $patiente->id], 'method' => 'patch']) !!}
                @include('patientes.fields')
            {!! Form::close() !!}
        </div>
    </div>
    <!-- end panel -->
@endsection

@push('scripts')
	<script src="/assets/plugins/moment/moment.js"></script>
	<script src="/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>
	<script src="/assets/plugins/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
@endpush
