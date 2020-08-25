<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if ( Auth::user()->isAdmin() ) {
            return view('admin.index');
        } else if ( Auth::user()->isRto() ) {
            return view('admin.index');
        } else if ( Auth::user()->isDistributor() ) {
            return view('admin.index');
        } else if ( Auth::user()->isDealer() ) {
            return view('admin.index');
        }
    }
}
