<div class="row">
    <div class="col">
        <!-- First Name Field -->
        <div class="form-group">
            {!! Form::label('high_school', 'High School:') !!}
            <input type="text" name="first_name" class="form-control" readonly value="{{ $education->high_school }}" >
        </div>
    </div>
    <div class="col">
        <!-- Mi Field -->
        <div class="form-group">
            {!! Form::label('college_university', 'College University:') !!}
            <input type="text" name="mi" class="form-control" readonly value="{{ $education->college_university }}" >
        </div>
    </div>
</div>