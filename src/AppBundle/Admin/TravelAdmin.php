<?php
/**
 * Created by PhpStorm.
 * User: maps_red
 * Date: 10/10/16
 * Time: 16:05
 */

namespace AppBundle\Admin;

use AppBundle\Entity\Travel;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class TravelAdmin
 * @package AppBundle\Admin
 */
class TravelAdmin extends AbstractAdmin
{
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with("Contenu", ['class' => "col-md-9"])
            ->add('title', 'text', ['label' => 'Titre'])
            ->add('places', 'integer', ['label' => 'Nombre de places'])
            ->add('description', 'textarea', ['label' => 'Description'])
            ->end()
            ->with("Image", ['class' => "col-md-3"])
            ->add('image')
            ->end()
        ;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title')->add('places');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id')->add("title")->add('places')->add("description");
    }

    public function toString($object)
    {
        return $object instanceof Travel
            ? $object->getTitle()
            : 'Voyage'; // shown in the breadcrumb on the create view
    }
}