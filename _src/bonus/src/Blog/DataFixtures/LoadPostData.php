<?php

namespace Blog\DataFixtures;

use Blog\Entity\Post;
use Blog\Entity\PostAuthor;
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
     * Number of authors
     */
    const NUMBER_OF_AUTHORS = 3;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $authors = [];
        for ($i = 1; $i <= self::NUMBER_OF_AUTHORS; $i++) {
            $author = new PostAuthor();
            $author->setName(sprintf('Post author #%d', $i));
            $author->setEmail(sprintf('post-author%d@example.com', $i));
            $author->setBio('Lorem ipsum');

            $manager->persist($author);

            $authors[] = $author;
        }

        for ($i = 1; $i <= self::NUMBER_OF_POSTS; $i++) {
            $post = new Post();
            $post
                ->setTitle(sprintf('Blog post number %d', $i))
                ->setBody(<<<EOT
Lorem ipsum dolor sit amet, consectetur adipiscing elit.
EOT
                )
                ->setAuthor($authors[$i % self::NUMBER_OF_AUTHORS])
                ->setPublicationDate(new \DateTime(sprintf('-%d days', self::NUMBER_OF_POSTS - $i)))
            ;

            $manager->persist($post);
        }

        $manager->flush();
    }
}
