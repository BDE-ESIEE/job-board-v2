<?php

namespace Macao\JobBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="Macao\JobBundle\Repository\CategoryRepository")
 * @UniqueEntity("name", message="Ce nom de catégorie est déjà utilisé. Il doit être unique pour chaque catégorie.")
 */
class Category
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
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=7)
     * @Assert\NotBlank()
     */
    private $color;

    /**
     * @var Macao\JobBundle\Entity\Job
     *
     * @ORM\OneToMany(targetEntity="Macao\JobBundle\Entity\Job", mappedBy="category")
     */
    private $jobs;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->jobs = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Category
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
     * Set color
     *
     * @param string $color
     *
     * @return Category
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Add job
     *
     * @param \Macao\JobBundle\Entity\Job $job
     *
     * @return Category
     */
    public function addJob(\Macao\JobBundle\Entity\Job $job)
    {
        $this->jobs[] = $job;

        return $this;
    }

    /**
     * Remove job
     *
     * @param \Macao\JobBundle\Entity\Job $job
     */
    public function removeJob(\Macao\JobBundle\Entity\Job $job)
    {
        $this->jobs->removeElement($job);
    }

    /**
     * Get jobs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getJobs()
    {
        return $this->jobs;
    }

    public function getTotalJobs()
    {
        $i = 0;
        $jobs = $this->jobs;

        foreach($jobs as $job) $i++;

        return $i;
    }
}
