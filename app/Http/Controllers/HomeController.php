<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() { }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): Renderable
    {
        return view('welcome', ["auth" => Session::has("auth")]);
    }
}
