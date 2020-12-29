@extends('layouts.layout')

@section('content')

<Project-Index v-bind:projects="{{$projects}}"></Project-Index>

@endsection

