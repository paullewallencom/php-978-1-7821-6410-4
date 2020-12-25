<?php

namespace Blog\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToMany;

/**
 * Tag entity
 *
 * @Entity
 */
class Tag
{
    /**
     * @var string
     *
     * @Id
     * @Column(type="string")
     */
    protected $name;
    /**
     * @var Post[]
     *
     * @ManyToMany(targetEntity="Post", mappedBy="tags")
     */
    protected $posts;

    /**
     * Initializes collection
     */
    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    /**
     * String representation
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Tag
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add posts
     *
     * @param \Blog\Entity\Post $posts
     * @return Tag
     */
    public function addPost(\Blog\Entity\Post $posts)
    {
        $this->posts[] = $posts;
        $posts->addTag($this);

        return $this;
    }

    /**
     * Remove posts
     *
     * @param \Blog\Entity\Post $posts
     */
    public function removePost(\Blog\Entity\Post $posts)
    {
        $this->posts->removeElement($posts);
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPosts()
    {
        return $this->posts;
    }
}
