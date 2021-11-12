@extends('components.layout')

@section('content')

    @foreach($posts as $post)
        <article>
            <h1>
                <a href="/posts/{{ $post->slug }}">
                    {!! $post->title !!}
                </a>
            </h1>
            <div>
                <p><a href="/categories/{{ $post->category->slug }}">{!! $post->category->name !!}</a></p>
            </div>
            <div>
                {{ $post->excerpt }}
            </div>
        </article>
    @endforeach

@endsection
