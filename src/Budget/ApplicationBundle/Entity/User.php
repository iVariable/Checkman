<?

namespace Budget\ApplicationBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Budget\BudgetBundle\Entity\Region;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Budget\BudgetBundle\Entity\Region", inversedBy="users")
     * @ORM\JoinTable(name="users_regions")
     */
    private $regions;

    public function __construct()
    {
        parent::__construct();
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    public function getCredentialsExpireAt()
    {
        return $this->credentialsExpireAt;
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
     * Add regions
     *
     * @param \Budget\ApplicationBundle\Entity\Region $regions
     * @return User
     */
    public function addRegion(\Budget\BudgetBundle\Entity\Region $regions)
    {
        $this->regions[] = $regions;
    
        return $this;
    }

    /**
     * Remove regions
     *
     * @param \Budget\ApplicationBundle\Entity\Region $regions
     */
    public function removeRegion(\Budget\BudgetBundle\Entity\Region $regions)
    {
        $this->regions->removeElement($regions);
    }

    /**
     * Get regions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRegions()
    {
        return $this->regions;
    }

    public function getRegionIds()
    {
        return $this->getRegions()->map(function($region){return $region->getId();})->toArray();
    }

    public function __toString()
    {
        return $this->getUsername();
    }
}