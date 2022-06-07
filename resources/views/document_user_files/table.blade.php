@push('css')
    <style type="text/css">
        .abs-center {
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
	<link href="/assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables.net-select-bs4/css/select.bootstrap4.min.css" rel="stylesheet" />
@endpush

<?php
    $isVisibiliti = false;
    $link = "$_SERVER[REQUEST_URI]";
    $stringSeparado = parse_url($link, PHP_URL_QUERY );
    $isVisibiliti =  isset($stringSeparado) && !empty($stringSeparado) && $stringSeparado == 'documents' ? true : false;

?>

<div id="accordion">
    <div class="card">
        <div class="card-header" style="padding: 0 !important;" id="headingOne">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    Documents Download
                </button>
            </h5>
        </div>

        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
                @include('document_user_files.table_download')
            </div>
        </div>
    </div>
    </br>
    <div class="card">
        <div class="card-header" style="padding: 0 !important;" id="headingFor">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFor" aria-expanded="false" aria-controls="collapseFor">
                    Documents Externals
                </button>
            </h5>
        </div>

        <div id="collapseFor" class="collapse" aria-labelledby="headingFor" data-parent="#accordion">
            <div class="card-body">
                @include('document_user_files.table_external')
            </div>
        </div>
    </div>
    </br>
    <div class="card">
        <div class="card-header" style="padding: 0 !important;" id="headingTwo">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Current Documents
                </button>
            </h5>
        </div>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
            <div class="card-body">
                @include('document_user_files.table_current')
            </div>
        </div>
    </div>
    </br>
    <div class="card">
        <div class="card-header" style="padding: 0 !important;" id="headingThree">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Documents Expired
                </button>
            </h5>
        </div>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
            <div class="card-body">
                @include('document_user_files.table_expired')
            </div>
        </div>
    </div>
</div>

<!-- Submit Field -->
<div style="margin-top: 20px; margin-bottom: 20px;" class="form-group col-sm-12">
    <a href="{{ route($worker->role_id == 4 ? 'patientes.edit' : 'workers.edit', [$worker->id]) }}" class='btn btn-warning'><i class="fa fa-edit"></i> Edit </a>
    @if(Auth::user()->role_id != 2)
        <a href="{{ route($worker->role_id == 4 ? 'patientes.index' : 'workers.index') }}" class="btn btn-secondary">Back</a>
    @endif
</div>

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