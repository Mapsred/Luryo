<?php

namespace UserBundle\Entity;

use AppBundle\Entity\Address;
use AppBundle\Entity\Interest;
use AppBundle\Entity\Order;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    use ORMBehaviors\Timestampable\Timestampable;

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
     * @ORM\Column(name="birthday", type="date", nullable=true)
     */
    private $birthday;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=255, nullable=true)
     */
    private $sexe;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Favorite", mappedBy="user")
     */
    private $favorites;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Order", mappedBy="user", cascade={"persist"})
     */
    private $orders;

    /**
     * @var Address $address
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Address", cascade={"persist"})
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     */
    private $firstname;
    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     */
    private $lastname;

    public function __construct()
    {
        parent::__construct();
        $this->interests = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->favorites = new ArrayCollection();
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
     * @return ArrayCollection|Interest[]
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
     * Add favorite
     *
     * @param Favorite $favorite
     *
     * @return User
     */
    public function addFavorite(Favorite $favorite)
    {
        $this->favorites[] = $favorite;

        return $this;
    }

    /**
     * Remove favorite
     *
     * @param Favorite $favorite
     */
    public function removeFavorite(Favorite $favorite)
    {
        $this->favorites->removeElement($favorite);
    }

    /**
     * Get favorites
     *
     * @return ArrayCollection
     */
    public function getFavorites()
    {
        return $this->favorites;
    }

    /**
     * Add order
     *
     * @param Order $order
     *
     * @return User
     */
    public function addOrder(Order $order)
    {
        $this->orders[] = $order;

        return $this;
    }

    /**
     * Remove order
     *
     * @param Order $order
     */
    public function removeOrder(Order $order)
    {
        $this->orders->removeElement($order);
    }

    /**
     * Get orders
     *
     * @return ArrayCollection|Order[]
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * Set address
     *
     * @param Address $address
     *
     * @return User
     */
    public function setAddress(Address $address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }
}
