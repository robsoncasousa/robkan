<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>Robkan</title>

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body>
        <div id="app">
            <div class="header">
                <h1 class="header__title">Robkan</h1>
                <h2 class="header__subtitle">Kanban Board For Task Management</h2>
            </div>

            <main>
                <router-view></router-view>
            </main>
        </div>
        <script src="/js/app.js"></script>
    </body>
</html>
