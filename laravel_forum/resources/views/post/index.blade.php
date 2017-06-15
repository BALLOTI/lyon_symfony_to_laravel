@extends('layouts.app')

@section('content')

    <h1>Liste des posts</h1>


    @foreach ($posts as $post)
        <h3>{{ $post->title }}</h3>
        <p>{{ $post->description }}</p>
    @endforeach


@endsection