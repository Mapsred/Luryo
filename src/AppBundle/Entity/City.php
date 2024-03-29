<?php
/**
 * Created by PhpStorm.
 * User: maps_red
 * Date: 25/10/16
 * Time: 15:20
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * City
 *
 * @ORM\Table(name="city")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CityRepository")
 */
class City
{
    use ORMBehaviors\Sluggable\Sluggable;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
      *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    /**
     * @var string
     *
     * @ORM\Column(name="zipcode", type="string", length=255)
     */
    private $zipcode;
    /**
     * @var County $county
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\County", inversedBy="cities")
     * @ORM\JoinColumn(name="county_id", referencedColumnName="id")
     * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
     */
    private $county;
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
     * Set city
     *
     * @param string $name
     *
     * @return City
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
     * Set zipcode
     *
     * @param string $zipcode
     *
     * @return City
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
        return $this;
    }
    /**
     * Get zipcode
     *
     * @return string
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }
    /**
     * Set county
     *
     * @param County $county
     *
     * @return City
     */
    public function setCounty($county)
    {
        $this->county = $county;
        return $this;
    }
    /**
     * Get county
     *
     * @return County
     */
    public function getCounty()
    {
        return $this->county;
    }
    public function getSluggableFields()
    {
        return [ 'name' ];
    }
    public function __toString() {
        return (string)  $this->zipcode.' '.$this->name;
    }
}