@extends('layouts.default')

@push('css')
	<link href="/assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables.net-select-bs4/css/select.bootstrap4.min.css" rel="stylesheet" />
@endpush

<?php

    $options = [
        '1' => 'Email',
        '0' => 'Document',
        '2' => 'Others'
    ];
?>

@section('content')
        @include('flash::message')
        <!-- begin panel -->
			<div class="panel panel-inverse">
				<!-- begin panel-heading -->
				<div class="panel-heading">
                    <h4 class="panel-title">
                        @if (strpos(Request::url(), "documentsEditors"))
                            Documents Editors
                        @elseif (strpos(Request::url(), "templatesEditors"))
                            Templates Editors
                        @endif
                    </h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="{{ strpos(Request::url(), "documentsEditors") ? route('documentsEditors.create') : (strpos(Request::url(), "templatesEditors") ? route('templatesEditors.create') : null )}}" class="btn btn-xs btn-icon btn-circle btn-primary" class="pull-right"><i class="fa fa-plus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                </div>
				<!-- end panel-heading -->
				<!-- begin panel-body -->
				<div class="panel-body">
                    <div class="col-xs-12 ">
                        <table id="tablaDocumentsEditors" class="table table-striped table-bordered table-td-valign-middle">
                            <thead>
                                @if (strpos(Request::url(), "documentsEditors"))
                                <tr>
                                    <th width="1%"></th>
                                    <th class="text-nowrap">Document</th>
                                    <th class="text-nowrap">Rol</th>
                                    <th class="text-nowrap">Service</th>
                                    <th class="text-nowrap">Action</th>
                                </tr>
                                @elseif (strpos(Request::url(), "templatesEditors"))
                                    <tr>
                                        <th width="1%"></th>
                                        <th class="text-nowrap">Template</th>
                                        <th class="text-nowrap">Type</th>
                                        <th class="text-nowrap">Action</th>
                                    </tr>
                                @endif
                            </thead>
                            <tbody>
                                @if (strpos(Request::url(), "documentsEditors"))
                                    @foreach($documentsEditors->where('isTemplate', 0) as $key => $documentsEditors)
                                        <tr>
                                            <td width="1%" class="f-s-600 text-inverse">{{ $key + 1 }}</td>
                                            <td>{{ $documentsEditors->name_document_editor }}</td>
                                            <td>
                                            @foreach($roles AS $key => $role)
                                                @if($documentsEditors->role_id == $role->id)
                                                    {{ $role->name_role }}
                                                @endif
                                            @endforeach
                                            </td>
                                            <td>
                                            @if($documentsEditors->service_id == 0)
                                                ALL
                                            @else
                                                @foreach($services AS $service)
                                                    @if($documentsEditors->service_id == $service->id)
                                                        {{$service->name_service}}
                                                    @endif
                                                @endforeach
                                            @endif
                                            </td>
                                            <td class="with-btn" nowrap>
                                                {!! Form::open(['route' => ['documentsEditors.destroy', $documentsEditors->id], 'method' => 'delete']) !!}
                                                <div>
                                                    <!-- <a href="{{ route('documentsEditors.show', [$documentsEditors->id]) }}" class='btn btn-sm btn-success'><i class="fa fa-eye"></i> Show </a> -->
                                                    <a href="{{ route('documentsEditors.edit', [$documentsEditors->id]) }}" class='btn btn-sm btn-info'><i class="fa fa-edit"></i> Edit </a>
                                                    {!! Form::button('<a><i class="fa fa-trash"></i> Delete </a>', ['type' => 'submit', 'class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                                                </div>
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                @elseif (strpos(Request::url(), "templatesEditors"))
                                    @foreach($documentsEditors->where('isTemplate', 1) as $key => $documentsEditors)
                                        <tr>
                                            <td width="1%" class="f-s-600 text-inverse">{{ $key + 1 }}</td>
                                            <td>{{ $documentsEditors->name_document_editor }}</td>
                                            <td>
                                                @if (intval($documentsEditors->type_template) == 0)
                                                    Document
                                                @elseif (intval($documentsEditors->type_template) == 1)
                                                    Email
                                                @elseif (intval($documentsEditors->type_template) == 2)
                                                    Other
                                                @endif
                                            </td>
                                            <td class="with-btn" nowrap>
                                                {!! Form::open(['route' => ['documentsEditors.destroy', $documentsEditors->id], 'method' => 'delete']) !!}
                                                <div>
                                                    <!-- <a href="{{ route('documentsEditors.show', [$documentsEditors->id]) }}" class='btn btn-sm btn-success'><i class="fa fa-eye"></i> Show </a> -->
                                                    <a href="{{ route('templatesEditors.edit', [$documentsEditors->id]) }}" class='btn btn-sm btn-info'><i class="fa fa-edit"></i> Edit </a>
                                                    {!! Form::button('<a><i class="fa fa-trash"></i> Delete </a>', ['type' => 'submit', 'class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                                                </div>
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                    
                            </tbody>
                        </table>
                    </div>
				</div>
				<!-- end panel-body -->
			</div>
@endsection

@push('scripts')
    <script>
        $(function () {
            $('#tablaDocumentsEditors').DataTable( {
                responsive: true,
                retrieve: true,
                paging: true,
                searching: true,
            });
        });
    </script>
	<script src="/assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="/assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="/assets/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
	<script src="/assets/plugins/datatables.net-select/js/dataTables.select.min.js"></script>
	<script src="/assets/plugins/datatables.net-select-bs4/js/select.bootstrap4.min.js"></script>
	<script src="/assets/plugins/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
	<script src="/assets/plugins/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
	<script src="/assets/plugins/datatables.net-buttons/js/buttons.colVis.min.js"></script>
	<script src="/assets/plugins/datatables.net-buttons/js/buttons.flash.min.js"></script>
	<script src="/assets/plugins/datatables.net-buttons/js/buttons.html5.min.js"></script>
	<script src="/assets/plugins/datatables.net-buttons/js/buttons.print.min.js"></script>
	<script src="/assets/plugins/pdfmake/build/pdfmake.min.js"></script>
	<script src="/assets/plugins/pdfmake/build/vfs_fonts.js"></script>
	<script src="/assets/plugins/jszip/dist/jszip.min.js"></script>
	<script src="/assets/js/demo/table-manage-combine.demo.js"></script>
@endpush

