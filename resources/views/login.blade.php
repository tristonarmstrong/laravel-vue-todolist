<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        @fonts
        @vite(['resources/js/app.js', 'resources/css/app.css'])

    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        <div class="flex flex-col gap-4 container max-w-3xs">
            <h1 class="text-lg font-bold text-white/50 mx-auto">Go ahead and authenticate</h1>

            @error('bad_login')
                <p class="bg-yellow-500/30 text-yellow-500 rounded-lg font-bold px-2 py-1">{{ $message }}</p>
            @enderror
            <form action="{{ route('login.submit') }}" method="POST" class="flex flex-col gap-1">
                @csrf
                <input id="email" name="email" type="email" placeholder="Email" class="bg-white/10 px-4 py-2 rounded-lg text-white"/>
                <input id="password" name="password" type="Password" placeholder="Password" class="bg-white/10 px-4 py-2 rounded-lg text-white"/>
                <button type="submit" class="bg-green-500/30 rounded-md px-3 py-1 font-bold text-green-500 flex justify-center hover:bg-green-500/35 cursor-pointer" href="/login">
                    Login
                </button>
            </form>
            <ul class="text-white/50 flex flex-col">
                <li class="flex justify-between"><strong>Email:</strong> test@example.com</li>
                <li class="flex justify-between"><strong>Password:</strong> password</li>
            </ul>
            <p class="text-white/30">This is another php/blade page (no vue yet)</p>

            <p class="text-white/30"><strong>Note:</strong> I did no input validation or sanitization - j/s</p>
        </div>
    </body>
</html>
