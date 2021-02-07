<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRoleUpdateIsAdminRequest;
use App\Models\Role;
use App\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Routing\Exception\InvalidParameterException;

class UserRoleController extends Controller
{
    public function updateIsAdmin(UserRoleUpdateIsAdminRequest $request, User $user)
    {
        if ($user->id == Auth::user()->id) {
            throw new InvalidParameterException();
        }

        if ($request->is_admin) {
            $user->addRole(Role::ADMIN_SLUG);
        } else {
            $user->deleteRole(Role::ADMIN_SLUG);
        }

        return response()->json();
    }
}
