<?php

require_once __DIR__.'/../src/bootstrap.php';

use Doctrine\ORM\Query\ResultSetMappingBuilder;

const NUMBER_OF_RESULTS = 100;

$resultSetMappingBuilder = new ResultSetMappingBuilder($entityManager);
$resultSetMappingBuilder->addRootEntityFromClassMetadata('Blog\Entity\Comment', 'c');
$resultSetMappingBuilder->addJoinedEntityFromClassMetadata(
    'Blog\Entity\Post',
    'p',
    'c',
    'post',
    [
        'id' => 'post_id',
        'body' => 'post_body',
        'publicationDate' => 'post_publication_date',
        'author_id' => 'post_author_id'
    ])
;

$sql = <<<SQL
SELECT id, publicationDate, body, post_id
FROM Comment
ORDER BY publicationDate DESC
LIMIT :limit
SQL;

$query = $entityManager->createNativeQuery($sql, $resultSetMappingBuilder);
$query->setParameter('limit', NUMBER_OF_RESULTS);
$comments = $query->getResult();

foreach ($comments as $comment) {
    echo sprintf('Comment #%s%s', $comment->getId(), PHP_EOL);
    echo sprintf('Post #%s%s', $comment->getPost()->getId(), PHP_EOL);
    echo sprintf('Date of publication: %s%s', $comment->getPublicationDate()->format('r'), PHP_EOL);
    echo sprintf('Body: %s%s', $comment->getBody(), PHP_EOL);
    echo PHP_EOL;
}
