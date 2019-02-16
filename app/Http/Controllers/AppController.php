<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

/**
 * Controller for main SPA page.
 */
class AppController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application landing welcome.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
    }
}
