<?php

namespace App\Http\Controllers;

use App\Http\Requests\BaseAutorizeAdminCheckRequest;

class SkillsPageController extends Controller
{
    public function index(BaseAutorizeAdminCheckRequest $request)
    {
        $data = [
            'url' => '/skill',
            'title' => 'Skills',
        ];

        return view('simple-title-table', $data);
    }
}
