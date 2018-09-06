<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Hedonist</title>
    </head>
    <body>
        <p>Hello, <strong>{{ $firstName }} {{ $lastName }}</strong>!</p>
        <p>Click
            <a href="{{ url()->full() . '/reset?token=' . $token  . '&email=' . $email }}">this link</a>
            to reset your password
        </p>
    </body>
</html>