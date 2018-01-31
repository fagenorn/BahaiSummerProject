@extends('layouts.app')
@include('forms.base')
@section('content')
    <div class="jumbotron">
        <h1 class="display-3">Welcome</h1>
        <p class="lead">The online registration form for the Belgian Bahá'í Summer School.</p>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {!! Form::open(['url' => ['register'], 'method' => 'post', 'role'=> 'form', 'class' => 'form']) !!}
    <div class="col-lg-12 well">
        <div class="form-row">
            <div class="form-group col-lg-6">
                {{Form::label('last_name', 'Family Name')}}
                {{Form::text('last_name', null, ['class' => 'form-control', 'required' => 'required'])}}
            </div>
            <div class="form-group col-lg-6">
                {{Form::label('address', 'Address')}}
                {{Form::text('address', null, ['class' => 'form-control', 'required' => 'required'])}}
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-lg-6">
                {{Form::label('phone', 'Tel/GSM')}}
                {{Form::text('phone', null, ['class' => 'form-control', 'required' => 'required'])}}
            </div>
            <div class="form-group col-lg-6">
                {{Form::label('email', 'Email')}}
                {{Form::email('email', null, ['class' => 'form-control', 'required' => 'required'])}}
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-lg-offset-2 well" id="peopleContainer">
        <div v-for="(person, index) in people" v-if="!person.destroyed">
            <div v-if="index !== 0" class="deletePerson">
            <span class='glyphicon glyphicon-remove'
                  v-on:click="deletePerson(index)"></span>
            </div>
            <person-form :index="index"></person-form>
            <div v-if="index !== lastVisableIndex" class="divider"></div>
        </div>
        <button class="btn btn-primary pull-right" type="button" v-on:click="addPerson()">Add Person</button>
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    </div>
    {!! Form::close() !!}
@endsection