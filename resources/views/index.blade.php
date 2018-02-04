@extends('layouts.app')
@include('forms.base')
@section('content')
    <div class="jumbotron">
        <h1 class="display-3">{{ __('index.welcome') }}</h1>
        <p class="lead">{{ __('index.welcome_message') }}</p>
        <p class="pull-right"><a href="/en">en</a>/<a href="/fr">fr</a>/<a href="/nl">nl</a></p>
    </div>
    <div class="alert alert-danger print-error-msg" style="display: none">
        <ul>
        </ul>
    </div>
    {!! Form::open(['url' => ['register'], 'method' => 'post', 'role'=> 'form', 'class' => 'form', 'novalidate' => 'novalidate']) !!}
    <div class="col-lg-12 well">
        <div class="form-row">
            <div class="form-group col-lg-6">
                {{Form::label('last_name', __('index.family_name'))}}
                {{Form::text('last_name', null, ['class' => 'form-control', 'required' => 'required'])}}
            </div>
            <div class="form-group col-lg-6">
                {{Form::label('address', __('index.address'))}}
                {{Form::text('address', null, ['class' => 'form-control', 'required' => 'required'])}}
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-lg-6">
                {{Form::label('phone', __('index.phone'))}}
                {{Form::text('phone', null, ['class' => 'form-control', 'required' => 'required'])}}
            </div>
            <div class="form-group col-lg-6">
                {{Form::label('email', __('index.email'))}}
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
        <button class="btn btn-primary pull-right" type="button"
                v-on:click="addPerson()">{{ __('index.add_person') }}</button>
        {{Form::submit(__('index.submit'), ['class' => 'btn btn-primary', 'id' =>'submit'])}}
    </div>
    {!! Form::close() !!}
@endsection