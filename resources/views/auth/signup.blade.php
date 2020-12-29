@extends('layouts.layout')

@section('content')
    
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-md">
    <img class="mx-auto h-12 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt="Workflow">
    <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
      Sign up
    </h2>
    <p class="mt-2 text-center text-sm text-gray-600 max-w">
      <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
        and start using User-Stories
      </a>
    </p>
  </div>

  <user-auth-form button-text="SignUp" :is-signup="true"></user-auth-form>

</div>

@endsection