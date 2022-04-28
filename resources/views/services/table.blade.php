<div class="table-responsive-sm">
    <table class="table table-striped" id="jobInformations-table">
        <thead>
            <tr>
                <th>Service</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($services as $service)
            <tr>
                <td>{{ $service->name_service }}</td>
                <td class="with-btn" nowrap>
                    {!! Form::open(['route' => ['services.destroy', $service->id], 'method' => 'delete']) !!}
                    <div>
                        <a href="{{ route('services.show', [$service->id]) }}" class='btn btn-sm btn-success'><i class="fa fa-eye"></i> Show  </a>
                        <a href="{{ route('services.edit', [$service->id]) }}"class='btn btn-sm btn-info'><i class="fa fa-edit"></i> Edit </a>
                        @if(Auth::user()->role_id == 1)
                            {!! Form::button('<a><i class="fa fa-trash"></i> Delete </a>', ['type' => 'submit', 'class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                        @endif
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>