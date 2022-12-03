@extends('layouts.default')

@section('content')
    @include('coreui-templates::common.errors')
    <!-- begin panel -->
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Banck</h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <!-- <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a> -->
            </div>
        </div>
        <div class="panel-body">
            {!! Form::model($bank, ['route' => ['banks.update', $bank->id], 'method' => 'patch']) !!}
                @include('banks.fields')
            {!! Form::close() !!}
        </div>
    </div>
    <!-- end panel -->
@endsection
