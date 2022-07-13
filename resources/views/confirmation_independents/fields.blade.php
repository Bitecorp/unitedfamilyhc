<div class="row">
    <div class="col">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="independent_contractor" id="independent_contractor" value="1" {{ $confirmationIndependent->independent_contractor == 1 ? 'checked' : '' }}>
            <label class="form-check-label" for="independent_contractor">
                Independent Contractor
            </label>
        </div>
    </div>
    <div class="col">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="independent_contractor" id="w2_worker" value="2" {{ $confirmationIndependent->independent_contractor == 2 ? 'checked' : '' }}>
            <label class="form-check-label" for="w2_worker">
                W2 Worker
            </label>
        </div>
    </div>
</div>
@if($confirmationIndependent->personalEmpresa == 1 || ( $confirmationIndependent->independent_contractor == 1 && $confirmationIndependent->personalEmpresa == 2))
<div class="row" id="formPersonalEmpresa" name="formPersonalEmpresa">
    <div class="col col-md-12">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="personalEmpresa" id="personal" value="1" {{ $confirmationIndependent->personalEmpresa == 1 ? 'checked' : '' }}>
            <label class="form-check-label" for="personal">
                Individual
            </label>
        </div>
    </div>
    <div class="col col-md-12">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="personalEmpresa" id="empresa" value="2" {{ $confirmationIndependent->personalEmpresa == 2 ? 'checked' : '' }}>
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
            <input class="form-check-input" type="radio" name="personalEmpresa" id="personal" value="1" {{ $confirmationIndependent->personalEmpresa == 1 ? 'checked' : '' }}>
            <label class="form-check-label" for="personal">
                Individual
            </label>
        </div>
    </div>
    <div class="col col-md-12">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="personalEmpresa" id="empresa" value="2" {{ $confirmationIndependent->personalEmpresa == 2 ? 'checked' : '' }}>
            <label class="form-check-label" for="empresa">
                Business
            </label>
        </div>
    </div>
</div>
@endif
<script>
    const radio = document.getElementById('independent_contractor');

    radio.addEventListener('change', (event) => {
        if (event.currentTarget.checked) {
            document.getElementById('formPersonalEmpresa').removeAttribute('hidden');
        } else {
            document.getElementById('formPersonalEmpresa').setAttribute('hidden', 'true');
        }
    })

    const radioTwo = document.getElementById('w2_worker');

    radioTwo.addEventListener('change', (event) => {
        if (event.currentTarget.checked) {
            document.getElementById('formPersonalEmpresa').setAttribute('hidden', 'true');
            document.getElementById('formCompanies').setAttribute('hidden', 'true');
        }
    })

    const radioTree = document.getElementById('empresa');

    radioTree.addEventListener('change', (event) => {
        if (event.currentTarget.checked) {
            document.getElementById('formCompanies').removeAttribute('hidden');
        }
    })

    const radioFour = document.getElementById('personal');

    radioFour.addEventListener('change', (event) => {
        if (event.currentTarget.checked) {
            document.getElementById('formCompanies').setAttribute('hidden', 'true');
        }
    })
</script>

<br></br>

@if($confirmationIndependent->independent_contractor == 1 && $confirmationIndependent->personalEmpresa == 2)
    <div id="formCompanies" name="formCompanies">
        @if(isset($companies))
            {!! Form::model($companies) !!}
        @endif
        @if((new \Jenssegers\Agent\Agent())->isDesktop())
            @include('companies.fields')
        @else
            @include('companies.fields_mobil')
        @endif
    </div>
@else
    <div id="formCompanies" name="formCompanies" hidden>
        @if((new \Jenssegers\Agent\Agent())->isDesktop())
            @include('companies.fields')
        @else
            @include('companies.fields_mobil')
        @endif
    </div>
@endif




<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Next', ['class' => 'btn btn-primary']) !!}
    <?php
        $link = "$_SERVER[REQUEST_URI]";
        $stringSeparado = explode('/', $link);
    ?>
    @if($stringSeparado[2] === 'create')
        <a href="{{ route('workers.index') }}" class="btn btn-secondary">Cancel</a>
    @else
        <a href="{{ route('workers.show', [$stringSeparado[2]]) }}" class='btn btn-success'>Show</a>
        <a href="{{ route('workers.index') }}" class="btn btn-secondary">Cancel</a>
    @endif
</div>
