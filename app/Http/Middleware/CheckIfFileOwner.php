<?php

namespace App\Http\Middleware;

use App\Models\File;
use Closure;
use Route;

class CheckIfFileOwner
{
    /**
     * Handle an incoming request.
     * Prevents users aside from the owner from seeing the download history of a file
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!empty($request->user())){
            $fileId = Route::current()->parameters()['file_id'];
            $file = File::find($fileId);
            if ($file){
                $fileOwner = $file->user->username;
                $user = $request->user()->username;
                if (!strcmp($fileOwner, $user)){
                    return $next($request);
                }
            }
        }
        return redirect('/home');
    }
}
