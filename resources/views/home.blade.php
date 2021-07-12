@extends('layouts.app')

@section('content')
<div class="container">
    <blog-index
        :blogs="{{ json_encode($blogs) }}" 
        :loggedid="{{ auth()->user()->id }}"
        :urls="{{ json_encode([
            'store' => route('blog.store'),
            'show' => route('blog.show', 'blogId'),
            'update' => route('blog.update', 'blogId'),
            'destroy' => route('blog.delete', 'blogId')
        ]) }}"
    ></blog-index>
</div>
@endsection
