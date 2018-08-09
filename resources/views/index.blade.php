<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Hedonist</title>
        @if (config("app.env") === "production" || config("app.env") === "staging")
            <link href="/dist/css/app.css" rel="stylesheet">
        @endif

        <link rel="stylesheet" href="//cdn.materialdesignicons.com/2.0.46/css/materialdesignicons.min.css">
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
