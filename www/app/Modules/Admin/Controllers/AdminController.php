<?php

namespace App\Modules\Admin\Controllers;

use \Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(Request $request, array $data = []): View
    {
        return view('admin.index');
    }
}
