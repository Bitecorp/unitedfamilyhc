<?php 

$urlAct = Request::fullUrl();
//base64_decode(str_replace("%3D", "=", explode('=' ,explode('/', $urlAct)[8])))
//dd($urlAct, base64_decode(str_replace("%3D", "=", explode('=' ,explode('/', $urlAct)[8]))[1]));
//dd([intval(explode('/', $urlAct)[5]), intval(explode('/', $urlAct)[6]), intval(explode('/', $urlAct)[7]), intval(explode('/', $urlAct)[8])]);

$token = explode('?', str_replace("%3D", "=",explode('/', $urlAct)[8]))[1];
//dd(explode('?', str_replace("%3D", "=",explode('/', $urlAct)[8]))[1]);
?>

@extends('layouts.default')

@section('content')
    @include('coreui-templates::common.errors')
    @include('flash::message')
    <!-- begin panel -->
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">New Credi Memo</h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <!-- <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a> -->
            </div>
        </div>
        <div class="panel-body">
            {!! Form::open(['route' => 'reasonsMemos.addMemoForPai', 'id' => 'formMemoForPai']) !!}
                @include('reasons_memos.fieldsAddForPai')
            {!! Form::close() !!}
        </div>
    </div>
    <!-- end panel -->
@endsection