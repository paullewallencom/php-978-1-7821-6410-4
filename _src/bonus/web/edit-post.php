<?php

/**
 * Creates or edits a blog post
 */

use Blog\Entity\Post;
use Blog\Entity\PostAuthor;
use Blog\Entity\Tag;

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
    $author = $entityManager->getRepository('Blog\Entity\PostAuthor')->findOneBy(
        [
            'email' => $_POST['author_email']
        ]
    );

    if (!$author) {
        $author = new PostAuthor();
        $author
            ->setEmail($_POST['author_email'])
        ;

        $entityManager->persist($author);
    }

    // Always update the author name
    $author->setName($_POST['author_name']);

    if (!empty ($_POST['author_bio'])) {
        $author->setBio($_POST['author_bio']);
    }

    // Create a new post if a post as not been retrieved an set its date of publication
    if (!isset ($post)) {
        $post = new Post();
        // Manage the entity
        $entityManager->persist($post);
    }

    $post
        ->setTitle($_POST['title'])
        ->setBody($_POST['body'])
        ->setAuthor($author)
    ;

    $newTags = [];
    foreach (explode(',', $_POST['tags']) as $tagName) {
        $trimmedTagName = trim($tagName);
        $tag = $entityManager->find('Blog\Entity\Tag', $trimmedTagName);
        if (!$tag) {
            $tag = new Tag();
            $tag->setName($trimmedTagName);
        }

        $newTags[] = $tag;
    }

    // Removes unused tags
    foreach (array_diff($post->getTags()->toArray(), $newTags) as $tag) {
        $post->removeTag($tag);
    }

    // Adds new tags
    foreach (array_diff($newTags, $post->getTags()->toArray()) as $tag) {
        $post->addTag($tag);
    }

    // Flush changes to the database
    $entityManager->flush();

    header(sprintf('Location: view-post.php?id=%d', $post->getId()));
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

    <label>
        Tags
        <input type="text" name="tags" value="<?=isset ($post) ? htmlspecialchars(implode(', ', $post->getTags()->toArray())) : ''?>" required>
    </label><br>

    <label>
        Author
        <input type="text" name="author_name" value="<?=isset ($post) ? htmlspecialchars($post->getAuthor()->getName()) : ''?>" required>
    </label><br>

    <label>
        Author email
        <input type="email" name="author_email" value="<?=isset ($post) ? htmlspecialchars($post->getAuthor()->getEmail()) : ''?>" required>
    </label><br>

    <label>
        Author bio
        <textarea name="author_bio" cols="20" rows="10"><?=isset ($post) ? htmlspecialchars($post->getAuthor()->getBio()) : ''?></textarea>
    </label><br>

    <input type="submit" value="Submit">
</form>

<a href="index.php">Back to the index</a>
