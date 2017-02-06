<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMbehaviors;
use UserBundle\Entity\Favorite;

/**
 * Travel
 *
 * @ORM\Table(name="travel")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TravelRepository")
 */
class Travel
{
    use ORMbehaviors\Timestampable\Timestampable;
    use ORMbehaviors\Sluggable\Sluggable;

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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="places", type="integer")
     */
    private $places;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Image", mappedBy="travel", cascade={"all"})
     * @ORM\JoinTable(name="images")
     */
    private $images;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var ArrayCollection $interests
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Interest", inversedBy="travels")
     */
    private $interests;

    /**
     * @var $price
     *
     * @ORM\Column(type="float", name="price")
     */
    private $price;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Order", mappedBy="travel", cascade={"persist"})
     */
    private $orders;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="UserBundle\Entity\Favorite", mappedBy="travel", cascade={"all"})
     * @ORM\JoinTable("user_favorites")
     */
    private $favorites;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status = "open";

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var Address $address
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Address", cascade={"persist"})
     */
    private $address;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->interests = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->favorites = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     *
     * @return Travel
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
     * Set places
     *
     * @param integer $places
     *
     * @return Travel
     */
    public function setPlaces($places)
    {
        $this->places = $places;

        return $this;
    }

    /**
     * Get places
     *
     * @return int
     */
    public function getPlaces()
    {
        return $this->places;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Travel
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

    /**
     * Get images
     *
     * @return ArrayCollection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set images
     *
     * @param ArrayCollection $images
     *
     * @return Travel
     */
    public function setImages($images)
    {
        $this->images = new ArrayCollection();
        /** @var Image $image */
        foreach ($images as $image) {
            $this->addImage($image);
        }

        return $this;
    }

    /**
     * Add image
     *
     * @param Image $image
     *
     * @return Travel
     */
    public function addImage(Image $image)
    {
        $this->images[] = $image;
        $image->setTravel($this);

        return $this;
    }

    /**
     * Remove image
     *
     * @param Image $image
     */
    public function removeImage(Image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Add interest
     *
     * @param Interest $interest
     *
     * @return Travel
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
     * Set price
     *
     * @param float $price
     *
     * @return Travel
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Add order
     *
     * @param Order $order
     *
     * @return Travel
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
     * Add favorite
     *
     * @param Favorite $favorite
     *
     * @return Travel
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
     * Get favorite
     *
     * @return ArrayCollection|Favorite[]
     */
    public function getFavorite()
    {
        return $this->favorites;
    }

    /**
     * Returns an array of the fields used to generate the slug.
     *
     * @return array
     */
    public function getSluggableFields()
    {
        return ["title"];
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Travel
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get favorites
     *
     * @return ArrayCollection|Favorite[]
     */
    public function getFavorites()
    {
        return $this->favorites;
    }

    /**
     * @return int
     */
    public function getAvailablePlaces()
    {
        return $this->getPlaces() - count($this->getOrders());
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Travel
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
     * Set address
     *
     * @param Address $address
     *
     * @return Travel
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
}
