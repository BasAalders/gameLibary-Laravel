<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserGames;

class UserController extends Controller
{
    public function register(Request $request){
        $data = $request->validate([
            'name' => ['required', 'min:3', 'max:40', 'unique:users'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6', 'max:120']
        ]);
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        Auth::login($user);
        return redirect('/gamelibrary');
    }

    public function login(Request $request){
        $data = $request->validate([
            'loginname' => 'required|exists:users,name',
            'loginpassword' => 'required'
        ]);
        if (auth()->attempt(['name' => $data['loginname'], 'password' => $data['loginpassword']])) {
            $request->session()->regenerate();
            return redirect('/gamelibrary');
        }else{
            return redirect('/loginOrRegister');
        }

    }

    public function logout(){
        Auth::logout();
        return redirect('/gamelibrary');
    }

    public function wishlist(Request $request){
        $game_id = $request->input('game_id');
        $user_id = Auth::id();
        UserGames::firstOrCreate(['game_id' => $game_id,'user_id' => $user_id]);
        return redirect('/wishlist');
    }

    public function deleteWishlist(Game $game)
    {
        $user_id = Auth::id();
        $game_id = $game['id'];
        UserGames::where('user_id', $user_id)
            ->where('game_id', $game_id)
            ->delete();
        return redirect('/wishlist');
    }

}
