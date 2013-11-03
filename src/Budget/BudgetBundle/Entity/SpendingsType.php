<?php

namespace Budget\BudgetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * TypedSpendingsType
 *
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="title_idx", columns={"title"})})
 * @ORM\Entity(repositoryClass="Budget\BudgetBundle\Entity\SpendingsTypeRepository")
 */
class SpendingsType
{
    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Serializer\Groups({"SpendingsType"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     *
     * @Serializer\Groups({"SpendingsType"})
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     *
     * @Serializer\Groups({"SpendingsType"})
     */
    private $description;

    /**
     * @ORM\Column(name="canBeDeleted", type="boolean")
     */
    private $canBeDeleted = true;

    /**
     * @param mixed $canBeDeleted
     */
    public function setCanBeDeleted($canBeDeleted)
    {
        $this->canBeDeleted = $canBeDeleted;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCanBeDeleted()
    {
        return $this->canBeDeleted;
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
     * @return TypedSpendingsType
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
     * @return TypedSpendingsType
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

    public function __toString()
    {
        return $this->getTitle();
    }
}
