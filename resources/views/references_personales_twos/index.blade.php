@extends('layouts.default')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">References Personales Twos</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
             @include('flash::message')
             <div class="row">
                 <div class="col-lg-12">
                     <div class="card">
                         <div class="card-header">
                             <i class="fa fa-align-justify"></i>
                             ReferencesPersonalesTwos
                             <a class="pull-right" href="{{ route('referencesPersonalesTwos.create') }}"><i class="fa fa-plus-square fa-lg"></i></a>
                         </div>
                         <div class="card-body">
                             @include('references_personales_twos.table')
                              <div class="pull-right mr-3">
                                     
        @include('coreui-templates::common.paginate', ['records' => $referencesPersonalesTwos])

                              </div>
                         </div>
                     </div>
                  </div>
             </div>
         </div>
    </div>
@endsection

