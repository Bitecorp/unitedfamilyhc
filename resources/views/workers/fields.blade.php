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
            {!! Form::text('ssn', null, ['class' => 'form-control','maxlength' => 255, 'required' => true]) !!}
        </div>
    </div>
    <div class="col">
        <!-- Birth Date Field -->
        <div class="form-group">
            {!! Form::label('birth_date', 'Birth Date:') !!}
            {!! Form::text('birth_date', null, ['class' => 'form-control','id'=>'birth_date', 'required' => true]) !!}
        </div>
    </div>
    <div class="col">
        <!-- Marital Status Field -->
        <div class="form-group">
            {!! Form::label('marital_status', 'Marital Status:') !!}
            <select name='marital_status' class="form-control">
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
        var date = new Date();
        var dateOld = date.getFullYear() - 18 + '-' + String(date.getMonth()).padStart(2, '0') + '-' + String(date.getDate()).padStart(2, '0');
        $(function () {
            $('#birth_date').datetimepicker({
                format: 'YYYY-MM-DD',
                useCurrent: true,
                icons: {
                    up: "icon-arrow-up-circle icons font-2xl",
                    down: "icon-arrow-down-circle icons font-2xl"
                },
                sideBySide: true,
            });
        });
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
            <select name='role_id' class="form-control">
                @foreach($roles as $role)
                    @if(empty($worker))
                        <option value='{{ $role->id }}' {{ $role->id == '2' ? 'selected' : '' }} >{{ $role->name_role }}</option>
                    @else
                        <option value='{{ $role->id }}' {{ $worker->role_id == $role->id ? 'selected' : '' }} >{{ $role->name_role }}</option>
                    @endif
                @endforeach
            </select>
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
    {!! Form::submit('Next', ['class' => 'btn btn-primary']) !!}
    <?php
        $link = "$_SERVER[REQUEST_URI]";
        $stringSeparado = explode('/', $link);
    ?>
    @if($stringSeparado[2] === 'create')
        <a href="{{ route('workers.index') }}" class="btn btn-secondary">Cancel</a>
    @else
        @if(Auth::user()->role_id == 2)
        <a href="{{ route('workers.show', [$stringSeparado[2]]) }}" class='btn btn-secondary'>Back</a>
        @else
        <a href="{{ route('workers.show', [$stringSeparado[2]]) }}" class='btn btn-success'>Back</a>
        <a href="{{ route('workers.index') }}" class="btn btn-secondary">Cancel</a>
        @endif
    @endif
</div>