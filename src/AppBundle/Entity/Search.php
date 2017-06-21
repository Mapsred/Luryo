<?php

namespace AppBundle\Entity;

class Search
{
    /** @var string $location */
    private $location;
    /** @var \DateTime $date */
    private $date;
    /** @var float $price */
    private $price;
    /** @var string $choice */
    private $choice;

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     * @return Search
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @return Search
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return Search
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return string
     */
    public function getChoice()
    {
        return $this->choice;
    }

    /**
     * @param string $choice
     * @return Search
     */
    public function setChoice($choice)
    {
        $this->choice = $choice;

        return $this;
    }
}