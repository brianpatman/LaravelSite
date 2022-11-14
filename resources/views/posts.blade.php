<!doctype html>

<html>
    <head>
        <title>My Blog</title>
        <link rel="stylesheet" type="text/css" href="/app.css">
        <script type="text/javascript" src="/app.js"></script>
    </head>
    <body>
        <h1>Posts</h1>

        <?php foreach($posts as $p): ?>
            <article>
                <h2>
                    <a href="/posts/<?= $p->slug; ?>">
                        <?= $p->title; ?>        
                    </a>
                </h2>

                <div>
                    <?= $p->excerpt; ?>
                </div>
            </article>
        <?php endforeach; ?>
    </body>
</html>