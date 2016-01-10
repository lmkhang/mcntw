<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Closure;
use Illuminate\Support\Facades\Auth;

class MyAuth extends Controller
{
    //
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */

    public function handle($request, Closure $next, $guard = null)
    {
        if (!$this->isLogged()) {
            //set Flash Message
            $this->setFlash('message', 'Please authenticate your account before using Dashboard!');
            return redirect(route('home_page'));
        }

        return $next($request);
    }
}
