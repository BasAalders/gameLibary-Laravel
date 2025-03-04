<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="{{ secure_asset('css/stylesheet.css') }}" rel="stylesheet">
    <link href="{{ asset('css/stylesheet.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
@if(empty($gameData))
<body id="normalPage">
@else
<body id="detailpage">
@endif
<div class="gridContainer">
    <div  class="girdItem" id="gridItem1">
        <div id="leftnavbar">
            @auth
                <a href="/wishlist" class="notThispage navbarLink" id="welcomeText"> {{ucfirst(Auth::user()->name)}}'s whislist </a>
            @endauth
            <a href="/gamelibrary" class="notThispage navbarLink">LIBRARY</a>
            <a href="/gameSearch" class="notThispage navbarLink">SEARCH ENGINE</a>
            @auth
                <a href="/logout" class="notThispage navbarLink" id="logout">LOGOUT</a>
            @else
                <a href="/loginOrRegister" class="notThispage navbarLink">LOGIN</a>
                <a href="/loginOrRegister" class="notThispage navbarLink">REGISTER</a>
            @endauth
        </div>
        <h1 id="gameLibaryText">Game Libary</h1>

    </div>


    <div class="girdItem" id="gridItem2">
        <ul>
        @foreach ($games as $game)
            <a href="/gamelibrary/{{$game['id']}}">
            <li>
                 <img alt="{{$game['name']}}" class='imgBeforeTextRight' src="{{$game['mainImage']}}">
                {{$game['name']}}
            </li>
            </a>
        @endforeach
        </ul>
    </div>
    <div class="girdItem" id="gridItem3">
        @if(empty($gameData))
            <div class='bigPicturesGridContainer'>
            @foreach($games as $game)
                <a href="gamelibrary/{{$game['id']}}"> <div class="bigPictureGridItem"><img alt="{{$game['name']}}" class="imgBig" src="{{$game['mainImage']}}"></div></a>
            @endforeach
            </div>
        @else
            @foreach($gameData as $game)

            <h1>{{$game['name']}}</h1>
            <img src={{$game["mainImage"]}} id='coverImg' alt='{{$game['name']}}'>
            @auth()
                <form id="whitelistForm" name="whitelistForm" method="post" action="/wishlist">
                    @csrf
                    <input type="hidden" name="game_id" value="{{$game['id']}}">
                    <input type="submit" id="whitelistButton" name="addToWhitelist" value="wishlist game">
                </form>
            @endauth
            <p><strong>Genre:</strong> {{$game['genre']}}</p>
            <p><strong>Platform:</strong> {{$game['platform']}}</p>
            <p><strong>Release Year:</strong> {{$game['releaseDate']}}</p>
            <p><strong>Rating:</strong> {{$game['rating']}}</p>
            <p>
                <strong>People that have whislisted this: </strong>
                @if($users == 'no one')
                    {{$users}}
                @else
                    @foreach($users as $user)
                        {{ ucfirst($user) }}@if(!$loop->last), @endif
                    @endforeach
                @endif
            </p>
            <p><strong>Screenshots:</strong></p>
            @php($index = 0)
                <div id='screenshotContainer'>
                @foreach($screenshots as $screenshot)
                    <img src="{{ $screenshot }}" id='afbeelding{{$index}}' alt="{{ $game['name'] }}" class="screenshot">
                        @php($index++)
                @endforeach
                </div>
                <form id="whitelistForm" name="delete" method="post" action="/delete/{{$game['id']}}">
                    @csrf
                    @method('DELETE')
                    <input type="submit" id="whitelistButton" name="addToWhitelist" value="Delete game">
                </form>
            @endforeach
        @endif

    </div>
</div>
<script src="javascript/script.js"></script>
</body>
</body>
</html>
