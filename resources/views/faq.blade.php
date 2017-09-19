<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>faq — become expert in using vb</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="/css/app.css" rel="stylesheet">

        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .content {
                text-align: center;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content container">

                <div class="main-word m-b-md text-center">Usage</div>
                <p class="lead">— <a href="{{ url('/words') }}"><strong>Grid</strong></a> to see your whole list of words. Words you mastered are shown in green color. —</p>
                <p class="lead">— <a href="{{ url('/flashcards') }}"><strong>Flashcards</strong></a> to test your knowledge. Only shows words not mastered yet. You can reveal meaning and excerpt. —</p>
                <p class="lead">— <a href="{{ url('/random?count=5') }}"><strong>Randomizer</strong></a> to randomly choose words from your pool. Write something with them! —</p>
                <p class="lead">— <a href="{{ url('/words/create') }}"><strong>New</strong></a> to save a new word. —</p>
                <p class="lead">— <a href="{{ url('/words#searchInput') }}"><strong>Search</strong></a> to filter through your words. Filters by spelling or excerpt. —</p>

                <div class="main-word m-b-md text-center">Keyboard Shorcuts</div>
                <p class="lead">— Every time you see the menu at the bottom, press "/" to go straight to the <a href="{{ url('/words#searchInput') }}"><strong>search</strong></a> field, and start typing. Then press enter to filter. —</p>
                <p class="lead">— In <a href="{{ url('/flashcards') }}"><strong>flashcards</strong></a> mode, press "u" to show the word usage; press "d" to show the word definition. Press "r", "&larr;" or "&rarr;" to get another flashcard. —</p>

                <p id="version">
                    <small>vocabulary-builder version 0.2.0</small>
                </p>

            </div>
        </div>
    </body>
</html>
