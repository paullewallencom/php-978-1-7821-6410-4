<?php

/**
 * View a blog post
 */

use Blog\Entity\Comment;

require_once __DIR__ . '/../src/bootstrap.php';

/** @var \Blog\Entity\Post $post The post to edit */
$post = $entityManager->find('Blog\Entity\Post', $_GET['id']);

if (!$post) {
    throw new \Exception('Post not found');
}

// Add a comment
if ('POST' === $_SERVER['REQUEST_METHOD']) {
    $comment = new Comment();
    $comment
        ->setBody($_POST['body'])
        ->setPublicationDate(new \DateTime())
        ->setPost($post)
    ;

    $entityManager->persist($comment);
    $entityManager->flush();

    header(sprintf('Location: view-post.php?id=%d', $post->getId()));
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?=htmlspecialchars($post->getTitle())?> - My blog</title>
</head>
<body>

<article>
    <h1>
        <?=htmlspecialchars($post->getTitle())?>
    </h1>
    Date of publication: <?=$post->getPublicationDate()->format('Y-m-d H:i:s')?>

    <p>
        <?=nl2br(htmlspecialchars($post->getBody()))?>
    </p>
    <?php if (count($post->getComments())): ?>
        <h2>Comments</h2>

        <?php foreach ($post->getComments() as $comment): ?>
            <article>
                <?=$comment->getPublicationDate()->format('Y-m-d H:i:s')?>

                <p><?=htmlspecialchars($comment->getBody())?></p>

                <a href="delete-comment.php?id=<?=$comment->getId()?>">Delete this comment</a>
            </article>
        <?php endforeach ?>
    <?php endif ?>

    <form method="POST">
        <h2>Post a comment</h2>

        <label>
            Comment
            <textarea name="body"></textarea>
        </label><br>

        <input type="submit">
    </form>
</article>

<a href="index.php">Back to the index</a>