<?php

namespace Blog\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Column;

/**
 * Post author entity
 *
 * @Entity
 */
class PostAuthor extends Author
{
    /**
     * @var string
     *
     * @Column(type="text", nullable=true)
     */
    protected $bio;
    /**
     * @var Post[]
     *
     * @OneToMany(targetEntity="Post", mappedBy="postAuthor")
     */
    protected $posts;

    /**
     * Initializes collections
     */
    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    /**
     * Sets bio
     *
     * @param  string     $bio
     * @return PostAuthor
     */
    public function setBio($bio)
    {
        $this->bio = $bio;

        return $this;
    }

    /**
     * Gets bio
     *
     * @return string
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * Adds post
     *
     * @param  Post       $post
     * @return PostAuthor
     */
    public function addPost(Post $post)
    {
        $this->posts[] = $post;
        $post->setAuthor($this);

        return $this;
    }

    /**
     * Removes post
     *
     * @param Post $post
     */
    public function removePost(Post $post)
    {
        $this->posts->removeElement($post);
    }

    /**
     * Gets posts
     *
     * @return Post[]
     */
    public function getPosts()
    {
        return $this->posts;
    }
}
