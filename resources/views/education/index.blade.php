@extends('layouts.default')

@section('content')
    @include('flash::message')
	<!-- begin panel -->
	<div class="panel panel-inverse">
		<div class="panel-heading">
			<h4 class="panel-title">
                Education
            </h4>
			<div class="panel-heading-btn">
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                @if(Auth::user()->role_id == 1)
                    <a href="{{ route('education.create') }}" class="btn btn-xs btn-icon btn-circle btn-primary" class="pull-right"><i class="fa fa-plus"></i></a>
                @endif
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
			</div>
		</div>
		<div class="panel-body">
			@include('education.table')
            <div class="pull-right mr-3">
                @include('coreui-templates::common.paginate', ['records' => $education])
            </div>
		</div>
	</div>
	<!-- end panel -->
@endsection

