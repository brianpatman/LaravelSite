<!doctype html>

<html>
    <head>
        <title>My Blog</title>
        <link rel="stylesheet" type="text/css" href="/app.css">
        <script type="text/javascript" src="/app.js"></script>
    </head>
    <body>
        <article>
            <h1><?= $post->title; ?></h1>

            <div>
                <?= $post->body; ?>
            </div>
        </article>

        <a href="/">Go Back</a>
    </body>
</html>