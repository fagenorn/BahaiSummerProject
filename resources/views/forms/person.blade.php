<div class="form-row">
    <div class="form-group col-md-6">
        {{Form::label('firstName', 'First Name')}}
        {{Form::text('firstName', null, ['class' => 'form-control'])}}
    </div>
    <div class="form-group col-md-6">
        {{Form::label('name', 'Name')}}
        {{Form::text('name', null, ['class' => 'form-control'])}}
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-6">
        {{Form::label('birthdate', 'Birthdate')}}
        {{Form::date('birthdate', null, ['class' => 'form-control'])}}
    </div>
    <div class="form-group col-md-6">
        {{Form::label('gender', 'Gender')}}
        {{Form::select('gender', ['M' => 'Male', 'F' => 'Female'], 'M', ['class' => 'form-control'])}}
    </div>
</div>
<div class="form-group col-md-12">
    {{Form::label('language', 'Language')}}
    {{Form::select('language', ['EN' => 'English', 'NL' => 'Nederlands', 'FR' => 'French'], 'En', ['class' => 'form-control'])}}
</div>
<div class="form-group col-md-12">
    <div class="form-check">
        {{Form::checkbox('veg', 'veg', null, ['class' => 'form-check-input', 'id' => 'veg'])}}
        {{Form::label('veg', 'Vegetarian', ['class' => 'form-check-label'])}}
    </div>
</div>