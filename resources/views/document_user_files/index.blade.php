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
                        Documents
                    </h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <!-- <a href="{{ route('services.create') }}" class="btn btn-xs btn-icon btn-circle btn-primary" class="pull-right"><i class="fa fa-plus"></i></a> -->
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
                                   <th>Document</th>
                                    @if(isset($filesUploads) && count($filesUploads) >= 1)
                                        <th>Date Expedition</th>
                                        <th>Date Expired</th>
                                    @endif
                                    <th class="text-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($documentUserFiles as $key => $documentUserFiles)
                                    <tr>
                                        <td width="1%" class="f-s-600 text-inverse">{{ $key + 1 }}</td>
                                        <td>{{ $documentUserFiles->name_doc }}</td>
                                        @if(isset($filesUploads) && count($filesUploads) >= 1)
                                            @foreach($filesUploads as $key => $value)
                                                @if($value->document_id == $documentUserFiles->id)
                                                    <td>{{ $value->date_expedition }}</td>
                                                    <td>{{ $value->date_expired }}</td>
                                                @else
                                                    <td></td>
                                                    <td></td>
                                                @endif
                                            @endforeach
                                        @endif
                                        <td class="with-btn" nowrap>
                                            @if(isset($filesUploads) && count($filesUploads) >= 1)
                                                @foreach($filesUploads as $key => $value)
                                                    {!! Form::open(['route' => ['documentUserFiles.destroy', $value->id], 'method' => 'delete']) !!}
                                                    <div>
                                                        @if($value->document_id == $documentUserFiles->id)
                                                            <!--<p>{{ asset('storage/' . $value->file) }}</p>-->
                                                            <a href="{{ asset('filesUsers/' . $value->file) }}" target="_blank" class='btn btn-sm btn-primary' ><i class="fa fa-eye"></i> Show </a>
                                                            <!-- <a href="{{ route('documentUserFiles.edit', [$documentUserFiles->id]) }}" class='btn btn-sm btn-warning'><i class="fa fa-edit"></i> Update </a> -->
                                                            @if(Auth::user()->role_id == 1)
     {!! Form::button('<a><i class="fa fa-trash"></i> Delete </a>', ['type' => 'submit', 'class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
@endif
                                                        @else
                                                            <a href="{{ route('documentUserFiles.uploadFile', [$userID, $documentUserFiles->id]) }}" class='btn btn-sm btn-success' ><i class="fa fa-upload"></i> Upload </a>
                                                        @endif
                                                    </div>
                                                    {!! Form::close() !!}
                                                @endforeach
                                            @else
                                                <a href="{{ route('documentUserFiles.uploadFile', [$userID, $documentUserFiles->id]) }}" class='btn btn-sm btn-success' ><i class="fa fa-upload"></i> Upload </a>
                                            @endif
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






