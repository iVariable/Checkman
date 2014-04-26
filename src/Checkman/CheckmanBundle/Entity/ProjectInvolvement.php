<?php

namespace Checkman\CheckmanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * ProjectInvolvement
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Checkman\CheckmanBundle\Entity\ProjectInvolvementRepository")
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
     * @Serializer\SerializedName("project")
     */
    private $project_id;

    /**
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="projects")
     * @ORM\JoinColumn(name="employee_id", referencedColumnName="id")
     */
    private $employee;

    /**
     * @ORM\Column(name="employee_id", type="integer")
     *
     * @Serializer\Groups({"ProjectInvolvement"})
     * @Serializer\SerializedName("employee")
     */
    private $employee_id;

    function __construct(Project $project = null, Employee $employee = null, $involvement = 0, $notes = "")
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
     * @param \Checkman\CheckmanBundle\Entity\Project $project
     * @return ProjectInvolvement
     */
    public function setProject(\Checkman\CheckmanBundle\Entity\Project $project = null)
    {
        $this->project = $project;
    
        return $this;
    }

    /**
     * Get project
     *
     * @return \Checkman\CheckmanBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set employee
     *
     * @param \Checkman\CheckmanBundle\Entity\Employee $employee
     * @return ProjectInvolvement
     */
    public function setEmployee(\Checkman\CheckmanBundle\Entity\Employee $employee = null)
    {
        $this->employee = $employee;
    
        return $this;
    }

    /**
     * Get employee
     *
     * @return \Checkman\CheckmanBundle\Entity\Employee
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    public function __toString() {
        return $this->getProject()->__toString().": ".$this->getInvolvement().'%';
    }
}