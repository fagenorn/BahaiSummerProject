@extends('layouts.app')
@include('forms.base')
@section('content')
    <div class="jumbotron">
        <h1 class="display-3">Welcome</h1>
        <p class="lead">Register yourself for the summerschool.</p>
    </div>
    {!! Form::open(['url' => 'register']) !!}
    <div class="col-lg-12 well">
        <div class="form-row">
            <div class="form-group col-lg-6">
                {{Form::label('family', 'Family')}}
                {{Form::text('family', null, ['class' => 'form-control'])}}
            </div>
            <div class="form-group col-lg-6">
                {{Form::label('address', 'Address')}}
                {{Form::text('address', null, ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-lg-6">
                {{Form::label('tel', 'Tel/GSM')}}
                {{Form::text('tel', null, ['class' => 'form-control'])}}
            </div>
            <div class="form-group col-lg-6">
                {{Form::label('email', 'E-Mail Address')}}
                {{Form::email('email', null, ['class' => 'form-control'])}}
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-lg-offset-2 well" id="peopleContainer">
        <div v-for="(person, index) in people" v-if="!person.destroyed">
            <div v-if="index !== 0" class="deletePerson">
            <span class='glyphicon glyphicon-remove'
                  v-on:click="deletePerson(index)"></span>
            </div>
            <person-form></person-form>
            <div v-if="index !== lastVisableIndex" class="divider"></div>
        </div>
        <button class="btn btn-primary pull-right" type="button" v-on:click="addPerson()">Add Person</button>
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    </div>
    {!! Form::close() !!}
@endsection