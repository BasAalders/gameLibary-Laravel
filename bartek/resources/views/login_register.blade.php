
<!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link href="{{ asset('css/stylesheet.css') }}" rel="stylesheet">

    </head>
    <body>
    <button id="backToHomePage" onclick="window.location.href = '/gamelibrary'">Back to library</button>
    <form action="/login" method="POST" id="loginForm">
        @csrf
        <label class="topTextLogin">Login</label>
        <input type="text" name="loginname" placeholder="Username">
        @error('loginname') <p class="error">{{$message}}</p> @enderror
        <input type="password" name="loginpassword" placeholder="Password">
        @error('loginpassword') <p class="error">{{$message}}</p> @enderror
        <input class="submit" type="submit" value="login" name="login">
    </form>
    <form action="/register" method="POST" id="registerForm">
        @csrf
        <label class="topTextLogin">Register</label>
        <input type="text" name="name" placeholder="Username">
        @error('name') <p class="error">{{$message}}</p> @enderror
        <input type="text" name="email" placeholder="email">
        @error('email') <p class="error">{{$message}}</p> @enderror
        <input type="password" name="password" placeholder="Password">
        @error('password') <p class="error">{{$message}}</p> @enderror
        <input class="submit" type="submit" value="register">
    </form>
    </body>
</html>
