<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
    </head>
    <body>
    @auth
        <h2>Hello</h2>
        <form action="/logout">
            <button>logout</button>
        </form>
    @else
        <h2>Register</h2>
        <form action="/register" method="post">
            @csrf
            <input type="text" name="name" placeholder="username">
            <input type="text" name="email" placeholder="email">
            <input type="password" name="password" placeholder="password">
            <button name="registerSubmit">Submit</button>
        </form>
        <h2>login</h2>
        <form action="/login" method="post">
            @csrf

            <input type="text" name="name" placeholder="username">
=            <input type="password" name="password" placeholder="password">
            <button name="loginSubmit">Submit</button>
        </form>
    @endauth

   </body>
</html>
