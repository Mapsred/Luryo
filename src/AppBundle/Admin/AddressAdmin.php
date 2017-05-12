<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Address;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class AddressAdmin
 * @package AppBundle\Admin
 */
class AddressAdmin extends AbstractAdmin
{

    /**
     * @param Address|mixed $object
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof Address ? $object->__toString() : 'Adresse';
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('address', null, ['label' => "Adresse"]);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('address', null, ['label' => "Adresse"])
            ->add("city", null, ['label' => "Ville"])
            ->add('_action', null, ['actions' => ['show' => null, 'edit' => null]]);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('address', null, ['label' => "Adresse"])
            ->add("city", 'sonata_type_model_list', ['label' => "Ville", 'btn_delete' => false]);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper->add('address', null, ['label' => "Adresse"])->add("city", null, ['label' => "Ville"]);
    }
}
