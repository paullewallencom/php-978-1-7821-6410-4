<?php

namespace Blog\DataFixtures;

use Blog\Entity\Comment;
use Blog\Entity\CommentAuthor;
use Blog\Entity\Post;
use Blog\Entity\PostAuthor;
use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Author fixtures
 */
class LoadAuthorData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $postAuthor = new PostAuthor();
        $postAuthor->setName('George Abitbol');
        $postAuthor->setEmail('gabitbol@example.com');
        $postAuthor->setBio('L\'homme le plus classe du monde');

        $manager->persist($postAuthor);

        $post = new Post();
        $post->setTitle('My post');
        $post->setBody('Lorem ipsum');
        $post->setPublicationDate(new \DateTime());
        $post->setauthor($postAuthor);

        $manager->persist($post);

        $commentAuthor = new CommentAuthor();
        $commentAuthor->setName('Kévin Dunglas');
        $commentAuthor->setEmail('dunglas@gmail.com');

        $manager->persist($commentAuthor);

        $comment = new Comment();
        $comment->setBody('My comment');
        $comment->setAuthor($commentAuthor);
        $comment->setPublicationDate(new \DateTime());

        $post->addComment($comment);
        $manager->persist($comment);

        $manager->flush();
    }
}
