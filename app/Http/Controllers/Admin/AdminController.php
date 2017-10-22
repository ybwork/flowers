<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
	/**
	 * Shows admin home page
	 *
	 * @return html view admin home page
	 */
    public function index()
    {
    	return view('admin.home');
    }
}
