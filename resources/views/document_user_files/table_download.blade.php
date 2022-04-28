<div class="panel panel-inverse">
	<!-- begin panel-body -->
	<div class="panel-body">
        <div class="col-xs-12 ">
            <table id="tableDocumentsTest" class="table table-striped table-bordered table-td-valign-middle">
                <thead>
                    <tr>
                        <th class="text-nowrap">Document</th>
                        <th class="text-nowrap">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documentsEditors as $key => $documentsEditors)
                        <tr>
                            <td>{{ $documentsEditors->name_document_editor }}</td>
                            <td class="with-btn" nowrap>
                                <a href="{{ route('workers.pdf', [$worker->id, $documentsEditors->id]) }}" target="_blanck" class='btn btn-info'><i class="fa fa-file"></i> Download PDF</a>
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
        $(function () {
            $('#tableDocumentsTest').DataTable( {
                retrieve: true,
                paging: true,
                searching: true
            });
        });
    </script>
@endpush
