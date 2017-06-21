<?php

namespace AppBundle\Entity;

class Search
{
    /** @var City $location */
    private $location;
    /** @var \DateTime $date */
    private $date;
    /** @var float $price */
    private $price;
    /** @var string $choice */
    private $choice;
    /** @var string $sort */
    private $sort;
    /** @var string $order */
    private $order;

    /**
     * @return City
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param City $location
     * @return Search
     */
    public function setLocation(City $location = null)
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

    /**
     * @return string
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @param string $sort
     * @return Search
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param string $order
     * @return Search
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }


}