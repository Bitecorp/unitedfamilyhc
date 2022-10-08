
<div class="row">
    <!-- <div class="col-6"> -->
        <div class="col">
            <div class="panel panel-inverse">
                <!-- begin panel-body -->
                <div class="panel-body">
                    <!-- <div class="col-xs-12 "> -->
                        <table id="tableDocumentsExpired" class="table table-striped table-bordered table-td-valign-middle">
                            <thead>
                                <tr>
                                    <th>Document</th>
                                    <th>Date Expedition</th>
                                    <th>Date Expired</th>
                                    <th>Expired document status</th>
                                    <th class="text-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($education))
                                    @if(isset($documentUserFiles) && !empty($documentUserFiles) && count(array($documentUserFiles)) >= 1)
                                        @foreach($documentUserFiles as $key => $documentUserFile)
                                            @if(count(array($filesUploads)) >= 1)
                                                @foreach($filesUploadsExpired as $key => $filesUpload)
                                                    @if($filesUpload->document_id == $documentUserFile->id && $filesUpload->expired >= 1)
                                                        <tr style="{{ $filesUpload->expired == 1 || $filesUpload->expired == '1' ? 'background-color: #30f2ef !important' : '' }}">
                                                            <td> {{ $documentUserFile->name_doc }} </td>
                                                            <td> {{ $filesUpload->date_expedition }} </td>
                                                            <td> {{ $filesUpload->date_expired }} </td>
                                                            <td> 
                                                                @if ($filesUpload->expired == 2 || $filesUpload->expired == '2')
                                                                    File updated
                                                                @else
                                                                    Waiting for update file
                                                                @endif
                                                            </td>
                                                            <td class="with-btn" nowrap>
                                                                <a onclick="vieFileExpired('{{ $filesUpload->file }}');" class='btn btn-sm btn-primary' style="color: #FFF;"><i class="fa fa-eye"></i> Show </a>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endif
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

        <div class="col">
            <div id='viewExpired' class="abs-center" >

            </div>
        </div>
    <!-- </div> -->
</div>

@push('scripts')
<script type="text/javascript">
    function vieFileExpired(valFileExpired) {
        var URLdomain = window.location.host;
        var protocol = location.protocol;
        var urlTotal = protocol + '//' + URLdomain + '/filesUsers/' + valFileExpired;
        var filenameWithExtension = (/[.]/.exec(valFileExpired)) ? /[^.]+$/.exec(valFileExpired)[0] : undefined;
        if(filenameWithExtension == 'pdf'){
            document.getElementById("viewExpired").innerHTML = '<embed src=' + urlTotal + ' type="application/pdf" width="100%" height="1000px" />';
        }else{
            document.getElementById("viewExpired").innerHTML = '<img max-height="1000px" width="100%" src=' + urlTotal + '>';
        }
    };
</script>
@endpush

@if((new \Jenssegers\Agent\Agent())->isDesktop())
    @push('scripts')
        <script>
            $(function () {
                $('#tableDocumentsExpired').DataTable({
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
                        [3, 'desc']
                    ]
                });
            });
        </script>
    @endpush
@else
    @push('scripts')
        <script>
            $(function () {
                $('#tableDocumentsExpired').DataTable({
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
                        [3, 'desc']
                    ]
                });
            });
        </script>
    @endpush
@endif

