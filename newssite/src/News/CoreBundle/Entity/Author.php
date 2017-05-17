<?php

namespace News\CoreBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Author Entity.
 *
 * @ORM\Table(name="author")
 * @ORM\Entity(repositoryClass="News\CoreBundle\Repository\AuthorRepository")
 */
class Author extends BaseUser
{
    /**
     * The id of the author.
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * The slug of the author.
     *
     * @var string
     *
     * @Gedmo\Slug(fields={"username"}, unique=false)
     * @ORM\Column(length=255)
     */
    private $slug;

    /**
     * The creation date of the author.
     *
     * @var DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * The modification date of the author.
     *
     * @var DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * The one-to-many association between Author and Post.
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Post", mappedBy="author", cascade={"remove"})
     */
    private $posts;

    /**
     * Initializes posts and role.
     */
    public function __construct()
    {
        parent::__construct();

        $this->addRole("ROLE_SUPER_ADMIN");
        $this->posts = new ArrayCollection;
    }

    /**
     * Is called when the class is treated like a string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->username;
    }

    /**
     * Sets slug.
     *
     * @param string $slug
     *
     * @return Author
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Gets slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Sets createdAt.
     *
     * @param DateTime $createdAt
     *
     * @return Author
     */
    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Gets createdAt.
     *
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Sets updatedAt.
     *
     * @param DateTime $updatedAt
     *
     * @return Author
     */
    public function setUpdatedAt(DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Gets updatedAt.
     *
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Adds post.
     *
     * @param Post $post
     *
     * @return Author
     */
    public function addPost(Post $post)
    {
        $this->posts[] = $post;

        return $this;
    }

    /**
     * Removes post.
     *
     * @param Post $post
     */
    public function removePost(Post $post)
    {
        $this->posts->removeElement($post);
    }

    /**
     * Gets posts.
     *
     * @return Collection
     */
    public function getPosts()
    {
        return $this->posts;
    }
}
