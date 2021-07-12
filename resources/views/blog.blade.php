@extends('layouts.app')

@section('content')
<div class="container">
    <blog-show
        :blog="{{ json_encode($blog) }}" 
        :loggedid="{{ auth()->user()->id }}"
        :urls="{{ json_encode([
            'like' => route('blog.like', 'blogId'),
            'home' => route('home'),
        ]) }}"
        :liked="{{ $blog->likes->contains('user_id', auth()->user()->id) ? 1 : 0 }}"
    ></blog-show>
</div>
@endsection
