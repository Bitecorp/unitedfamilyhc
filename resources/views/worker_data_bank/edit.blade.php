@extends('layouts.default')

@push('css')
    <link href="../assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
	<script src="../assets/plugins/select2/dist/js/select2.min.js"></script>
@endpush

@section('content')
    @include('coreui-templates::common.errors')
    <!-- begin panel -->
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Edit Banck Account</h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <!-- <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a> -->
            </div>
        </div>
        <div class="panel-body">
            {!! Form::model($workerDataBank, ['route' => ['editBankAccount.update', $workerDataBank->id], 'method' => 'POST']) !!}
                @if((new \Jenssegers\Agent\Agent())->isDesktop())
                    @include('worker_data_bank.fields')
                @else
                    @include('worker_data_bank.fields_mobil')
                @endif 
            {!! Form::close() !!}
        </div>
    </div>
    <!-- end panel -->
@endsection


@push('scripts')
    <script>
        $(".default-select2").select2();
    </script>
@endpush