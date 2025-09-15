<!DOCTYPE html>
<html>
<head>
    <title>Posts</title>
</head>
<body>
<h1>All Posts</h1>

<a href="/posts/create">Create New Post</a>

<?php foreach ($posts as $post): ?>
    <div style="border: 1px solid #ccc; margin: 10px; padding: 10px;">
        <h2><?= htmlspecialchars($post->title) ?></h2>
        <p><?= htmlspecialchars($post->content) ?></p>

        <?php if (!empty($post->image)): ?>
            <img src="/uploads/<?= $post->image ?>" alt="Post image" style="max-width: 300px;">
        <?php endif; ?>
    </div>
<?php endforeach; ?>
</body>
</html>