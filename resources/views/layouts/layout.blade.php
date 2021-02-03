<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>UserStories</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        {{-- Styles --}}
        <link rel="stylesheet" href="/css/app.css">

        {{-- Scripts --}}
        
    </head>
    <body>
        <div id="app" class="mx-auto pb-4">
            <Nav-Bar></Nav-Bar>
            <div class="container">
                @yield('content')
                <router-view></router-view>
                <V-Offline
                    online-class="online"
                    offline-class="offline"
                    @detected-condition="amIOnline">
                </V-Offline>
            </div>
            
        </div>
        <script src="https://use.fontawesome.com/76a7da1dec.js"></script>
        <script src="/js/app.js"></script>
    </body>
</html>
