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

    $selected = isset($documentsEditors) && isset($documentsEditors->type_template) ? $documentsEditors->type_template : 0;
?>

<div class="row">
    <div class="col">

        <div class="row">
            <div class="col">
                <div class="col">
                    <!-- Name Document Editor Field -->
                    <div class="form-group">
                        {!! Form::label('name_document_editor', 'Name Document Editor:') !!}
                        {!! Form::text('name_document_editor', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => true]) !!}
                    </div>
                </div>
            <div>
            <div class="col">
                <div class="row">
                    <div class="col">
                        <!-- Name Document Editor Field -->
                        <div class="form-group">
                            {!! Form::label('backgroundImg', 'Background Image:') !!}
                            {!! Form::text('backgroundImg', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            {!! Form::label('type_template', 'Type:') !!}
                            {!! Form::select('type_template', $options, $selected, ['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="col">
                        <!-- Service Id Field -->
                        <div class="form-group">
                            {!! Form::label('paginate', 'Paginate:') !!}
                            </br>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" name="paginate" id="paginate" {{ isset($documentsEditors) && isset($documentsEditors->paginate) && $documentsEditors->paginate == true ? 'checked' : '' }}>
                                <label class="custom-control-label" for="paginate"></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <!-- begin nav-tabs -->
                <ul id="ioniconsTab" class="nav nav-tabs nav-tabs-inverse">
                    <li class="nav-item"><a href="#nav-files" data-toggle="tab" class="nav-link active"><span class="d-none d-lg-inline m-l-5">Variables Files</span>&nbsp;</a></li>
                    <li class="nav-item"><a href="#nav-variables" data-toggle="tab" class="nav-link"><span class="d-none d-lg-inline m-l-5">Variables Data</span>&nbsp;</a></li>
                    <li class="nav-item"><a href="#nav-variables-services" data-toggle="tab" class="nav-link"><span class="d-none d-lg-inline m-l-5">Variables Services </span>&nbsp;</a></li>
                    <li class="nav-item"><a href="#nav-variables-globals" data-toggle="tab" class="nav-link"><span class="d-none d-lg-inline m-l-5">Variables Globals </span>&nbsp;</a></li>
                </ul>
                <!-- end nav-tabs -->

                <!-- begin tab-content -->
                <div id="ioniconsTabContent" class="tab-content">
                    <!-- begin tab-pane -->
                    <div class="tab-pane fade show active" style="margin-top: 20px;" id="nav-files" >
                        <!-- begin row -->
                        @include('images_documents.table')
                        <!-- end row -->
                    </div>
                    <!-- end tab-pane -->
                    <!-- begin tab-pane -->
                    <div class="tab-pane fade" style="margin-top: 20px;" id="nav-variables">
                        <!-- begin row -->
                        @include('documents_editors.table_variables')
                        <!-- end row -->
                    </div>
                    <!-- end tab-pane -->
                    <!-- begin tab-pane -->
                    <div class="tab-pane fade" style="margin-top: 20px;" id="nav-variables-services">
                        <!-- begin row -->
                        @include('documents_editors.table_variables_services')
                        <!-- end row -->
                    </div>
                    <!-- end tab-pane -->
                    <!-- begin tab-pane -->
                    <div class="tab-pane fade" style="margin-top: 20px;" id="nav-variables-globals">
                        <!-- begin row -->
                        @include('documents_editors.table_variables_globals')
                        <!-- end row -->
                    </div>
                    <!-- end tab-pane -->
                </div>
                <!-- end tab-content -->
                <!-- end panel -->
            </div>
        </div>
    </div>
    <div class="col">
        <!-- Content Field -->
        <div class="form-group">
            {!! Form::label('content', 'Content:') !!}
            {!! Form::textarea('content', null, ['class' => 'form-control content', 'id' => 'content']) !!}
        </div>
    </div>
</div>

<div class="form-group" hidden>
    {!! Form::label('url', 'Url:') !!}
    {!! Form::text('url', 'templates', ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => true]) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('templatesEditors.index') }}" class="btn btn-secondary">Cancel</a>
</div>

@push('scripts')
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector:'textarea.content',
        width: '100%',
        height: 600,
        menubar: 'file edit format table help',
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code wordcount',
            'image code table noneditable help',
        ],
        toolbar: 'newdocument | insertfile undo redo | cut copy paste | bold italic underline strikethrough removeformat forecolor backcolor | formatselect fontselect fontsizeselect styleselect | ' +
        'alignleft aligncenter alignright alignjustify | outdent indent | bullist numlist | table | ' +
        'image link | fullscreen preview print code ',
        /* without images_upload_url set, Upload tab won't show up*/
        images_upload_url: 'postAcceptor.php',
        /* we override default upload handler to simulate successful upload*/
        images_upload_handler: function (blobInfo, success, failure) {
            setTimeout(function () {
            /* no matter what you upload, we will turn it into TinyMCE logo :)*/
            success('http://moxiecode.cachefly.net/tinymce/v9/images/logo.png');
            }, 2000);
        },
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
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