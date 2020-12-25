<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Events;
use Doctrine\Common\EventManager;
use Blog\Event\InsultEventListener;
use Blog\Event\MailAuthorOnCommentEventSubscriber;

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../config/config.php';

$entitiesPath = array(__DIR__.'/Blog/Entity');
$config = Setup::createAnnotationMetadataConfiguration($entitiesPath, $dev);

$eventManager = new EventManager();
$eventManager->addEventListener([Events::prePersist], new InsultEventListener());
$eventManager->addEventSubscriber(new MailAuthorOnCommentEventSubscriber());

$entityManager = EntityManager::create($dbParams, $config, $eventManager);
