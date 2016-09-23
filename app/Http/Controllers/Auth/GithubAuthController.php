<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Socialite;
class GithubAuthController extends Controller
{


/**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {

        try {
            $user = Socialite::driver('github')->user();
        } catch (Exception $e) {
            return Redirect::to('auth/github');
        }

        $authUser = $this->findOrCreateUser($user);

        \Auth::login($authUser, true);

        return \Redirect::to('contacts');
    }

    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $githubUser
     * @return User
     */
    private function findOrCreateUser($githubUser)
    {
        if ($authUser = User::where([ ['provider_id', $githubUser->id ], ['provider', 'github'] ])->first()) {
         return $authUser;
        
        }

        return User::create([
            'name' => $githubUser->name,
            'email' => $githubUser->email,
            'provider_id' => $githubUser->id,
            'provider' => 'github',
            'password' => md5($githubUser->id . $githubUser->name)
        ]);
    }

    }