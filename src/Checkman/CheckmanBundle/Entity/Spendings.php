<?php

namespace Checkman\CheckmanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Spendings
 *
 *
 * @ORM\Entity(repositoryClass="Checkman\CheckmanBundle\Entity\SpendingsRepository")
 * @ORM\Table()
 */
class Spendings
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Serializer\Groups({"Spending"})
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="value", type="float")
     *
     * @Serializer\Groups({"Spending"})
     */
    private $value;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     *
     * @Serializer\Groups({"Spending"})
     * @Serializer\Type("DateTime<'d-m-Y'>")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="Project")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    private $project;

    /**
     * @ORM\Column(name="project_id", type="integer", nullable=true)
     * @Serializer\Groups({"Spending"})
     * @Serializer\SerializedName("project")
     */
    private $project_id;

    /**
     * @ORM\ManyToOne(targetEntity="Employee")
     * @ORM\JoinColumn(name="employee_id", referencedColumnName="id")
     */
    private $employee;

    /**
     * @ORM\Column(name="employee_id", type="integer", nullable=true)
     * @Serializer\Groups({"Spending"})
     * @Serializer\SerializedName("employee")
     */
    private $employee_id;

    /**
     * @ORM\ManyToOne(targetEntity="SpendingsType")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    private $type;

    /**
     * @ORM\Column(name="type_id", type="integer")
     * @Serializer\Groups({"Spending"})
     * @Serializer\SerializedName("type")
     */
    private $type_id;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     *
     * @Serializer\Groups({"Spending"})
     */
    private $description = null;

    /**
     * @var string
     *
     * @ORM\Column(name="extra", type="text", nullable=true)
     *
     * @Serializer\Groups({"Spending"})
     */
    private $extra = null;

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * @param string $extra
     */
    public function setExtra($extra)
    {
        $this->extra = $extra;
    }

    /**
     * @return string
     */
    public function getExtra()
    {
        return $this->extra;
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
     * Set value
     *
     * @param float $value
     * @return Spendings
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Spendings
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set project
     *
     * @param \Checkman\CheckmanBundle\Entity\Project $project
     * @return Spendings
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
     * @return Spendings
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

    /**
     * Set type
     *
     * @param \Checkman\CheckmanBundle\Entity\SpendingsType $type
     * @return Spendings
     */
    public function setType(\Checkman\CheckmanBundle\Entity\SpendingsType $type = null)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return \Checkman\CheckmanBundle\Entity\SpendingsType
     */
    public function getType()
    {
        return $this->type;
    }

    public function __toString()
    {
        return (string)$this->getValue();
    }


}