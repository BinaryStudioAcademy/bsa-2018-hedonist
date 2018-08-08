<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
        <title>Hedonist</title>
        @if (config("app.env") === "production" || config("app.env") === "staging")
            <link href="/dist/css/app.css" rel="stylesheet">
        @endif
    </head>
    <body>
        <div id="app"></div>

        @if (config("app.env") === "production" || config("app.env") === "staging")
            <script type="text/javascript" src="/dist/js/manifest.js"></script>
            <script type="text/javascript" src="/dist/js/vendor.js"></script>
            <script type="text/javascript" src="/dist/js/app.js"></script>
        @else
            <script type="text/javascript" src="{{ env("APP_FRONTEND") }}/app.js"></script>
        @endif
    </body>
</html>
