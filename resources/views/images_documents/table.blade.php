<!-- begin page-header -->
    <!-- begin panel -->
		<div class="panel panel-inverse">
			<!-- end panel-heading -->
			<!-- begin panel-body -->
			<div class="panel-body">
                <div class="col-xs-12 ">
                    <table id="tableImagesFiles" class="table table-striped table-bordered table-td-valign-middle">
                        <thead>
                            <tr>
                                <th class="text-nowrap">Title</th>
                                <th class="text-nowrap">URL</th>
                                <th class="text-nowrap">For Background Image</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($imagesDocuments as $key => $imagesDocuments)
                                <tr>
                                    <td>{{ $imagesDocuments->title }}</td>
                                    <td>{{ asset('filesUsers/' . $imagesDocuments->file) }}</td>
                                    <td>{{ 'filesUsers/' . $imagesDocuments->file }}</td>
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
            $('#tableImagesFiles').DataTable( {
                retrieve: true,
                paging: true,
                searching: true
            });
        });
    </script>
@endpush