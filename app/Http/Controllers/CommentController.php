<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{


    public function store (Request $request) {

        $user = Auth::user();

        $user->comments()->create($request->only('content'));

        return redirect()->back();

    }


}
