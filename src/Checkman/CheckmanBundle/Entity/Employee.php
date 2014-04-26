<?php

namespace Checkman\CheckmanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;

/**
 * Employee
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Checkman\CheckmanBundle\Entity\EmployeeRepository")
 */
class Employee
{

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_ON_VACATION = 2;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Serializer\Groups({
     *      "Employee"
     * })
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     *
     * @Serializer\SerializedName("firstName")
     * @Serializer\Groups({
     *      "Employee"
     * })
     */
    private $firstName = "";

    /**
     * @var string
     *
     * @ORM\Column(name="secondName", type="string", length=255)
     * @Serializer\SerializedName("secondName")
     * @Serializer\Groups({
     *      "Employee"
     * })
     */
    private $secondName = "";

    /**
     * @var float
     *
     * @ORM\Column(name="salary", type="float")
     *
     * @Serializer\Groups({
     *      "Employee"
     * })
     */
    private $salary = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     *
     * @Serializer\Groups({
     *      "Employee"
     * })
     */
    private $notes = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="smallint")
     *
     * @Serializer\Groups({
     *      "Employee"
     * })
     */
    private $status = 0;

    /**
     * @ORM\OneToMany(targetEntity="ProjectInvolvement",mappedBy="employee")
     * @Serializer\Groups({
     *      "Employee"
     * })
     *
     * @Serializer\Type("array<integer>")
     * @Serializer\Accessor(getter="getProjectsIds")
     *
     */
    private $projects;

    /**
     * @ORM\ManyToOne(targetEntity="Region", inversedBy="employees")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     */
    private $region;

    /**
     * @ORM\Column(name="region_id", type="integer", nullable=true)
     * @Serializer\Groups({
     *      "Employee"
     * })
     */
    private $region_id;

    /**
     * @ORM\ManyToMany(targetEntity="Occupation", inversedBy="employees", cascade={"persist"})
     * @ORM\JoinTable(name="occupationToEmployee",
     *      joinColumns={@ORM\JoinColumn(name="employee_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="occupation_id", referencedColumnName="id")}
     *      )
     *
     *
     * @Serializer\Groups({
     *      "Employee"
     * })
     *
     * @Serializer\Accessor(getter="getOccupationsIds")
     * @Serializer\Type("array<integer>")
     */
    private $occupations;

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
     * Set firstName
     *
     * @param string $firstName
     * @return Employee
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set secondName
     *
     * @param string $secondName
     * @return Employee
     */
    public function setSecondName($secondName)
    {
        $this->secondName = $secondName;

        return $this;
    }

    /**
     * Get secondName
     *
     * @return string
     */
    public function getSecondName()
    {
        return $this->secondName;
    }

    /**
     * Set salary
     *
     * @param float $salary
     * @return Employee
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;

        return $this;
    }

    /**
     * Get salary
     *
     * @return float
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * Set notes
     *
     * @param string $notes
     * @return Employee
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Employee
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
    public function __construct($secondName = false, $firstName = false,  $salary = false)
    {
        $this->projects = new \Doctrine\Common\Collections\ArrayCollection();
        $this->occupations = new \Doctrine\Common\Collections\ArrayCollection();
        if ($firstName) {
            $this->setFirstName($firstName);
        }
        if ($secondName) {
            $this->setSecondName($secondName);
        }
        if ($salary) {
            $this->setSalary($salary);
        }
    }

    /**
     * Add projects
     *
     * @param \Checkman\CheckmanBundle\Entity\ProjectInvolvement $projects
     * @return Employee
     */
    public function addProjectInvolvement(\Checkman\CheckmanBundle\Entity\ProjectInvolvement $projects)
    {
        if ($this->hasProjectInvolvement($projects)) {
            return $this;
        }

        $this->projects[] = $projects;

        return $this;
    }

    /**
     * Checks if an existing involvement already exists
     *
     * @param ProjectInvolvement $projects
     */
    public function hasProjectInvolvement(\Checkman\CheckmanBundle\Entity\ProjectInvolvement $involvement)
    {
        /* @var $existingInvolvement ProjectInvolvement */
        foreach ($this->getProjectInvolvements() as $existingInvolvement) {
            if (
                $existingInvolvement->getEmployee()->getId() == $involvement->getEmployee()->getId()
                &&
                $existingInvolvement->getProject()->getId() == $involvement->getProject()->getId()
            ) {
                return true;
            }
        }
        return false;
    }

    /**
     * Remove projects
     *
     * @param \Checkman\CheckmanBundle\Entity\ProjectInvolvement $projects
     */
    public function removeProjectInvolvement(\Checkman\CheckmanBundle\Entity\ProjectInvolvement $projects)
    {
        $this->projects->removeElement($projects);
    }

    /**
     * Get projects
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProjectInvolvements()
    {
        return $this->projects;
    }

    /**
     * Add occupations
     *
     * @param \Checkman\CheckmanBundle\Entity\Occupation $occupations
     * @return Employee
     */
    public function addOccupation(\Checkman\CheckmanBundle\Entity\Occupation $occupations, $bothSides = true)
    {
        $this->occupations[] = $occupations;
        if ($bothSides) {
            $occupations->addEmployee($this, false);
        }

        return $this;
    }

    /**
     * Remove occupations
     *
     * @param \Checkman\CheckmanBundle\Entity\Occupation $occupations
     */
    public function removeOccupation(\Checkman\CheckmanBundle\Entity\Occupation $occupations)
    {
        $this->occupations->removeElement($occupations);
    }

    /**
     * Get occupations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOccupations()
    {
        return $this->occupations;
    }

    /**
     * Get occupations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProjects()
    {
        return $this->projects;
    }

    public function getOccupationsIds (){
        return $this->getOccupations()->map(function($occupation){ return $occupation->getId(); });
    }

    public function getProjectsIds (){
        return $this->getProjects()->map(function($project){ return $project->getId(); });
    }

    public function __toString()
    {
        return $this->getFirstName().' '.$this->getSecondName();
    }


    /**
     * Set region_id
     *
     * @param integer $regionId
     * @return Employee
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
     * Add projects
     *
     * @param \Checkman\CheckmanBundle\Entity\ProjectInvolvement $projects
     * @return Employee
     */
    public function addProject(\Checkman\CheckmanBundle\Entity\ProjectInvolvement $projects)
    {
        $this->projects[] = $projects;
    
        return $this;
    }

    /**
     * Remove projects
     *
     * @param \Checkman\CheckmanBundle\Entity\ProjectInvolvement $projects
     */
    public function removeProject(\Checkman\CheckmanBundle\Entity\ProjectInvolvement $projects)
    {
        $this->projects->removeElement($projects);
    }

    /**
     * Set region
     *
     * @param \Checkman\CheckmanBundle\Entity\Region $region
     * @return Employee
     */
    public function setRegion(\Checkman\CheckmanBundle\Entity\Region $region = null)
    {
        $this->region = $region;
    
        return $this;
    }

    /**
     * Get region
     *
     * @return \Checkman\CheckmanBundle\Entity\Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    public function isFired()
    {
        return $this->getStatus() == self::STATUS_DELETED;
    }
}