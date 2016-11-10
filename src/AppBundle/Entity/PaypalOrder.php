<?php
/**
 * Created by PhpStorm.
 * User: maps_red
 * Date: 10/11/16
 * Time: 15:39
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Payment\CoreBundle\Entity\PaymentInstruction;


/**
 * PaypalOrder
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PaypalOrderRepository")
 */
class PaypalOrder
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Travel")
     * @ORM\JoinColumn(name="travel", referencedColumnName="id")
     */
    private $travel;

    /** @ORM\Column(name="amount", type="float", nullable=true) */
    private $amount;

    /** @ORM\Column(name="name", type="string", length=60 , nullable=true) */
    private $name;

    /** @ORM\Column(name="address", type="string", length=255 , nullable=true) */
    private $address;

    /** @ORM\Column(name="email", type="string", length=255 , nullable=true) */
    private $email;

    /** @ORM\Column(name="date", type="datetime", nullable=true) */
    private $date;

    /** @ORM\Column(name="statut", type="string", length=60 , nullable=true) */
    private $statut;

    /** @ORM\Column(name="dl_cpt", type="integer", nullable=true) */
    private $dl_cpt;

    /** @ORM\Column(name="paypal_params", type="text", nullable=true) */
    private $paypal_params;

    /** @ORM\Column(name="paypal_details", type="text", nullable=true) */
    private $paypal_details;

    /** @ORM\Column(name="paypal_complete", type="text", nullable=true) */
    private $paypal_complete;

    public function __construct($amout)
    {
        $this->amount = $amout;
        $this->dl_cpt = 0;
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
     * Set amount
     *
     * @param float $amount
     *
     * @return PaypalOrder
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
     * Set name
     *
     * @param string $name
     *
     * @return PaypalOrder
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
     * Set address
     *
     * @param string $address
     *
     * @return PaypalOrder
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return PaypalOrder
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return PaypalOrder
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
     * Set statut
     *
     * @param string $statut
     *
     * @return PaypalOrder
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return string
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set dlCpt
     *
     * @param integer $dlCpt
     *
     * @return PaypalOrder
     */
    public function setDlCpt($dlCpt)
    {
        $this->dl_cpt = $dlCpt;

        return $this;
    }

    /**
     * Get dlCpt
     *
     * @return integer
     */
    public function getDlCpt()
    {
        return $this->dl_cpt;
    }

    /**
     * Set paypalParams
     *
     * @param string $paypalParams
     *
     * @return PaypalOrder
     */
    public function setPaypalParams($paypalParams)
    {
        $this->paypal_params = $paypalParams;

        return $this;
    }

    /**
     * Get paypalParams
     *
     * @return string
     */
    public function getPaypalParams()
    {
        return $this->paypal_params;
    }

    /**
     * Set paypalDetails
     *
     * @param string $paypalDetails
     *
     * @return PaypalOrder
     */
    public function setPaypalDetails($paypalDetails)
    {
        $this->paypal_details = $paypalDetails;

        return $this;
    }

    /**
     * Get paypalDetails
     *
     * @return string
     */
    public function getPaypalDetails()
    {
        return $this->paypal_details;
    }

    /**
     * Set paypalComplete
     *
     * @param string $paypalComplete
     *
     * @return PaypalOrder
     */
    public function setPaypalComplete($paypalComplete)
    {
        $this->paypal_complete = $paypalComplete;

        return $this;
    }

    /**
     * Get paypalComplete
     *
     * @return string
     */
    public function getPaypalComplete()
    {
        return $this->paypal_complete;
    }

    /**
     * Set travel
     *
     * @param Travel $travel
     *
     * @return PaypalOrder
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
}
