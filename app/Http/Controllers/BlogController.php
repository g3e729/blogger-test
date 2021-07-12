<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Blog;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $user = auth()->user();
        $blogs = $user->blogs()->orderBy('created_at', 'DESC')->get();

        return view('home', compact('blogs'));
    }
    
    public function show(Blog $blog)
    {
        $blog->load('author', 'likes');

        return view('blog', compact('blog'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $blog = $user->blogs()->create($request->only('title', 'content'));

        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );

        $pusher = new \Pusher\Pusher(
            '244d88e73f543fc5d789',
            '240dae21b6d93ae5092f',
            '1234382',
            $options
        );

        $data['id'] = $blog->id;
        $data['title'] = $blog->title;
        $data['created_at'] = $blog->created_at;
        $data['author'] = ['name' => $user->name];
        $data['url'] = route('blog.show', $blog);
        $pusher->trigger('my-channel', 'my-event', $data);

        return redirect()->route('home');
    }

    public function update(Request $request, Blog $blog)
    {
        $blog->update($request->only('title', 'content'));

        return redirect()->route('home');
        return redirect()->route('blog.show', $blog);
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();

        return redirect()->route('home');
    }
}
