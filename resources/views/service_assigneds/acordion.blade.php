@include('service_assigneds.create')
</br>
@if($servicesAssigned != null)
<!-- @include('sub_services.table')-->
<div id="accordion">
    <div class="card">
        <div class="card-header" style="padding: 0 !important;" id="headingOne">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    Salary Services Assigneds
                </button>
            </h5>
        </div>

        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
                @include('salary_service_assigneds.table')
            </div>
        </div>
    </div>
</div>
@endif
<!-- Submit Field -->
<div style="margin-top: 20px; margin-bottom: 20px;" class="form-group col-sm-12">
    <a href="{{ route('workers.edit', [$worker->id]) }}" class='btn btn-warning'><i class="fa fa-edit"></i> Edit </a>
    <a href="{{ route('workers.index') }}" class="btn btn-secondary">Back</a>
</div>