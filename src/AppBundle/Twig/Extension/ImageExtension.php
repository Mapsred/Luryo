<?php

namespace AppBundle\Twig\Extension;

use AppBundle\Entity\Image;

class ImageExtension extends \Twig_Extension
{
    private $webDir;

    /**
     * ImageExtension constructor.
     * @param $webDir
     */
    public function __construct($webDir)
    {
        $this->webDir = $webDir;
    }

    public function getFilters()
    {
        return [new \Twig_SimpleFilter('image', [$this, 'getImage'])];
    }


    public function getImage(Image $image)
    {
        return $this->webDir.$image->getPath();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'image';
    }
}
