<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        @fonts
        @vite(['resources/js/app.js', 'resources/css/app.css'])
    </head>

    <body class="bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center min-h-screen flex-col">
        @auth
            <div class="">
                <div id="app"></div>
            </div>
        @else
            <div class="flex flex-col gap-4 container max-w-3xs">
                <h1 class="text-lg font-bold text-white/50 mx-auto">You're not signed in</h1>
                <a class="bg-green-500/30 rounded-md px-3 py-1 font-bold text-green-500 flex justify-center" href="/login">
                    Go To Log In
                </a>
                <p class="text-white/30">This is just to demonstrate using php & blade - We could also do this inside Vue</p>
            </div>
        @endauth

        </body>
</html>
