<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class CuitController extends Controller
{
    public function index(): View 
    {
        $posts = Post::with('user')->latest()->get();

        return view('home', compact('posts'));
    }

    public function post(Request $request): RedirectResponse 
    {
        Post::create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect('/')->with('success', 'Cuit posted successfully!');
    }
}
