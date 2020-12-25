<?php

/**
 * Deletes a blog post
 */

require_once __DIR__ . '/../src/bootstrap.php';

/** @var Post The post to delete */
$post = $entityManager->find('Blog\Entity\Post', $_GET['id']);

if (!$post) {
    throw new \Exception('Post not found');
}

// Delete the entity and flush
$entityManager->remove($post);
$entityManager->flush();

// Redirects to the index
header('Location: index.php');
exit;