@extends('layouts.default')

@push('css')

    .hide {
        display: none;
    }

    #signature-orientation-warning-holder i {
        position: fixed;
        top: 50%;
        left: 50%;
        font-size: 17px; 
        color: red;
        z-index: 3;
        width: 90%;
        transform: translate(-50%, -50%);
    }

    #signature-orientation-warning-holder {
        position: fixed;
        background-color: black;
        z-index: 9;
        padding: 0;
        margin: 0;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0.9;
    }

    button#show-signature-pad {
        box-shadow: -11px 10px 35px -1px rgba(0,0,0,0.75);
        background: black;
        cursor: pointer;
        padding: 15px;
        border: 2px solid white;
        color: #fff;
        margin-left: auto;
        margin-right: auto;
        display: block;
    }

    /* Real style */

    #signature-holder {
        position: fixed;
        padding: 0;
        margin: 0;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;  
    }

    #signature-holder canvas#signature {
        background-color: white;
        box-shadow: 0px 0px 20px 5px rgba(0,0,0,0.75);
        z-index: 1;  
        position: relative;
    }

    #signature-holder #signature-left-buttons-holder {
        position: absolute;
        top: 50%;
        z-index: 2;
        margin-top: -53px;
    }

    #signature-holder #signature-left-buttons-holder button {
        font-size: 30px;
        border-radius: 100%;
        border: none;
        width: 45px;
        height: 45px;
        display: block;
        margin: 0 0 30px 5px;
        border: 1px solid black;
    }
@endpush

@section('content')
    @include('coreui-templates::common.errors')
    <!-- begin panel -->
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">New Role</h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <!-- <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a> -->
            </div>
        </div>
        <div class="panel-body">
            {!! Form::open(['route' => 'notesSubServices.store']) !!}
                @include('notes.fields')
            {!! Form::close() !!}
        </div>
    </div>
    <!-- end panel -->
@endsection