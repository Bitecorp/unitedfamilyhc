@extends('layouts.default')

@section('content')
    <div class="panel panel-inverse">
		<!-- begin panel-heading -->
		<div class="panel-heading">
            <h4 class="panel-title">
                Note
            </h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-12 ">
                @include('notes.show_fields')
            </div>
        </div>
    </div>
@endsection
