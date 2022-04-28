@extends('layouts.default')

@section('content')
    <div class="container-fluid">
         <div class="animated fadeIn">
             @include('coreui-templates::common.errors')
             <div class="row">
                 <div class="col-lg-12">
                      <div class="card">
                          <div class="card-header">
                              <i class="fa fa-edit fa-lg"></i>
                              <strong>Edit Services Assigneds</strong>
                          </div>
                          <div class="card-body">
                              {!! Form::model($serviceAssigneds, ['route' => ['serviceAssigneds.update', $serviceAssigneds->id], 'method' => 'patch']) !!}

                              @include('service_assigneds.fields')

                              {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
         </div>
    </div>
@endsection