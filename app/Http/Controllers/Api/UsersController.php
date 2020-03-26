<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;

class UsersController extends Controller
{
    /**
     * Fetch all relevant username.
     *
     * @return mixed
     */
    public function index()
    {
        $search = request('name');

        $result = User::where('name', 'LIKE', "%$search%")
            ->take(5)->get('name');

        return response(['result' => $result], 200);
    }
}
