<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    /**
     * Redirect the user to the provider authentication page.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToProvider(Request $request): RedirectResponse
    {
        return Socialite::driver($request->provider)->redirect();
    }

    /**
     * Obtain the user information from the provider.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback(Request $request): RedirectResponse
    {
        try {
            $oauth = Socialite::driver($request->provider)->user();
            $user = User::where('email', $oauth->getEmail)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $oauth->getName(),
                    'email' => $oauth->getEmail()
                ]);
            }

            Auth::attempt(['email' => $user->email, 'password' => $user->password], true);
        } catch (\Exception $e) {


            return redirect()->back()->with('status', 'Error: ' . $e->getMessage());
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
