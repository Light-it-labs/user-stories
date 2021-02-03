@extends('layouts.layout')

@section('content')
    
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
  <User-Auth-Form button-text="SignUp" :is-signup="true"></User-Auth-Form>
</div>

@endsection