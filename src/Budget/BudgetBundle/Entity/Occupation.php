<?php

namespace Budget\BudgetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;


/**
 * Occupation
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Occupation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Serializer\Groups({"Occupation"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     *
     * @Serializer\Groups({"Occupation"})
     */
    private $title;

    /**
     * @ORM\ManyToMany(targetEntity="Employee", inversedBy="occupations")
     * @ORM\JoinTable(name="occupationToEmployee",
     *      joinColumns={@ORM\JoinColumn(name="occupation_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="employee_id", referencedColumnName="id")}
     *      )
     *
     *
     */
    private $employees;


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
     * @return Occupation
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
     * Constructor
     */
    public function __construct()
    {
        $this->employees = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add employees
     *
     * @param \Budget\BudgetBundle\Entity\Employee $employees
     * @return Occupation
     */
    public function addEmployee(\Budget\BudgetBundle\Entity\Employee $employees, $bothSides = true)
    {
        $this->employees[] = $employees;
        if($bothSides) $employees->addOccupation($this, false);
    
        return $this;
    }

    /**
     * Remove employees
     *
     * @param \Budget\BudgetBundle\Entity\Employee $employees
     */
    public function removeEmployee(\Budget\BudgetBundle\Entity\Employee $employees)
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
}