<?php

/**
 * Lists all blog posts
 */

require_once __DIR__ . '/../src/bootstrap.php';

$repository = $entityManager->getRepository('Blog\Entity\Post');
/** @var $posts \Blog\Entity\Post[] Retrieve the list of all blog posts */
if (isset($_GET['tags'])) {
    $results = $repository->findHavingTags(explode(',', $_GET['tags']));
} else {
    $results = $repository->findWithCommentCount();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>My blog</title>
</head>
<body>
<h1>My blog</h1>

<?php
foreach ($results as $result):
    $post = $result[0];
    $commentCount = $result[1];
?>

    <article>
        <h1>
            <a href="view-post.php?id=<?= $post->getId() ?>">
                <?= htmlspecialchars($post->getTitle()) ?>
            </a>
        </h1>
        By: <a
            href="mailto:<?= htmlspecialchars($post->getAuthor()->getEmail()) ?>"><?= htmlspecialchars($post->getAuthor()->getName()) ?></a>
        - <?= $post->getPublicationDate()->format('Y-m-d H:i:s') ?>

        <p>
            <?= nl2br(htmlspecialchars($post->getBody())) ?>
        </p>

        Tags:
        <ul>
            <?php foreach ($post->getTags() as $tag): ?>
                <li>
                    <a href="index.php?tags=<?= urlencode($tag) ?>"><?= htmlspecialchars($tag) ?></a>
                </li>
            <?php endforeach ?>
        </ul>

        <?php if ($commentCount == 0): ?>
            Be the first to comment this post.
        <?php elseif ($commentCount == 1): ?>
            One comment
        <?php else: ?>
            <?= $commentCount ?> comments
        <?php endif ?>

        <ul>
            <li>
                <a href="edit-post.php?id=<?= $post->getId() ?>">Edit this post</a>
            </li>
            <li>
                <a href="delete-post.php?id=<?= $post->getId() ?>">Delete this post</a>
            </li>
        </ul>
    </article>
<?php endforeach ?>
<?php if (empty($posts)): ?>
    <p>
        No post, for now!
    </p>
<?php endif ?>

<a href="edit-post.php">
    Create a new post
</a>
</html>
