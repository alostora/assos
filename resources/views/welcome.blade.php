<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <link rel="icon" href="./../js/src/Logo.png" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
            <script src="{{ mix('/js/app.js') }}" defer></script>

        <title>Molk</title>

    </head>
    <body class="antialiased">
        <div id="root"></div>
    </body>
</html>
