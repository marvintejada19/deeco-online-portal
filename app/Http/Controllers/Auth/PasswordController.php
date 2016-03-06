<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Validator;
use Illuminate\Http\Request;
use DB;


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

    use ResetsPasswords, AuthenticatesAndRegistersUsers{
        ResetsPasswords::redirectPath insteadof AuthenticatesAndRegistersUsers;
        ResetsPasswords::getGuard insteadof AuthenticatesAndRegistersUsers;
    }

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the password change page
     *
     * @return \Illuminate\Http\Response
     */
    protected function showPasswordChangeForm(){
        $user = session()->get('user');
        $message = session()->get('message');
        session()->keep(['user', 'message']);
        return view('auth.passwords.change', compact('user', 'message'));
    }

    /**
     * Change the password of the user
     *
     * @return \Illuminate\Http\Response
     */
    protected function passwordChange(Request $request){
        session()->keep(['user', 'message']);
        $user = session()->get('user');

        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
            return redirect($this->redirectPath());
        }

        session()->forget(['user', 'message']);

        DB::table('users')
            ->where('id', $user->id)
            ->update([
                'password' => bcrypt($request->password),
                'firstLogin' => '0'
            ]);

        return redirect('/login')
                ->with('message', 'Password successfully changed.')
                ->with('user', $user);
    }

    /**
     * Get a validator for an incoming password change request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data){
        return Validator::make($data, [
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return string|null
     */
    protected function getGuard()
    {
        return property_exists($this, 'guard') ? $this->guard : null;
    }
}
