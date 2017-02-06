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
     * @param Travel|mixed $object
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof Travel ? $object->getTitle() : 'Voyage';
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with("Contenu", ['class' => "col-md-7"])
            ->add('title', 'text', ['label' => 'Titre'])
            ->add('places', 'integer', ['label' => 'Nombre de places'])
            ->add('price', 'number', ['label' => 'Prix'])
            ->add('description', 'textarea', ['label' => 'Description'])
            ->add("date", 'sonata_type_datetime_picker', ['label' => "Date du voyage"])
            ->add("interests", null, ['label' => 'Intérêts'])
            ->end()
            ->with("Image", ['class' => "col-md-5"])
            ->add('images','sonata_type_collection',
                ['by_reference' => false],
                ['edit' => 'inline', 'inline' => 'table']
            )
            ->end();
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
        $listMapper->add('id', null, ['label' => 'ID'])
            ->addIdentifier("title", null, ['label' => 'Titre'])
            ->add('places', null, ['label' => 'Nombre de places'])
            ->add("description");
    }
}