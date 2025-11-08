<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>faq — become expert in using vb</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        @vite(['resources/css/app.css'])
    </head>
    <body class="h-screen w-screen flex items-center justify-center">
        <div class="flex flex-col text-center">
            <h1 class="text-8xl font-thin">Usage</h1>
            <div class="ml-8 text-xl">
                <p>— <a href="/words"><strong>Grid</strong></a> to see your whole list of words. Words you mastered are shown in green color. —</p>
                <p>— <a href="/flashcards"><strong>Flashcards</strong></a> to test your knowledge. Only shows words not mastered yet. You can reveal meaning and excerpt. —</p>
                <p>— <a href="/random?count=5"><strong>Randomizer</strong></a> to randomly choose words from your pool. Write something with them! —</p>
                <p>— <a href="/words/create"><strong>New</strong></a> to save a new word. —</p>
                <p>— <a href="/words#searchInput"><strong>Search</strong></a> to filter through your words. Filters by spelling or excerpt. —</p>
            </div>
            <h1 class="text-8xl font-thin">Keyboard Shortcuts</h1>
            <div class="text-xl">
                <p>— Every time you see the menu at the bottom, press `/` to go straight to the <a href="/words#searchInput"><strong>search</strong></a> field, and start typing. Then press enter to filter. —</p>
                <p>— In <a href="/flashcards"><strong>flashcards</strong></a> mode, press `u` to show the word usage; press `d` to show the word definition. Press `r`, `←` or `→` to get another flashcard. —</p>
            </div>
            <p>
                <small>vocabulary-builder version 0.3.0</small>
            </p>
        </div>
    </body>
</html>
