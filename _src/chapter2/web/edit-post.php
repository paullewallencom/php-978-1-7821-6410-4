<?php

/**
 * Creates or edits a blog post
 */

use Blog\Entity\Post;

require_once __DIR__.'/../src/bootstrap.php';

// Retrieve the blog post if a id parameter exists
if (isset ($_GET['id'])) {
    /** @var Post $post The post to edit */
    $post = $entityManager->find('Blog\Entity\Post', $_GET['id']);

    if (!$post) {
        throw new \Exception('Post not found');
    }
}

// Create or update the blog post
if ('POST' === $_SERVER['REQUEST_METHOD']) {
    // Create a new post if a post as not been retrieved an set its date of publication
    if (!isset ($post)) {
        $post = new Post();
        // Manage the entity
        $entityManager->persist($post);

        $post->setPublicationDate(new \DateTime());
    }

    $post
        ->setTitle($_POST['title'])
        ->setBody($_POST['body'])
    ;

    // Flush changes to the database
    $entityManager->flush();

    // Redirect to the index
    header('Location: index.php');
    exit;
}

/** @var string Page title */
$pageTitle = isset ($post) ? sprintf('Edit post #%d', $post->getId()) : 'Create a new post';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?=$pageTitle?> - My blog</title>
</head>
<body>
<h1>
    <?=$pageTitle?>
</h1>

<form method="POST">
    <label>
        Title
        <input type="text" name="title" value="<?=isset ($post) ? htmlspecialchars($post->getTitle()) : ''?>" maxlength="255" required>
    </label><br>

    <label>
        Body
        <textarea name="body" cols="20" rows="10" required><?=isset ($post) ? htmlspecialchars($post->getBody()) : ''?></textarea>
    </label><br>

    <input type="submit">
</form>

<a href="index.php">Back to the index</a>
