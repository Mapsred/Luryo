<?php

namespace AppBundle\Admin;

use AppBundle\Entity\County;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CountyAdmin extends AbstractAdmin
{
    /**
     * @param County|mixed $object
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof County ? $object->__toString() : 'Département';
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, ['label' => "Nom"])
            ->add('code', null, ['label' => "Code Départemental"]);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name', null, ['label' => "Nom"])
            ->add('code', null, ['label' => "Code Départemental"])
            ->add('_action', null, ['actions' => ['show' => null, 'edit' => null]]);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', null, ['label' => "Nom"])
            ->add('code', null, ['label' => "Code Départemental"]);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name', null, ['label' => "Nom"])
            ->add('code', null, ['label' => "Code Départemental"]);
    }
}
