<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>UserStories</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        {{-- Styles --}}
        <link rel="stylesheet" href="/css/app.css">

        {{-- Scripts --}}
        
    </head>
    <body>
     
        <div class="dark:bg-gray-800 bg-green-400">
            <h1 class="text-4xl text-center font-bolder text-white">Welcome to Laravel with Tailwindcss!!</h1>
        </div>
        <div class="grid grid-cols-6 bg-white dark:bg-gray-800">
            <h1 class="text-gray-900 dark:text-white">Dark mode is here!</h1>
            <p class="text-gray-600 dark:text-gray-300">
              Lorem ipsum...
            </p>
          </div>
        <div id="app">
            
        </div>
        <script src="/js/app.js"></script>
    </body>
</html>
