@push('css')
	<link href="/assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables.net-select-bs4/css/select.bootstrap4.min.css" rel="stylesheet" />
@endpush

    <!-- begin panel -->
    <div class="panel panel-inverse">
	    <!-- begin panel-heading -->
		<div class="panel-heading">
            <h4 class="panel-title">
                Banks
            </h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="{{ route('addBankAccount.create', $worker->id) }}" class="btn btn-xs btn-icon btn-circle btn-primary" class="pull-right"><i class="fa fa-plus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            </div>
        </div>
		<!-- end panel-heading -->
		<!-- begin panel-body -->
		<div class="panel-body">
            <div class="col-xs-12 ">
                <table id="tableBanksWorkers" class="table table-striped table-bordered table-td-valign-middle">
                    <thead>
                        <tr>
                            <th width="1%"></th>
                            <th class="text-nowrap">Bank</th>
                            <th class="text-nowrap">Account</th>
                            <th class="text-nowrap">Routing Number</th>
                            <th class="text-nowrap">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataBankUser as $key => $bank)
                            <tr>
                                <td width="1%" class="f-s-600 text-inverse">{{ $key + 1 }}</td>
                                <td>
                                    @foreach($banks as $keyb => $ban)
                                        @if ($ban->id == $bank->bank_id)
                                            {{ $ban->name_bank }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ $bank->account }}</td>
                                <td>{{ $bank->routing_number }}</td>
                                <td class="with-btn" nowrap>
                                    {!! Form::open(['route' => ['deleteBankAccount.destroy', $bank->id], 'method' => 'delete']) !!}
                                    <div>
                                        <a href="{{ route('editBankAccount.edit', [$worker->id, $bank->id]) }}" class='btn btn-sm btn-warning'><i class="fa fa-edit"></i> Edit </a>
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
@push('scripts')
    <script>
        $('#tableBanksWorkers').DataTable( {
            retrieve: true,
            paging: true,
            autoFill: true,
            responsive: true,
        });
    </script>
@endpush

@push('scripts')
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

