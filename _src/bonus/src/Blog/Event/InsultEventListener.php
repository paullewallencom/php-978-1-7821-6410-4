<?php

namespace Blog\Event;

use Blog\Entity\Comment;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

/**
 * Censors French insults in comments
 */
class InsultEventListener
{
    /**
     * Censors on the prePersist event
     *
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof Comment) {
            // Use a white list instead, or better don't do that, it's useless
            $entity->setBody(str_ireplace(['connard', 'lenancker'], 'censored', $entity->getBody()));
        }
    }
}
