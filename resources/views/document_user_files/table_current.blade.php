<?php
    $user = $userID;
    $doc = '';
    $name = '';
?>
<div class="row">
    <!-- <div class="col-6"> -->
        <div class="col-6">
            <div class="panel panel-inverse">
                <!-- begin panel-body -->
                <div class="panel-body">
                    <!-- <div class="col-xs-12 "> -->
                        <table id="tableDocumentsCurrents" class="table table-striped table-bordered table-td-valign-middle">
                            <thead>
                                <tr>
                                    <th>Document</th>
                                    <th>Date Expedition</th>
                                    <th>Date Expired</th>
                                    <th class="text-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($education))
                                    @if(isset($documentUserFiles) && !empty($documentUserFiles) && count(array($documentUserFiles)) >= 1)
                                        @foreach($documentUserFiles as $key => $documentUserFile)
                                            <tr>
                                                <td>{{ $documentUserFile->name_doc }}</td>
                                                @if(count(array($filesUploads)) >= 1)
                                                    <td>
                                                        @foreach($filesUploads as $key => $filesUpload)
                                                            @if($filesUpload->document_id == $documentUserFile->id && $filesUpload->expired == 0)
                                                                {{ $filesUpload->date_expedition }}
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach($filesUploads as $key => $filesUpload)
                                                            @if($filesUpload->document_id == $documentUserFile->id && $filesUpload->expired == 0)
                                                                {{ !empty($filesUpload->date_expired) ? $filesUpload->date_expired : 'Not Expired' }}
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                @endif

                                                <td class="with-btn" nowrap>
                                                    @if(count(array($filesUploads)) >= 1)
                                                        @foreach($filesUploads as $key => $filesUpload)
                                                            @if($filesUpload->document_id == $documentUserFile->id && $filesUpload->expired == 0)
                                                                {!! Form::open(['route' => ['documentUserFiles.destroy', $filesUpload->id], 'method' => 'delete']) !!}
                                                                    <a onclick="vieFile('{{ $filesUpload->file }}');" class='btn btn-sm btn-primary' style="color: #FFF;"><i class="fa fa-eye"></i> Show </a>
                                                                    <a href="{{ route('documentUserFiles.uploadFileUpdate', [$userID, $filesUpload->id, $filesUpload->document_id ]) }}" class='btn btn-sm btn-warning'><i class="fa fa-edit"></i> Edit </a>
                                                                    @if(Auth::user()->role_id == 1)
                                                                        {!! Form::button('<a><i class="fa fa-trash"></i> Delete </a>', ['type' => 'submit', 'class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                                                                    @endif
                                                                {!! Form::close() !!}
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                    @if(count(array($filesUploads)) >= 1)
                                                        @foreach($filesUploads as $key => $filesUpload)
                                                            @if($filesUpload->document_id == $documentUserFile->id && $filesUpload->expired == 1)
                                                            <a href="#modal-alert" class="btn btn-sm btn-danger" data-toggle="modal">Demo</a>
                                                                <a href="{{ route('documentUserFiles.uploadFile', [$userID, $filesUpload->document_id]) }}" class='btn btn-sm btn-success' ><i class="fa fa-upload"></i> Upload </a>
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                    @if(isset($documentUserFilesDiffs) && !empty($documentUserFilesDiffs) && count(array($documentUserFilesDiffs)) >= 1)
                                                        @foreach($documentUserFilesDiffs as $key => $documentUserFilesDiff)
                                                            @if($documentUserFile->id == $documentUserFilesDiff->id)
                                                            <a href="#modal-alert" data-item-use-id={{ $userID }} data-item-doc-id={{ $documentUserFilesDiff->id }} class="btn btn-sm btn-danger" data-toggle="modal">Demo</a>
                                                                <a href="{{ route('documentUserFiles.uploadFile', [$userID, $documentUserFilesDiff->id]) }}" class='btn btn-sm btn-success' ><i class="fa fa-upload"></i> Upload </a>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endif
                            </tbody>
                        </table>
                    <!-- </div> -->
                </div>
                <!-- end panel-body -->
            </div>
        </div>

        <div class="col-6">
            <div id='view' class="abs-center" >

            </div>
        </div>
        <div class="modal fade" id="modal-alert">
			<div class="modal-dialog">
				<div class="modal-content">
				    <div class="modal-header">
						<h4 class="modal-title">Alert Header</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
                        {!! Form::open(['route' => ['documentUserFiles.docFileUpload', $user, $doc], 'method' => 'post', 'files' => true]) !!}
                            @include('document_user_files.fields')
                        {!! Form::close() !!}
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-white" data-dismiss="modal">Close</a>
						<a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Action</a>
					</div>
				</div>
			</div>
		</div>
    <!-- </div> -->
</div>

@push('scripts')
<script>
$(document).on("click", ".modal-open", function () {
    var foroId= $(this).attr('data-item-foro-id');
    var temaId= $(this).attr('data-item-tema-id');
    $("#foro_id").val(foroId);
    $("#tema_id").val(temaId);
});
</script>
<script type="text/javascript">
    function vieFile(valFile) {
        var URLdomain = window.location.host;
        var protocol = location.protocol;
        var urlTotal = protocol + '//' + URLdomain + '/filesUsers/' + valFile;
        var filenameWithExtension = (/[.]/.exec(valFile)) ? /[^.]+$/.exec(valFile)[0] : undefined;
        if(filenameWithExtension == 'pdf'){
            document.getElementById("view").innerHTML = '<embed src=' + urlTotal + ' type="application/pdf" width="100%" height="1000px" />';
        }else{
            document.getElementById("view").innerHTML = '<img max-height="1000px" width="100%" src=' + urlTotal + '>';
        }
    };
</script>
<script>
    $(function () {
        $('#tableDocumentsCurrents').DataTable( {
            retrieve: true,
            paging: true,
            searching: true
        });
    });
</script>
@endpush