<?php

namespace AppBundle\Admin;

use AppBundle\Entity\City;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CityAdmin extends AbstractAdmin
{
    /**
     * @param City|mixed $object
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof City ? $object->__toString() : 'Ville';
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, ['label' => "Nom"])
            ->add('zipcode', null, ['label' => "Code Postal"])
            ->add("county", null, ['label' => "Département"])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name', null, ['label' => "Nom"])
            ->add('zipcode', null, ['label' => "Code Postal"])
            ->add("county", null, ['label' => "Département"])
            ->add('_action', null, ['actions' => ['show' => null, 'edit' => null]]);

    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', null, ['label' => "Nom"])
            ->add('zipcode', null, ['label' => "Code Postal"])
            ->add("county", "sonata_type_model_list", ['label' => "Département", 'btn_delete' => false]);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name', null, ['label' => "Nom"])
            ->add('zipcode', null, ['label' => "Code Postal"])
            ->add("county", null, ['label' => "Département"]);
    }
}
