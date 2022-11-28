{{-- @extends('layout')

@section('content')
    <h1>Posts</h1>

    @foreach ($posts as $p)
        <article class="{{ $loop->even ? "gray" : "" }}">
            <h2>
                <a href="/posts/{{$p->slug }}">
                    {{ $p->title }}       
                </a>
            </h2>

            <div>
                {{ $p->excerpt }}
            </div>
        </article>
    @endforeach
@endsection --}}



<x-comp-layout content="Hello there">
    <h1>Posts</h1>

    @foreach ($posts as $p)
        <article class="{{ $loop->even ? "gray" : "" }}">
            <h2>
                <a href="/posts/{{$p->slug }}">
                    {{ $p->title }}       
                </a>
            </h2>

            <div>
                {{ $p->excerpt }}
            </div>
        </article>
    @endforeach
</x-comp-layout>