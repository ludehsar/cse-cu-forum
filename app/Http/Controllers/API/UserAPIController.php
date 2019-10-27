<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserAPIController extends Controller
{
    /**
     * Get user details.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser(int $id)
    {
        $user = User::findOrFail($id);

        return response($user, 200);
    }

    /**
     * Get current user details.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCurrentUser()
    {
        $user = auth('api')->user();

        return response($user, 200);
    }
}
