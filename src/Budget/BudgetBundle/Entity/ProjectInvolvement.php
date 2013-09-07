<?php

namespace Budget\BudgetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * ProjectInvolvement
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Budget\BudgetBundle\Entity\ProjectInvolvementRepository")
 */
class ProjectInvolvement
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Serializer\Groups({"ProjectInvolvement"})
     */
    private $id;

    /**
     * @var integer
     *
     * [0, 100]
     *
     * @ORM\Column(name="involvement", type="smallint")
     *
     * @Serializer\Groups({"ProjectInvolvement"})
     */
    private $involvement;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     *
     * @Serializer\Groups({"ProjectInvolvement"})
     */
    private $notes = "";

    /**
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="employees")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    private $project;

    /**
     * @ORM\Column(name="project_id", type="integer")
     *
     * @Serializer\Groups({"ProjectInvolvement"})
     */
    private $project_id;

    /**
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="projects")
     * @ORM\JoinColumn(name="employee_id", referencedColumnName="id")
     */
    private $employee;

    function __construct(Project $project, Employee $employee, $involvement, $notes = "")
    {
        $this->setProject($project);
        $this->setEmployee($employee);
        $this->setInvolvement($involvement);
        $this->setNotes($notes);
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
     * Set involvement
     *
     * @param integer $involvement
     * @return ProjectInvolvement
     */
    public function setInvolvement($involvement)
    {
        $this->involvement = $involvement;
    
        return $this;
    }

    /**
     * Get involvement
     *
     * @return integer 
     */
    public function getInvolvement()
    {
        return $this->involvement;
    }

    /**
     * Set notes
     *
     * @param string $notes
     * @return ProjectInvolvement
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
     * Set project
     *
     * @param \Budget\BudgetBundle\Entity\Project $project
     * @return ProjectInvolvement
     */
    public function setProject(\Budget\BudgetBundle\Entity\Project $project = null)
    {
        $this->project = $project;
    
        return $this;
    }

    /**
     * Get project
     *
     * @return \Budget\BudgetBundle\Entity\Project 
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set employee
     *
     * @param \Budget\BudgetBundle\Entity\Employee $employee
     * @return ProjectInvolvement
     */
    public function setEmployee(\Budget\BudgetBundle\Entity\Employee $employee = null)
    {
        $this->employee = $employee;
    
        return $this;
    }

    /**
     * Get employee
     *
     * @return \Budget\BudgetBundle\Entity\Employee 
     */
    public function getEmployee()
    {
        return $this->employee;
    }
}