<?php
/**
 * Created by PhpStorm.
 * User: maps_red
 * Date: 10/10/16
 * Time: 16:52
 */

namespace AppBundle\Admin;

use AppBundle\Entity\Image;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class ImageAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('file', 'file', array(
                'required' => false
            ))

            // ...
        ;
    }

    public function prePersist($image)
    {
        $this->manageFileUpload($image);
    }

    public function preUpdate($image)
    {
        $this->manageFileUpload($image);
    }

    /**
     * @param Image $image
     */
    private function manageFileUpload($image)
    {
        $entity = $image->getEntity();
        $this->uploadFile($image);
    }

    // ...
}