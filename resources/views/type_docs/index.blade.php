@extends('layouts.default')

@push('css')
	<link href="/assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables.net-select-bs4/css/select.bootstrap4.min.css" rel="stylesheet" />
@endpush

@section('content')
        @include('flash::message')
        <!-- begin panel -->
			<div class="panel panel-inverse">
				<!-- begin panel-heading -->
				<div class="panel-heading">
                    <h4 class="panel-title">
                        Type Documents
                    </h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="{{ route('typeDocs.create') }}" class="btn btn-xs btn-icon btn-circle btn-primary" class="pull-right"><i class="fa fa-plus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            </div>
                </div>
				<!-- end panel-heading -->
				<!-- begin panel-body -->
				<div class="panel-body">
                    <div class="col-xs-12 ">
                        <table id="data-table-combine" class="table table-striped table-bordered table-td-valign-middle">
                            <thead>
                                <tr>
                                    <th width="1%"></th>
                                    <th class="text-nowrap">Name</th>
                                    <th class="text-nowrap">Type</th>
                                    <th class="text-nowrap">Expired</th>
                                    <th class="text-nowrap">Role</th>
                                    <th class="text-nowrap">Service</th>
                                    <th class="text-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($typeDocs as $key => $typeDoc)
                                    <tr>
                                        <td width="1%" class="f-s-600 text-inverse">{{ $key + 1 }}</td>
                                        <td>{{ $typeDoc->name_doc }}</td>
                                        <td>{{ $typeDoc->document_certificate == '0' ? 'DOCUMENT' : 'CERTIFICATE'}}</td>
                                        <td>{{ $typeDoc->expired == '0' ? 'NOT EXPIRED' : 'EXPIRED'}}</td>
                                        <td>
                                            @foreach($roles as $role)
                                                {{ isset($typeDoc) && isset($typeDoc->role_id) && $typeDoc->role_id == $role->id ? $role->name_role : null }}
                                            @endforeach
                                        </td>
                                        <td>{{ $typeDoc->service_id }}</td>
                                        <td class="with-btn" nowrap>
                                            {!! Form::open(['route' => ['typeDocs.destroy', $typeDoc->id], 'method' => 'delete']) !!}
                                            <div>
                                                <!-- <a href="{{ route('typeDocs.show', [$typeDoc->id]) }}" class='btn btn-sm btn-primary' ><i class="fa fa-eye"></i> Show </a> -->
                                                <a href="{{ route('typeDocs.edit', [$typeDoc->id]) }}" class='btn btn-sm btn-warning'><i class="fa fa-edit"></i> Edit </a>
                                                @if(Auth::user()->role_id == 1)
                                                    {!! Form::button('<a><i class="fa fa-trash"></i> Delete </a>', ['type' => 'submit', 'class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                                                @endif
                                            </div>
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
				</div>
				<!-- end panel-body -->
			</div>
@endsection

@push('scripts')

    <script>
        function test(dato) {
            $('#Switch_' + dato).change(function() {
                $('#sendForm_' + dato).submit();
            })
        };
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

