@include('service_assigneds.create')
</br>
@if($servicesAssigned != null)

<!-- @include('sub_services.table')-->
<div id="accordion">
    @if(isset($collection))
        @foreach($collection AS $key => $value)
            <div class="card">
                <div class="card-header" style="padding: 0 !important;" id="heading{{ $value->id }}">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse{{ $value->id }}" aria-expanded="false" aria-controls="collapse{{ $value->id }}">
                            {{ $value->name_service }}
                        </button>
                    </h5>
                </div>

                <div id="collapse{{ $value->id }}" class="collapse" aria-labelledby="heading{{ $value->id }}" data-parent="#accordion">
                    <div class="card-body">
                        @if(isset($subServices))
                            @include('salary_service_assigneds.table')
                        @endif
                    </div>
                </div>
            </div>
            </br>
        @endforeach
    @endif
</div>
@endif
<!-- Submit Field -->
<div style="margin-top: 20px; margin-bottom: 20px;" class="form-group col-sm-12">
    <a href="{{ route('workers.edit', [$worker->id]) }}" class='btn btn-warning'><i class="fa fa-edit"></i> Edit </a>
    <a href="{{ route('workers.index') }}" class="btn btn-secondary">Back</a>
</div>