<div class="row">
    <div class="col">
            @if(!(new \Jenssegers\Agent\Agent())->isDesktop())
                <div class="table-responsive">
            @endif
                        <table id="tableDocumentsCurrents" class="table table-striped table-bordered table-td-valign-middle">
                            <thead>
                                <tr>
                                    <th>Document</th>
                                    <th>Date Expedition</th>
                                    <th>Date Expired</th>
                                    <th>Type</th>
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
                                                <td>
                                                    @if ($documentUserFile->document_certificate == 0)
                                                        Document
                                                    @elseif ($documentUserFile->document_certificate == 1)
                                                        Certificate
                                                    @elseif ($documentUserFile->document_certificate == 2)
                                                        Personal Documents
                                                    @elseif ($documentUserFile->document_certificate == 3)
                                                        Agreements
                                                    @elseif ($documentUserFile->document_certificate == 4)
                                                        Others
                                                    @endif
                                                </td>

                                                <td class="with-btn" nowrap>
                                                    @if(count(array($filesUploads)) >= 1)
                                                        @foreach($filesUploads as $key => $filesUpload)
                                                            @if($filesUpload->document_id == $documentUserFile->id && $filesUpload->expired == 0)
                                                                @if($documentUserFile->isSol == 0)
                                                                    {!! Form::open(['route' => ['documentUserFiles.destroy', $filesUpload->id], 'method' => 'delete']) !!}
                                                                        <a onclick="vieFile('{{ $filesUpload->file }}');" class='btn btn-sm btn-primary' style="color: #FFF;"><i class="fa fa-eye"></i> Show </a>
                                                                        @if((new \Jenssegers\Agent\Agent())->isDesktop())
                                                                            <br>
                                                                            <a href="{{ route('documentUserFiles.uploadFileUpdate', [$userID, $filesUpload->id, $filesUpload->document_id ]) }}" class='btn btn-sm btn-warning mt-1 mb-1'><i class="fa fa-edit"></i> Edit </a>
                                                                            <br>
                                                                        @else
                                                                            <a href="{{ route('documentUserFiles.uploadFileUpdate', [$userID, $filesUpload->id, $filesUpload->document_id ]) }}" class='btn btn-sm btn-warning'><i class="fa fa-edit"></i> Edit </a>
                                                                        @endif
                                                                        @if(Auth::user()->role_id == 1)
                                                                            {!! Form::button('<a><i class="fa fa-trash"></i> Delete </a>', ['type' => 'submit', 'class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                                                                        @endif
                                                                    {!! Form::close() !!}
                                                                @else
                                                                    <a onclick="vieFile('{{ $filesUpload->file }}');" class='btn btn-sm btn-primary' style="color: #FFF;"><i class="fa fa-eye"></i> Show </a>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                    @if(count(array($filesUploads)) >= 1)
                                                        @foreach($filesUploads as $key => $filesUpload)
                                                            @if($filesUpload->document_id == $documentUserFile->id && $filesUpload->expired == 1 && $documentUserFile->isSol == 0)
                                                                <a href="{{ route('documentUserFiles.uploadFile', [$userID, $filesUpload->document_id]) }}" class='btn btn-sm btn-success' ><i class="fa fa-upload"></i> Upload </a>
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                    @if(isset($documentUserFilesDiffs) && !empty($documentUserFilesDiffs) && count(array($documentUserFilesDiffs)) >= 1)
                                                        @foreach($documentUserFilesDiffs as $key => $documentUserFilesDiff)
                                                            @if($documentUserFile->id == $documentUserFilesDiff->id && $documentUserFile->isSol == 0)
                                                                <a href="{{ route('documentUserFiles.uploadFile', [$userID, $documentUserFilesDiff->id]) }}" class='btn btn-sm btn-success' ><i class="fa fa-upload"></i> Upload </a>
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                    <!-- begin custom-switches -->
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" onclick="documentIsSol('{{ $userID }}', '{{ $documentUserFile->id }}', '{{ $documentUserFile->isSol }}');"  class="custom-control-input" name="Switch_{{ $documentUserFile->id  }}_{{ $userID }}" id="Switch_{{ $documentUserFile->id }}_{{ $userID }}" {{ $documentUserFile->isSol == 0 ? 'checked' : '' }} {{ Auth::user()->role_id != 1 ? 'disabled' : '' }}>
                                                            <label class="custom-control-label" for="Switch_{{ $documentUserFile->id }}_{{ $userID }}">{{ $documentUserFile->isSol == 0 ? 'Required' : 'Not required' }}</label>
                                                        </div>
                                                    <!-- end custom-switches -->
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endif
                            </tbody>
                        </table>
            @if(!(new \Jenssegers\Agent\Agent())->isDesktop())
                </div>
            @endif
    </div>

    <div class="col">
        <div id='view' class="abs-center" >

        </div>
    </div>
</div>

@push('scripts')
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


    function documentIsSol(userId, documentId, isSolDat) {
        var user_id = userId;
        var document_id = documentId;
        var isSol = isSolDat;
        var url = "/docIsSol";
        var token = '{{ csrf_token() }}';

        $.ajax({
            type: "post",
            url: url,
            dataType: 'json',
            data: {
            _token: token,
            user_id: user_id,
            document_id: document_id,
            isSol: isSol
        },
            success: function(data) {
                var textLocation = window.location.href;
                if(textLocation.includes('documents')){
                    location.reload(true);
                }else{
                    location.href = location + '?documents';
                }
            },
            error: function (error) { 
                console.log(error);
            }
        })
    };
</script>
@endpush

@if((new \Jenssegers\Agent\Agent())->isDesktop())
    @push('scripts')
        <script>
            $(document).ready(function () {
                $('#tableDocumentsCurrents').DataTable({
                    retrieve: true,
                    paging: true,
                    autoFill: true,
                    columnDefs: [
                        { 
                            orderable: false, 
                            targets: 0
                        }
                    ],
                    order: [
                        [3, 'asc']
                    ]
                });
            });
        </script>
    @endpush
@else
    @push('scripts')
        <script>
        $(document).ready(function () {
            $('#tableDocumentsCurrents').DataTable({
                    retrieve: true,
                    paging: true,
                    autoFill: true,
                    responsive: true,
                    columnDefs: [
                        { 
                            orderable: false, 
                            targets: 0
                        }
                    ],
                    order: [
                        [3, 'asc']
                    ]
                });
            });
        </script>
    @endpush
@endif