<?php

require_once __DIR__.'/../src/bootstrap.php';

$sql = <<<SQL
SELECT
  COUNT(id) AS nb,
  MAX(publicationDate) AS latest
FROM Post
UNION
SELECT
  COUNT(id),
  MAX(publicationDate)
FROM Comment
SQL;

$query = $entityManager->getConnection()->query($sql);
$result = $query->fetchAll();

echo sprintf('Number of posts: %d%s', $result[0]['nb'], PHP_EOL);
echo sprintf('Last post: %s%s', $result[0]['latest'], PHP_EOL);
echo sprintf('Number of comments: %d%s', $result[1]['nb'], PHP_EOL);
echo sprintf('Last comment: %s%s', $result[1]['latest'], PHP_EOL);
