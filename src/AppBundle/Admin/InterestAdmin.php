<?php
/**
 * Created by PhpStorm.
 * User: maps_red
 * Date: 10/10/16
 * Time: 16:05
 */

namespace AppBundle\Admin;

use AppBundle\Entity\Interest;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class InterestAdmin
 * @package AppBundle\Admin
 */
class InterestAdmin extends AbstractAdmin
{
    /**
     * @param Interest|mixed $object
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof Interest ? $object->getName() : 'Intérêt';
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with("Contenu", ['class' => "col-md-7"])
            ->add('name', 'text', ['label' => 'Nom'])

            ->end();
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->add('id', null, ['label' => 'ID'])
            ->addIdentifier("name", null, ['label' => 'Nom'])
            ->add("userCount", null, ['label' => 'Nombre d\'utilisateurs'])
            ->add("travelCount", null, ['label' => 'Nombre de voyages']);
    }
}