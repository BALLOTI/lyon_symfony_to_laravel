@extends('layouts.app')

@section('content')

    <h1><i class="material-icons">book</i> Liste des posts</h1>
    <hr />


    @forelse ($posts as $post)
        <div class="card">
            <div class="card-content">
        <h4 class="blue-text">{{ $post->title }}</h4>
                <blockquote>
                    {{ $post->description }}
                </blockquote>
                <a href="{{ route('post.remove', ["id" => $post->id]) }}" class="waves-effect waves-light btn red"><i class="material-icons">delete_forever</i> Supprimer cet article</a>
            <ul class="collection with-header">
                @forelse ($post->comments as $comment)
                    <li class="collection-item">
                        @can('remove', $comment)
                            <a href="{{ route('comment.remove', ["id" => $comment->id]) }}" class="secondary-content">
                                <i class="material-icons">delete</i></a>
                        @endcan
                        {{ $comment->content }} <i>- {{ $comment->content }}</i>
                    </li>
                @empty
                    <li>Aucun commentaire</li>
                @endforelse
            </ul>

            @if (Auth::check())

                    <form method="post" action="{{ route('comment.create') }}" class="row">
                        <div class="input-field col s8">
                            <textarea placeholder="Blablabla ...." id="textarea1" name="content" class="materialize-textarea"></textarea>
                        </div>

                        <div class="input-field col s2">
                            <input type="hidden" name="post_id" value="{{ $post->id }}" />
                        </div>
                        {{ csrf_field() }}
                        <button class="btn waves-effect waves-light" type="submit" name="action">Ajouter ce commentaire
                            <i class="material-icons right">send</i>
                        </button>
                    </form>


                @else
                    <small>Vous devez être connecté pour ajouter un commentaire</small>
                @endif
        </ol>
            </div>

        </div>
    @empty
        <div class="card red">
            <div class="card-content white-text">
            <i class="material-icons">not_interested</i> Aucun article pour le moment.
            </div>
        </div>
    @endforelse

    <br />  <br />  <br />  <br />

    <div class="row">
        <a href="{{ route('post.create') }}" class="waves-effect waves-light btn btn-large  green large"><i class="material-icons">add</i> Créee un article</a>
    </div>




@endsection