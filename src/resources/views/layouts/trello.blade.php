@extends('index')
@section('title', 'Všechny novinky o Fluffici')

@section('content')
    <section class="news-section">
        <div class="row">
            @forelse($newsArticles as $article)
                <a href="{{ route('article', $article->id) }}" class="card">
                    <img src="{{ $article->banner }}" class="card-img-top" alt="{{ $article->id }}" width="800" height="400">
                    <div class="card-body">
                        <h5 class="card-title">{{ $article->title }}</h5>
                        <p class="card-text">{{ $article->description }}</p>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">Datum: {{ $article->created_at->format('F j, Y, H:i') }}</small><br>
                        <small class="text-muted">Autor: {{ $article->author->name }}</small>
                    </div>
                </a>
            @empty
                <div class="col">
                    <div class="alert alert-info" role="alert">
                        Žádné novinky nejsou k dispozici.
                    </div>
                </div>
            @endforelse
        </div>
    </section>
@endsection
