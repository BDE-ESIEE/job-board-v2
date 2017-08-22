<?php

namespace Macao\JobBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="job")
 * @ORM\Entity(repositoryClass="Macao\JobBundle\Repository\JobRepository")
 * @UniqueEntity("title", message="Ce titre de job est déjà utilisé, il doit être unique pour chaque job.")
 */
class Job
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=100)
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="author_name", type="text", nullable=true)
     */
    private $authorName;

    /**
     * @var string
     *
     * @ORM\Column(name="author_email", type="text", nullable=true)
     */
    private $authorEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="author_telephone", type="text", nullable=true)
     */
    private $authorTelephone;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     * @Gedmo\Slug(fields={"title"})
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     * @Assert\NotBlank()
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="published", type="boolean")
     */
    private $published;

    /**
     * @var Macao\JobBundle\Entity\Category
     *
     * @ORM\ManyToOne(targetEntity="Macao\JobBundle\Entity\Category", inversedBy="jobs")
     * @ORM\JoinColumn(name="category", referencedColumnName="id")
     * @Gedmo\Blameable(on="create")
     */
    private $category;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Job
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set authorName
     *
     * @param string $authorName
     *
     * @return Job
     */
    public function setAuthorName($authorName)
    {
        $this->authorName = $authorName;

        return $this;
    }

    /**
     * Get authorName
     *
     * @return string
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * Set authorEmail
     *
     * @param string $authorEmail
     *
     * @return Job
     */
    public function setAuthorEmail($authorEmail)
    {
        $this->authorEmail = $authorEmail;

        return $this;
    }

    /**
     * Get authorEmail
     *
     * @return string
     */
    public function getAuthorEmail()
    {
        return $this->authorEmail;
    }

    /**
     * Set authorTelephone
     *
     * @param string $authorTelephone
     *
     * @return Job
     */
    public function setAuthorTelephone($authorTelephone)
    {
        $this->authorTelephone = $authorTelephone;

        return $this;
    }

    /**
     * Get authorTelephone
     *
     * @return string
     */
    public function getAuthorTelephone()
    {
        return $this->authorTelephone;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Job
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Job
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Job
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Job
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set category
     *
     * @param \Macao\JobBundle\Entity\Category $category
     *
     * @return Job
     */
    public function setCategory(\Macao\JobBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Macao\JobBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
}
