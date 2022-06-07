@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
          <li class="breadcrumb-item">
             <a href="{!! route('configSubServicesPatientes.index') !!}">Config Sub Services Patiente</a>
          </li>
          <li class="breadcrumb-item active">Edit</li>
        </ol>
    <div class="container-fluid">
         <div class="animated fadeIn">
             @include('coreui-templates::common.errors')
             <div class="row">
                 <div class="col-lg-12">
                      <div class="card">
                          <div class="card-header">
                              <i class="fa fa-edit fa-lg"></i>
                              <strong>Edit Config Sub Services Patiente</strong>
                          </div>
                          <div class="card-body">
                              {!! Form::model($configSubServicesPatiente, ['route' => ['configSubServicesPatientes.update', $configSubServicesPatiente->id], 'method' => 'patch']) !!}

                              @include('config_sub_services_patientes.fields')

                              {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
         </div>
    </div>
@endsection