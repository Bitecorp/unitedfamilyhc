@extends('layouts.default')

@section('content')
    <ol class="breadcrumb">
          <li class="breadcrumb-item">
             <a href="{!! route('alertDocuments.index') !!}">Alert Documents</a>
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
                              <strong>Edit Alert Documents</strong>
                          </div>
                          <div class="card-body">
                              {!! Form::model($alertDocuments, ['route' => ['alertDocuments.update', $alertDocuments->id], 'method' => 'patch']) !!}

                              @include('alert_documents.fields')

                              {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
         </div>
    </div>
@endsection