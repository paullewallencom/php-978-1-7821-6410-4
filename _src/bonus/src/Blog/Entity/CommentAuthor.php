<?php

namespace Blog\Entity;

use Doctrine\ORM\Mapping\Entity;

/**
 * Comment author entity
 *
 * @Entity
 */
class CommentAuthor extends Author
{
    /**
     * @var Comment[]
     *
     * @OneToMany(targetEntity="Comment", mappedBy="commentAuthor")
     */
    protected $comments;

    /**
     * Adds comment
     *
     * @param  Comment       $comment
     * @return CommentAuthor
     */
    public function addComment(Comment $comment)
    {
        $this->comments[] = $comment;
        $comment->setPost($this);

        return $this;
    }

    /**
     * Removes comment
     *
     * @param Comment $comment
     */
    public function removeComment(Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Gets comments
     *
     * @return Comment[]
     */
    public function getComments()
    {
        return $this->comments;
    }
}
