<?php

/**
 * View a blog post
 */

use Blog\Entity\Comment;
use Blog\Entity\CommentAuthor;

require_once __DIR__ . '/../src/bootstrap.php';

/** @var \Blog\Entity\Post $post The post to edit */
$post = $entityManager->getRepository('Blog\Entity\Post')->findWithComments($_GET['id']);

if (!$post) {
    throw new \Exception('Post not found');
}

// Add a comment
if ('POST' === $_SERVER['REQUEST_METHOD']) {
    // Find the comment author by email or create it
    $author = $entityManager->getRepository('Blog\Entity\CommentAuthor')->findOneBy(
        [
            'email' => $_POST['author_email']
        ]
    );

    if (!$author) {
        $author = new CommentAuthor();
        $author->setEmail($_POST['author_email']);

        $entityManager->persist($author);
    }

    // Always update the name
    $author->setName($_POST['author_name']);

    $comment = new Comment();
    $comment
        ->setBody($_POST['body'])
        ->setAuthor($author)
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

    By: <a
        href="mailto:<?= htmlspecialchars($post->getAuthor()->getEmail()) ?>"><?= htmlspecialchars($post->getAuthor()->getName()) ?></a>
    - <?= $post->getPublicationDate()->format('Y-m-d H:i:s') ?>

    <p>
        <?=nl2br(htmlspecialchars($post->getBody()))?>
    </p>

    <ul>
        <li>
            <a href="edit-post.php?id=<?=$post->getId()?>">Edit this post</a>
        </li>
        <li>
            <a href="delete-post.php?id=<?=$post->getId()?>">Delete this post</a>
        </li>
    </ul>

    <article>
        <h1>About <?=htmlspecialchars($post->getAuthor()->getName())?></h1>

        <p>
            <?=nl2br(htmlspecialchars($post->getAuthor()->getBio(), false))?>
        </p>
    </article>

    Tags:
    <ul>
        <?php foreach ($post->getTags() as $tag): ?>
            <li>
                <a href="index.php?tags=<?=urlencode($tag)?>"><?=htmlspecialchars($tag)?></a>
            </li>
        <?php endforeach ?>
    </ul>

    <?php if (count($post->getComments())): ?>
        <h2>Comments</h2>

        <?php foreach ($post->getComments() as $comment): ?>
            <article id="comment-<?=$comment->getId()?>">
                By <a href="mailto:<?=htmlspecialchars($comment->getAuthor()->getEmail())?>"><?=htmlspecialchars($comment->getAuthor()->getName())?></a>
                - <?=$comment->getPublicationDate()->format('Y-m-d H:i:s')?>

                <p><?=htmlspecialchars($comment->getBody())?></p>

                <a href="delete-comment.php?id=<?=$comment->getId()?>">Delete this comment</a>
            </article>
        <?php endforeach ?>
    <?php endif ?>

    <form method="POST">
        <h2>Post a comment</h2>

        <label>
            Name
            <input type="text" name="author_name">
        </label><br>
        <label>
            Email
            <input type="email" name="author_email">
        </label><br>
        <label>
            Comment
            <textarea name="body"></textarea>
        </label><br>

        <input type="submit" value="Submit">
    </form>
</article>

<a href="index.php">Back to the index</a>