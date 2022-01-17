<?php

namespace App\Http\Controllers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class SocialController extends Controller
{
    public function redirect(){
        return Socialite::driver('google')->stateless()->redirect();
    }
    public function callback(){
        $userSocial = Socialite::driver('google')->stateless()->user();
        $user = User::updateOrCreate(
            ['email'                => $userSocial->getEmail()],
            [
            'name'                  => $userSocial->getName(),
            'email'                 => $userSocial->getEmail(),
            'profile_photo_path'    => $userSocial->getAvatar(),
            'provider_id'           => $userSocial->getId(),
            'provider'              => 'google',
        ]);
        Auth::login($user);   
        return redirect()->route('dashboard');
    }
}
