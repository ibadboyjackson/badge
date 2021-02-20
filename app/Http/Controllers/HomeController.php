<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
     */
    public function index()
    {

        $comments = Comment::all();

        return view('home', ['comments' => $comments]);
    }
}
