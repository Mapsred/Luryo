<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMbehaviors;
use UserBundle\Entity\User;

/**
 * Interest
 *
 * @ORM\Table(name="interest")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InterestRepository")
 */
class Interest
{
    use ORMbehaviors\Timestampable\Timestampable;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var ArrayCollection $travels
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Travel", mappedBy="interests")
     */
    private $travels;

    /**
     * @var ArrayCollection $users
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\User", mappedBy="interests")
     */
    private $users;

    public function __construct()
    {
        $this->travels = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Interest
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add travel
     *
     * @param Travel $travel
     *
     * @return Interest
     */
    public function addTravel(Travel $travel)
    {
        $this->travels[] = $travel;

        return $this;
    }

    /**
     * Remove travel
     *
     * @param Travel $travel
     */
    public function removeTravel(Travel $travel)
    {
        $this->travels->removeElement($travel);
    }

    /**
     * Get travels
     *
     * @return ArrayCollection
     */
    public function getTravels()
    {
        return $this->travels;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->name;
    }

    /**
     * Add user
     *
     * @param User $user
     *
     * @return Interest
     */
    public function addUser(User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param User $user
     */
    public function removeUser(User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @return int
     */
    public function getUserCount()
    {
        return $this->users->count();
    }

    /**
     * @return int
     */
    public function getTravelCount()
    {
        return $this->travels->count();
    }
}
