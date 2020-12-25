<?php

namespace Blog\DataFixtures;

use Blog\Entity\Post;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Post fixtures
 */
class LoadPostData implements FixtureInterface
{
    /**
     * Number of posts to add
     */
    const NUMBER_OF_POSTS = 10;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= self::NUMBER_OF_POSTS; $i++) {
            $post = new Post();
            $post
                ->setTitle(sprintf('Blog post number %d', $i))
                ->setBody(<<<EOT
Lorem ipsum dolor sit amet, consectetur adipiscing elit.
EOT
                )
                ->setPublicationDate(new \DateTime(sprintf('-%d days', self::NUMBER_OF_POSTS - $i)))
            ;

            $manager->persist($post);
        }

        $manager->flush();
    }
}
