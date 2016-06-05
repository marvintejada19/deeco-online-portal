<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordChangeRequest;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Auth;
use Hash;
use Random;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['showPasswordChangeForm', 'changePassword']]);
        $this->middleware('guest', ['except' => ['showPasswordChangeForm', 'changePassword']]);
    }

    public function showPasswordChangeForm(){
        $randKey = Random::generateString(16, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
        return view('auth.passwords.change', compact('randKey'));
    }

    public function changePassword(PasswordChangeRequest $request){
        $user = Auth::user();
        $oldPassword = $request->input('oldPassword');
        if (Hash::check($oldPassword, $user->password)){
            $user->password = bcrypt($request->input('newPassword'));
            $user->update();
            flash()->success('Your password has been successfully changed.');
            return redirect('/home');
        } else {
            return redirect('password/change')->withErrors(['oldPassword' => 'The value you have entered does not match your current password.']);
        }
    }
}
