<?

namespace Checkman\ApplicationBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Checkman\CheckmanBundle\Entity\Region;

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
     * @ORM\ManyToMany(targetEntity="Checkman\CheckmanBundle\Entity\Region", inversedBy="users")
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
     * @param \Checkman\ApplicationBundle\Entity\Region $regions
     * @return User
     */
    public function addRegion(\Checkman\CheckmanBundle\Entity\Region $regions)
    {
        $this->regions[] = $regions;
    
        return $this;
    }

    /**
     * Remove regions
     *
     * @param \Checkman\ApplicationBundle\Entity\Region $regions
     */
    public function removeRegion(\Checkman\CheckmanBundle\Entity\Region $regions)
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