<div class="row">
    <div class="col">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="independent_contractor" id="independent_contractor" disabled readonly value="1" {{ $confirmationIndependent->independent_contractor == 1 ? 'checked' : '' }}>
            <label class="form-check-label" for="independent_contractor">
                Independent Contractor
            </label>
        </div>
    </div>
    <div class="col">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="independent_contractor" id="w2_worker" value="2" disabled readonly {{ $confirmationIndependent->independent_contractor == 2 ? 'checked' : '' }}>
            <label class="form-check-label" for="w2_worker">
                W2 Worker
            </label>
        </div>
    </div>
</div>

@if($confirmationIndependent->personalEmpresa == 1 ||( $confirmationIndependent->independent_contractor == 1 && $confirmationIndependent->personalEmpresa == 2))
<div class="row" id="formPersonalEmpresa" name="formPersonalEmpresa">
    <div class="col col-md-12">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="personalEmpresa" id="personal" disabled readonly value="1" {{ $confirmationIndependent->personalEmpresa == 1 ? 'checked' : '' }}>
            <label class="form-check-label" for="personal">
                Individual
            </label>
        </div>
    </div>
    <div class="col col-md-12">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="personalEmpresa" id="empresa" disabled readonly value="2" {{ $confirmationIndependent->personalEmpresa == 2 ? 'checked' : '' }}>
            <label class="form-check-label" for="empresa">
                Business
            </label>
        </div>
    </div>
</div>
@else
<div class="row" id="formPersonalEmpresa" name="formPersonalEmpresa" hidden>
    <div class="col col-md-12">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="personalEmpresa" id="personal" disabled readonly value="1" {{ $confirmationIndependent->personalEmpresa == 1 ? 'checked' : '' }}>
            <label class="form-check-label" for="personal">
                Individual
            </label>
        </div>
    </div>
    <div class="col col-md-12">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="personalEmpresa" id="empresa" disabled readonly value="2" {{ $confirmationIndependent->personalEmpresa == 2 ? 'checked' : '' }}>
            <label class="form-check-label" for="empresa">
                Business
            </label>
        </div>
    </div>
</div>
@endif

</br>

@if($confirmationIndependent->independent_contractor == 1 && $confirmationIndependent->personalEmpresa == 2)
   
        <div class="animated fadeIn">
            
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-plus-square-o fa-lg"></i>
                            <strong>Compani</strong>
                        </div>
                        <div class="card-body">
                            
                                <div class="col">
                                    <!-- First Name Field -->
                                    <div class="form-group">
                                        {!! Form::label('name', 'Name:') !!}
                                        <input type="text" name="name" class="form-control" readonly value="{{ isset($companies) && !empty($companies) ? $companies->name : ''  }}" >
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Mi Field -->
                                    <div class="form-group">
                                        {!! Form::label('street_addres', 'Street Addres:') !!}
                                        <input type="text" name="street_addres" class="form-control" readonly value="{{ isset($companies) && !empty($companies) ? $companies->street_addres : ''  }}" >
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Last Name Field -->
                                    <div class="form-group">
                                        {!! Form::label('apartment_unit', 'Apartment Unit:') !!}
                                        <input type="text" name="apartment_unit " class="form-control" readonly value="{{ isset($companies) && !empty($companies) ? $companies->apartment_unit : ''  }}" >
                                    </div>
                                </div>
                            
                                <div class="col">
                                    <!-- First Name Field -->
                                    <div class="form-group">
                                        {!! Form::label('city', 'City:') !!}
                                        <input type="text" name="city" class="form-control" readonly value="{{ isset($companies) && !empty($companies) ? $companies->city : ''  }}" >
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Mi Field -->
                                    <div class="form-group">
                                        {!! Form::label('state', 'State:') !!}
                                        <input type="text" name="state" class="form-control" readonly value="{{ isset($companies) && !empty($companies) ? $companies->state : ''  }}" >
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Last Name Field -->
                                    <div class="form-group">
                                        {!! Form::label('zip_code', 'Zip Code:') !!}
                                        <input type="text" name="zip_code " class="form-control" readonly value="{{ isset($companies) && !empty($companies) ? $companies->zip_code : ''  }}" >
                                    </div>
                                </div>
                            
                                <div class="col">
                                    <!-- First Name Field -->
                                    <div class="form-group">
                                        {!! Form::label('home_phone', 'Home Phone:') !!}
                                        <input type="text" name="chome_phone" class="form-control" readonly value="{{ isset($companies) && !empty($companies) ? $companies->home_phone : ''  }}" >
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Mi Field -->
                                    <div class="form-group">
                                        {!! Form::label('alternate_phone', 'Alternate Phone:') !!}
                                        <input type="text" name="alternate_phone" class="form-control" readonly value="{{ isset($companies) && !empty($companies) ? $companies->alternate_phone : ''  }}" >
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Last Name Field -->
                                    <div class="form-group">
                                        {!! Form::label('ssn', 'SSN:') !!}
                                        <input type="text" name="ssn " class="form-control" readonly value="{{ isset($companies) && !empty($companies) ? $companies->ssn : ''  }}" >
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Last Name Field -->
                                    <div class="form-group">
                                        {!! Form::label('email', 'Email:') !!}
                                        <input type="email" name="email " class="form-control" readonly value="{{ isset($companies) && !empty($companies) ? $companies->email : '' }}" >
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            
        </div>
   
@endif



