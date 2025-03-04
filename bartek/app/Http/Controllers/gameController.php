<?php

namespace App\Http\Controllers;

use App\Models\UserGames;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;

class gameController extends Controller
{
    public function addGame(Request $request)
    {
        // Validate the request
        $request->validate([
            'allData' => 'required|string',
        ]);

        // Decode the JSON data
        $gameData = json_decode(urldecode($request->input('allData')), true);

        // Log the game data (for debugging)
        Log::info('Game data received:', $gameData);

        // Map the JSON data to the model fields
        $game = new Game();
        $game->name = $gameData['name'] ?? 'N/A'; // Handle null case
        $game->mainImage = $gameData['background_image'] ?? 'N/A'; // Handle null case
        $game->releaseDate = $gameData['released'] ?? 'N/A'; // Handle null case
        $game->rating = $gameData['rating'] ?? 'N/A'; // Handle null case
        $game->{'Esrb rating'} = $gameData['esrb_rating']['name'] ?? 'N/A'; // Handle null case

// Handle genres
        $game->genre = isset($gameData['genres']) && is_array($gameData['genres'])
            ? implode(', ', array_map(function ($genre) {
                return $genre['name'];
            }, $gameData['genres']))
            : 'N/A'; // Default value if genres don't exist

// Handle platforms
        $game->platform = isset($gameData['platforms']) && is_array($gameData['platforms'])
            ? implode(', ', array_map(function ($platform) {
                return $platform['platform']['name'];
            }, $gameData['platforms']))
            : 'N/A'; // Default value if platforms don't exist

// Handle stores
        $game->store = isset($gameData['stores']) && is_array($gameData['stores'])
            ? implode(', ', array_map(function ($store) {
                return $store['store']['name'];
            }, $gameData['stores']))
            : 'N/A'; // Default value if stores don't exist

// Handle screenshots
        $game->screenshots = isset($gameData['short_screenshots']) && is_array($gameData['short_screenshots'])
            ? json_encode(array_map(function ($screenshot) {
                return $screenshot['image'];
            }, $gameData['short_screenshots']))
            : json_encode([]); // Default to an empty array if screenshots don't exist

        // Save the game to the database
        $game->save();

        // Redirect back with a success message
        return redirect('/');
    }

    public function getData(){
        $games = Game::select('id', 'name', 'mainImage')->get();
        return view('gameLibrary', ['games' => $games]);
    }

    public function getGameDetail(Game $game){
        $gameData = Game::find($game);
        $allgames = Game::select('id', 'name', 'mainImage')->get();
        $screenshots = json_decode($game->screenshots, true) ?? [];
        $users = UserGames::where('game_id', $game->id) // Use $game->id instead of $game
        ->with('user') // Eager load the user relationship
        ->get()
            ->pluck('user'); // Extract the user model
        $userNames = $users->pluck('name');

        // Set to "no one" if no users exist
        if ($userNames->isEmpty()) {
            $userNames = "no one";
        }
        return view('gameLibrary', ['games' => $allgames, 'gameData' => $gameData, 'screenshots' => $screenshots, 'users' => $userNames]);
    }

    public function getWishlist()
    {
        $games = UserGames::where('user_id', Auth::id())
            ->with(['game' => function ($query) {
                $query->select('id', 'name', 'mainImage'); // Select columns from the games table
            }])->get();
        return view('wishlist', ['games' => $games]);
    }

    public function getWishListDetails(Game $game){
        $gameData = Game::find($game);
        $allgames = UserGames::where('user_id', Auth::id())
            ->with(['game' => function ($query) {
                $query->select('id', 'name', 'mainImage'); // Select columns from the games table
            }])->get();
        $screenshots = json_decode($game->screenshots, true) ?? [];
        $users = UserGames::where('game_id', $game->id) // Use $game->id instead of $game
        ->with('user') // Eager load the user relationship
        ->get()
            ->pluck('user'); // Extract the user model
        $userNames = $users->pluck('name');

        // Set to "no one" if no users exist
        if ($userNames->isEmpty()) {
            $userNames = "no one";
        }
        return view('wishlist', ['games' => $allgames, 'gameData' => $gameData, 'screenshots' => $screenshots, 'users' => $userNames]);
    }

    public function delete(Game $game){
        UserGames::where('game_id', $game->id)->delete();

        $game->delete();

        return redirect('/');
    }

}
