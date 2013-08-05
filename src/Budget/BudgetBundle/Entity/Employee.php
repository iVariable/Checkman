<?php

namespace Budget\BudgetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Employee
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Budget\BudgetBundle\Entity\EmployeeRepository")
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
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="secondName", type="string", length=255)
     */
    private $secondName;

    /**
     * @var float
     *
     * @ORM\Column(name="salary", type="float")
     */
    private $salary;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="smallint")
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="ProjectInvolvement",mappedBy="employee")
     */
    private $projects;

    /**
     * @ORM\ManyToMany(targetEntity="Occupation", mappedBy="employees")
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
    public function __construct()
    {
        $this->projects = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add projects
     *
     * @param \Budget\BudgetBundle\Entity\ProjectInvolvement $projects
     * @return Employee
     */
    public function addProject(\Budget\BudgetBundle\Entity\ProjectInvolvement $projects)
    {
        $this->projects[] = $projects;
    
        return $this;
    }

    /**
     * Remove projects
     *
     * @param \Budget\BudgetBundle\Entity\ProjectInvolvement $projects
     */
    public function removeProject(\Budget\BudgetBundle\Entity\ProjectInvolvement $projects)
    {
        $this->projects->removeElement($projects);
    }

    /**
     * Get projects
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * Add occupations
     *
     * @param \Budget\BudgetBundle\Entity\Occupation $occupations
     * @return Employee
     */
    public function addOccupation(\Budget\BudgetBundle\Entity\Occupation $occupations)
    {
        $this->occupations[] = $occupations;
    
        return $this;
    }

    /**
     * Remove occupations
     *
     * @param \Budget\BudgetBundle\Entity\Occupation $occupations
     */
    public function removeOccupation(\Budget\BudgetBundle\Entity\Occupation $occupations)
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
}