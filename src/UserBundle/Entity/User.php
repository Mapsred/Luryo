<?php

namespace UserBundle\Entity;

use AppBundle\Entity\Interest;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
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
     * @var ArrayCollection $interests
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Interest", inversedBy="users")
     */
    private $interests;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthdate", type="datetime")
     */
    private $birthdate;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=255)
     */
    private $sexe;

    /**
     * @var string
     *
     * @ORM\Column(name="postal_code", type="string", length=255)
     */
    private $postalCode;

    public function __construct()
    {
        parent::__construct();
        $this->interests = new ArrayCollection();
    }

    /**
     * Add interest
     *
     * @param Interest $interest
     *
     * @return User
     */
    public function addInterest(Interest $interest)
    {
        $this->interests[] = $interest;

        return $this;
    }

    /**
     * Remove interest
     *
     * @param Interest $interest
     */
    public function removeInterest(Interest $interest)
    {
        $this->interests->removeElement($interest);
    }

    /**
     * Get interests
     *
     * @return ArrayCollection
     */
    public function getInterests()
    {
        return $this->interests;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     *
     * @return User
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     *
     * @return User
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set postalCode
     *
     * @param string $postalCode
     *
     * @return User
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get postalCode
     *
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }
}
