<?php
    $variables = [
        [
            'dato' => 'Date 00/00/0000',
            'llamado' => '{{ date("d/m/Y") }}'
        ],
        [
            'dato' => 'Number Pag',
            'llamado' => "
                <script type='text/php'>
                    if (isset(&#36;pdf)){ &#36;pdf->page_script('&#36;pdf->text(280, 820, <&#36;PAGE_NUM>, &#36;fontMetrics->get_font(<fonts>), 10); '); }
                </script>
                "
            ],
    ];
?>

<div class="panel panel-inverse">
	<!-- end panel-heading -->
	<!-- begin panel-body -->
	<div class="panel-body">
        <div class="col-xs-12 ">
            <table id="tableVariablesGlobals" class="table table-striped table-bordered table-td-valign-middle">
                <thead>
                    <tr>
                        <th class="text-nowrap">Dato</th>
                        <th class="text-nowrap">Call</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($variables as $key => $variable)
                        <tr>
                            <td>{{ $variable['dato'] }}</td>
                            <td>{{ str_replace('&#36;', '$', $variable['llamado']) }}</td>
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
    &#36;(function () {
        &#36;('#tableVariablesGlobals').DataTable( {
            ordering: true,
            retrieve: true,
            paging: true,
            searching: true,
        });
    });
</script>
@endpush