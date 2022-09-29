
@extends('layouts.main')

@section('container')
<h1>Post Category : {{ $category }}</h1>
    @foreach ($posts as $post )
        <h2><a href="/posts/{{ $post->slug }}">{{ $post->title }}</a></h2>
        <h5>By: {{ $post->author }}</h5>
        <p>{{ $post->excerpt }}</p>
    @endforeach

@endsection
