<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>v-b — because learn some more</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        @vite(['resources/css/app.css'])
    </head>
    <body class="h-screen w-screen flex items-center justify-center">
        <div class="flex flex-col">
            <h1 class="text-8xl font-thin">vocabulary-builder</h1>
            <div class="flex flex-row justify-center space-x-12 mt-16 text-xs tracking-widest uppercase font-bold">
                <a href="/words">grid</a>
                <a href="/flashcards">flashcards</a>
                <a href="/random?count=5">randomizer</a>
                <a href="/words/create">new</a>
                <a href="/faq">FAQ</a>
            </div>
        </div>
    </body>
</html>
