@extends('layouts.layout')

@section('content')

<Project :project="{{$project}}" :epics="{{$epics}}"></Project>
    
@endsection