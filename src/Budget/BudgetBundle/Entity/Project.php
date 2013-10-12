<?php

namespace Budget\BudgetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Project
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Project
{

    const STATUS_DISABLED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_FINISHED = 2;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Serializer\Groups({"Project"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     *
     * @Serializer\Groups({"Project"})
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     *
     * @Serializer\Groups({"Project"})
     */
    private $description = "";

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="smallint")
     *
     * @Serializer\Groups({"Project"})
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="ProjectInvolvement", mappedBy="project")
     */
    private $employees;

    /**
     * @ORM\ManyToOne(targetEntity="Region", inversedBy="projects")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     */
    private $region;

    /**
     * @ORM\Column(name="region_id", type="integer", nullable=true)
     * @Serializer\Groups({
     *      "Project"
     * })
     */
    private $region_id;


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
     * @return Project
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
     * Set description
     *
     * @param string $description
     * @return Project
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Project
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->employees = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add employees
     *
     * @param \Budget\BudgetBundle\Entity\ProjectInvolvement $employees
     * @return Project
     */
    public function addEmployee(\Budget\BudgetBundle\Entity\ProjectInvolvement $employees)
    {
        $this->employees[] = $employees;
    
        return $this;
    }

    /**
     * Remove employees
     *
     * @param \Budget\BudgetBundle\Entity\ProjectEnvolvement $employees
     */
    public function removeEmployee(\Budget\BudgetBundle\Entity\ProjectInvolvement $employees)
    {
        $this->employees->removeElement($employees);
    }

    /**
     * Get employees
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEmployees()
    {
        return $this->employees;
    }

    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * Set region_id
     *
     * @param integer $regionId
     * @return Project
     */
    public function setRegionId($regionId)
    {
        $this->region_id = $regionId;
    
        return $this;
    }

    /**
     * Get region_id
     *
     * @return integer 
     */
    public function getRegionId()
    {
        return $this->region_id;
    }

    /**
     * Set region
     *
     * @param \Budget\BudgetBundle\Entity\Region $region
     * @return Project
     */
    public function setRegion(\Budget\BudgetBundle\Entity\Region $region = null)
    {
        $this->region = $region;
    
        return $this;
    }

    /**
     * Get region
     *
     * @return \Budget\BudgetBundle\Entity\Region 
     */
    public function getRegion()
    {
        return $this->region;
    }
}