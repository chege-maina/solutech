<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function listRoles()
    {
        $role = Role::orderBy('id')->get();
        return response()->json([
            'data' => $role
        ]);
    }
}
