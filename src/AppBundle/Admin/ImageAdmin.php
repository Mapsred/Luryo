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
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ImageAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        // get the current Image instance
        /** @var Image $image */
        $image = $this->getSubject();

        // use $fileFieldOptions so we can add other options to the field
        $fileFieldOptions = array('required' => false);
        if ($image && ($path = $image->getPath())) {
            // get the container so the full path to the image can be set
            $container = $this->getConfigurationPool()->getContainer();
            $fullPath = $container->get('request_stack')->getCurrentRequest()->getBasePath().'/uploads/images/'.$path;

            // add a 'help' option containing the preview's img tag
            $fileFieldOptions['help'] = '<img src="'.$fullPath.'" class="admin-preview" />';
        }
        $fileFieldOptions['label'] = 'Image';
        $formMapper->add('file', 'file', $fileFieldOptions);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id')->add('path');
    }

    /**
     * @param ListMapper $listMapper
     */
//    protected function configureListFields(ListMapper $listMapper)
//    {
//        $listMapper->addIdentifier('id')->add("path");
//    }

    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
            ->add('file', 'image', array(
                'prefix' => '/',
            ))
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
            ->add('file', 'image', array(
                'prefix' => '/',
                'width' => 100
            ))
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
        if ($image->getFile()) {
            $image->refreshUpdated();
        }
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof Image ? $object->getPath() : 'Image'; // shown in the breadcrumb on the create view
    }
}