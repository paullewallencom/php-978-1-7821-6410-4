<?php

namespace Blog\Event;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Blog\Entity\Comment;

/**
 * Mails a post author when a new comment is published
 */
class MailAuthorOnCommentEventSubscriber implements EventSubscriber
{

    /**
     * {@inheritDoc}
     */
    public function getSubscribedEvents()
    {
        return [Events::postPersist];
    }

    /**
     * Mails the Post's author when a new Comment is published
     *
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof Comment) {
            if ($entity->getPost()->getAuthor() && $entity->getAuthor()) {
                mail(
                    $entity->getPost()->getAuthor()->getEmail(),
                    'New comment!',
                    sprintf('%s published a new comment on your post %s', $entity->getAuthor()->getName(), $entity->getPost()->getTitle())
                );
            }
        }

    }
}
