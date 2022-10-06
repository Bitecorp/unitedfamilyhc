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
<p>{{ $companies }}</p>
    
@endif



