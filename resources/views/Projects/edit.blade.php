@extends('layouts.layout')

@section('content')

<Project-Form v-bind:project-To-Edit="{{$project}}" title="Edit Project" button-text="Save"></Project-Form>
    
@endsection