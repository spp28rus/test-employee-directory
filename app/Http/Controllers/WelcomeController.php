<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $isAdmin = false;

        /**
         * @var User|null
         */
        $authUser = Auth::user();

        if ($authUser) {
            $isAdmin = $authUser->hasRole(Role::ADMIN_SLUG);
        }
        return view('welcome', [
            'is_admin' => $isAdmin,
        ]);
    }
}
