<!doctype html>

<html>
    <head>
        <title>My Blog</title>
        <link rel="stylesheet" type="text/css" href="/app.css">
        <script type="text/javascript" src="/app.js"></script>
    </head>
    <body>
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
    </body>
</html>