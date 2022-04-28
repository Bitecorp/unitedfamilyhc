<table id="tableWorkerTest" class="table table-striped table-bordered table-td-valign-middle">
    <thead>
        <tr>
            <th width="1%"></th>
            <th class="text-nowrap">Full Name</th>
            <th class="text-nowrap">Home Phone</th>
            <th class="text-nowrap">Email</th>
            <th class="text-nowrap">Role</th>
            <th class="text-nowrap">Status</th>
            <th class="text-nowrap">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($patientes as $key => $patiente)
            <tr data-id='{{ $patiente->id }}' id="data_{{ $key }}">
                <td width="1%" class="f-s-600 text-inverse">{{ $key + 1 }}</td>
                <td>{{ $patiente->first_name }} {{ $patiente->last_name }}</td>
                <td>{{ $patiente->home_phone }}</td>
                <td>{{ $patiente->email }}</td>
                @foreach($roles as $role)
                    @if($patiente->role_id == $role->id)
                        <td>{{ $role->name_role }}</td>
                    @endif
                @endforeach
                @foreach($status as $statu)
                    @if($patiente->statu_id == $statu->id)
                        @if($patiente->id <= 3)
                            <td>{{ $statu->name_status }}</td>
                        @elseif($patiente->id > 3)
                            <td>
                                {!! Form::model($patiente, ['route' => ['patientes.updateState', $patiente->id], 'method' => 'post', 'id' => "sendForm_$patiente->id"]) !!}
                                <!-- begin custom-switches -->
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" onclick="changeStatus('{{$patiente->id}}');"  class="custom-control-input" data-id="{{ $patiente->id }}" name="{{$patiente->id}}" id="Switch_{{$patiente->id}}" {{ $patiente->statu_id == 1 ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="Switch_{{$patiente->id}}"></label>
                                    </div>
                                <!-- end custom-switches -->
                                {!! Form::close() !!}
                            </td>
                        @endif
                    @endif
                @endforeach
                <td class="with-btn" nowrap>
                    @if($patiente->id > 3 )
                        {!! Form::open(['route' => ['patientes.destroy', $patiente->id], 'method' => 'delete']) !!}
                            <a href="{{ route('patientes.show', [$patiente->id]) }}" class='btn btn-sm btn-primary' ><i class="fa fa-eye"></i> Show </a>
                            @if(Auth::user()->role_id == 1)
                                {!! Form::button('<a><i class="fa fa-trash"></i> Delete </a>', ['type' => 'submit', 'class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                            @endif
                        {!! Form::close() !!}
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@push('scripts')
    <script>
        function changeStatus(dato) {
            $('#Switch_' + dato).change(function() {
                $('#sendForm_' + dato).submit();
            })
        };
    </script>
    <script>
        $(function () {
            if ($('#tableWorkerTest').length !== 0) {
                var options = {
                    dom: '<"dataTables_wrapper dt-bootstrap"<"row"<"col-xl-7 d-block d-sm-flex d-xl-block justify-content-center"<"d-block d-lg-inline-flex mr-0 mr-sm-3"l><"d-block d-lg-inline-flex"B>><"col-xl-5 d-flex d-xl-block justify-content-center"fr>>t<"row"<"col-sm-5"i><"col-sm-7"p>>>',
                    buttons: [
                        { extend: 'copy', className: 'btn-sm' },
                        { extend: 'csv', className: 'btn-sm' },
                        { extend: 'excel', className: 'btn-sm' },
                        { extend: 'pdf', className: 'btn-sm' },
                        { extend: 'print', className: 'btn-sm' }
                    ],
                    responsive: true,retrieve: true,
                    autoFill: true,
                    colReorder: true,
                    keys: true,
                    rowReorder: true,
                    select: true
                };

                if ($(window).width() <= 767) {
                    options.rowReorder = false;
                    options.colReorder = false;
                    options.autoFill = false;
                }
                $('#tableWorkerTest').DataTable(options);
            }
        });
    </script>
@endpush