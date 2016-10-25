<?php

namespace UserBundle\Entity;

use AppBundle\Entity\County;
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
     * @ORM\Column(name="birthday", type="date")
     */
    private $birthday;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=255)
     */
    private $sexe;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\County", inversedBy="user", cascade={"persist"})
     * @ORM\JoinColumn(name="county", referencedColumnName="id")
     */
    private $county;

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
     * Set birthday
     *
     * @param \DateTime $birthday
     *
     * @return User
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
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
     * Get county
     *
     * @return ArrayCollection
     */
    public function getCounty()
    {
        return $this->county;
    }
}
