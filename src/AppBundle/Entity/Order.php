<?php
/**
 * Created by PhpStorm.
 * User: maps_red
 * Date: 10/11/16
 * Time: 15:39
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * Order
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrderRepository")
 */
class Order
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Travel $travel
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Travel", inversedBy="orders")
     * @ORM\JoinColumn(name="travel", referencedColumnName="id")
     */
    private $travel;

    /**
     * @var $amount
     * @ORM\Column(name="amount", type="float", nullable=true)
     */
    private $amount;

    /**
     * @var User $user
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="orders")
     * @ORM\JoinColumn(name="user", referencedColumnName="id")
     */
    private $user;

    /**
     * @var $uuid
     * @ORM\Column(name="uuid", type="string", nullable=true)
     */
    private $uuid;


    /**
     * @var $done
     * @ORM\Column(type="boolean", name="done")
     */
    private $done = false;

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
     * Set amount
     *
     * @param float $amount
     *
     * @return Order
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set uuid
     *
     * @param string $uuid
     *
     * @return Order
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * Get uuid
     *
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set travel
     *
     * @param Travel $travel
     *
     * @return Order
     */
    public function setTravel(Travel $travel = null)
    {
        $this->travel = $travel;

        return $this;
    }

    /**
     * Get travel
     *
     * @return Travel
     */
    public function getTravel()
    {
        return $this->travel;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return Order
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set done
     *
     * @param boolean $done
     *
     * @return Order
     */
    public function setDone($done)
    {
        $this->done = $done;

        return $this;
    }

    /**
     * Get done
     *
     * @return boolean
     */
    public function getDone()
    {
        return $this->done;
    }
}
