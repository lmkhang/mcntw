<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuth extends AdminController
{
    //
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */

    public function handle($request, Closure $next, $guard = null)
    {
        if (!$this->isLoggedAdmin()) {
            //set Flash Message
            $this->setFlash('message', 'Please authenticate your account before accessing admin zone!');
            return redirect(url('/adminntw/login'));
        }

        return $next($request);
    }
}
