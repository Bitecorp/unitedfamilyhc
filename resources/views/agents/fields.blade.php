<div class="row">
    <div class="col">
        <!-- First Name Field -->
        <div class="form-group">
            {!! Form::label('first_name', 'First Name:') !!}
            {!! Form::text('first_name', null, ['class' => 'form-control','maxlength' => 255, 'required' => true]) !!}
        </div>
    </div>
    <div class="col">
        <!-- Mi Field -->
        <div class="form-group">
            {!! Form::label('mi', 'M.I.:') !!}
            {!! Form::text('mi', null, ['class' => 'form-control','maxlength' => 255]) !!}
        </div>
    </div>
    <div class="col">
        <!-- Last Name Field -->
        <div class="form-group">
            {!! Form::label('last_name', 'Last Name:') !!}
            {!! Form::text('last_name', null, ['class' => 'form-control','maxlength' => 255, 'required' => true]) !!}
        </div>
    </div>
    <div class="col">
        <!-- Companie Agent Field -->
        <div class="form-group">
            {!! Form::label('companie_agent', 'Companie:') !!}
            {!! Form::text('companie_agent', null, ['class' => 'form-control','maxlength' => 255, 'required' => true]) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <!-- Street Addres Field -->
        <div class="form-group">
            {!! Form::label('street_addres', 'Street Addres:') !!}
            {!! Form::text('street_addres', null, ['class' => 'form-control','maxlength' => 255, 'required' => true]) !!}
        </div>
    </div>
    <div class="col">
        <!-- Apartment Unit Field -->
        <div class="form-group">
            {!! Form::label('apartment_unit', 'Apartment/Unit:') !!}
            {!! Form::text('apartment_unit', null, ['class' => 'form-control','maxlength' => 255]) !!}
        </div>
    </div>
    <div class="col">
        <!-- City Field -->
        <div class="form-group">
            {!! Form::label('city', 'City:') !!}
            {!! Form::text('city', null, ['class' => 'form-control','maxlength' => 255, 'required' => true]) !!}
        </div>
    </div>
    <div class="col">
        <!-- Statu Field -->
        <div class="form-group">
            {!! Form::label('state', 'State:') !!}
            {!! Form::text('state', null, ['class' => 'form-control','maxlength' => 255, 'required' => true]) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <!-- Zip Code Field -->
        <div class="form-group">
            {!! Form::label('zip_code', 'Zip Code:') !!}
            {!! Form::text('zip_code', null, ['class' => 'form-control','maxlength' => 255, 'required' => true]) !!}
        </div>
    </div>
    <div class="col">
        <!-- Home Phone Field -->
        <div class="form-group">
            {!! Form::label('home_phone', 'Home Phone:') !!}
            {!! Form::text('home_phone', null, ['class' => 'form-control','maxlength' => 255, 'required' => true]) !!}
        </div>
    </div>
    <div class="col">
        <!-- Alternate Phone Field -->
        <div class="form-group">
            {!! Form::label('alternate_phone', 'Alternate Phone:') !!}
            {!! Form::text('alternate_phone', null, ['class' => 'form-control','maxlength' => 255]) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <!-- Ssn Field -->
        <div class="form-group">
            {!! Form::label('ssn', 'SSN:') !!}
            {!! Form::text('ssn', null, ['class' => 'form-control','maxlength' => 255]) !!}
        </div>
    </div>
    <div class="col">
        <!-- Date Expedition Field -->
        <div class="form-group">
            {!! Form::label('birth_date', 'Date Birth Date:') !!}
            <input type="date" placeholder="MM-DD-YYYY" name="birth_date" id="birth_date" class="form-control" value="{{ isset($worker) && !empty($worker) && isset($worker->birth_date) && !empty($worker->birth_date) ? date_format($worker->birth_date, 'Y-m-d') : '' }}">
        </div>
    </div>
    <div class="col">
        <!-- Marital Status Field -->
        <div class="form-group">
            {!! Form::label('marital_status', 'Marital Status:') !!}
            <select name='marital_status' class="form-control">
                 <option value=''>Select Option...</option>
                @foreach($marital_status as $marital_statu)
                    @if(empty($worker))
                        <option value='{{ $marital_statu->id }}'>{{ $marital_statu->name_marital_status }}</option>
                    @else
                        <option value='{{ $marital_statu->id }}' {{ $worker->marital_status == $marital_statu->id ? 'selected' : '' }} >{{ $marital_statu->name_marital_status }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        
    </script>
@endpush

<div class="row">
    <div class="col">
        <!-- Email Field -->
        <div class="form-group">
            {!! Form::label('email', 'Email:') !!}
            {!! Form::email('email', null, ['class' => 'form-control','maxlength' => 255, 'required' => true]) !!}
        </div>
    </div>
    <div class="col">
        <!-- Role Id Field -->
        <div class="form-group">
            {!! Form::label('role_id', 'Role:') !!}
            @foreach($roles as $key => $role)
                @if($role->id == 5)
                    <input type="text" name="role_id" class="form-control" readonly value="{{ $role->name_role }}" >
                @endif
            @endforeach
        </div>
    </div>
    @if(empty($worker))
        <div class="col">
            <!-- Statu Id Field -->
            <div class="form-group">
                {!! Form::label('statu_id', 'Status:') !!}
                <select name='statu_id' class="form-control">
                    @foreach($status as $statu)
                        @if(empty($worker))
                            <option value='{{ $statu->id }}'>{{ $statu->name_status }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
    @else
        <div class="col" hidden>
            <!-- Statu Id Field -->
            <div class="form-group">
                {!! Form::label('statu_id', 'Status:') !!}
                {!! Form::text('statu_id', null, ['class' => 'form-control','id'=>'statu_id', 'readonly' => true]) !!}
            </div>
        </div>
    @endif
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <?php
        $link = "$_SERVER[REQUEST_URI]";
        $stringSeparado = explode('/', $link);
    ?>
    @if($stringSeparado[2] === 'create')
        <a href="{{ route('agents.index') }}" class="btn btn-secondary">Cancel</a>
    @else
        <a href="{{ route('agents.show', $worker->id) }}" class="btn btn-success">Show</a>
        <a href="{{ route('agents.index') }}" class="btn btn-secondary">Cancel</a>
    @endif
</div>