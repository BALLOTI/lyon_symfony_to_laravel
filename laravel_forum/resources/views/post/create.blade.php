@extends('layouts.app')

@section('content')

    <h1>Nouveau post</h1>
    <div class="row">
        @if ($errors->any())
            <div class="card red">
                <ul class="card-content">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="col s12" method="post" action="{{ route('post.store') }}">
            <div class="row">
                <div class="input-field col s12">
                    <input required  value="{{ old('title') }}" placeholder="Titre de l'article" id="title" name="title" type="text" class="validate">
                </div>
                <div class="input-field col s12">
                    <textarea id="description" placeholder="Description de l'article" name="description"  required class="materialize-textarea">{{ old('description') }}</textarea>
                </div>
                <div class="input-field col s12">
                    <button class="btn btn-primary"><i class="material-icons">add</i> Ajouter cet article</button>
                </div>
            </div>
            {{ csrf_field() }}
        </form>





@endsection