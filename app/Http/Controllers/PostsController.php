<?php

namespace App\Http\Controllers;

use App\Http\Requests\BaseAutorizeAdminCheckRequest;

class PostsController extends Controller
{
    public function index(BaseAutorizeAdminCheckRequest $request)
    {
        $data = [
            'url' => '/post',
            'title' => 'Posts',
        ];

        return view('simple-title-table', $data);
    }
}
