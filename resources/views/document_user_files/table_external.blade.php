<div class="panel panel-inverse">
	<!-- begin panel-body -->
	<div class="panel-body">
        <div class="col">
            <table id="tableDocumentsExternals" class="table table-striped table-bordered table-td-valign-middle">
                <thead>
                    <tr>
                        <th class="text-nowrap">Document</th>
                        <th class="text-nowrap">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($externalDocuments))
                        @foreach($externalDocuments as $key => $externalDocuments)
                            @foreach($externalDocuments as $keyE => $externalDocument)
                                @if(isset($externalDocument) && !empty($externalDocument))
                                <tr>
                                    <td>{{ $externalDocument->title }}</td>
                                    <td class="with-btn" nowrap>
                                        <a href="{{ asset('filesUsers/' . $externalDocument->file) }}" target="_blanck" class='btn btn-info'><i class="fa fa-file"></i> Download PDF</a>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
	</div>
	<!-- end panel-body -->
</div>

@if((new \Jenssegers\Agent\Agent())->isDesktop())
    @push('scripts')
        <script>
            $(function () {
                $('#tableDocumentsExternals').DataTable( {
                    retrieve: true,
                    paging: true,
                    autoFill: true,
                });
            });
        </script>
    @endpush
@else
    @push('scripts')
        <script>
            $(function () {
                $('#tableDocumentsExternals').DataTable( {
                    retrieve: true,
                    paging: true,
                    autoFill: true,
                    responsive: true
                });
            });
        </script>
    @endpush
@endif

