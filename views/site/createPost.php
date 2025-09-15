<!DOCTYPE html>
<html>
<head>
    <title>Create Post</title>
</head>
<body>
<h1>Create New Post</h1>

<?php if (isset($message)): ?>
    <div style="color: red;"><?= $message ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <div>
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
    </div>

    <div>
        <label for="content">Content:</label>
        <textarea id="content" name="content" required></textarea>
    </div>

    <div>
        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*">
    </div>

    <button type="submit">Create Post</button>
</form>
</body>
</html>