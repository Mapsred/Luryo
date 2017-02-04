<?php
/**
 * Created by PhpStorm.
 * User: Maps_red
 * Date: 11/10/2016
 * Time: 00:31
 */

namespace AppBundle\Admin;

use UserBundle\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class UserAdmin extends AbstractAdmin
{
    /**
     * @param User|mixed $object
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof User ? $object->getUsername() : 'Utilisateur';
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $roles = ['ROLE_ADMIN' => 'ROLE_ADMIN', 'ROLE_USER' => 'ROLE_USER', 'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN'];
        $formMapper
            ->tab('Utilisateur')
            ->with("Profil", ['class' => "col-md-6"])
            ->add('username', 'text', ['label' => 'Nom d\'utilisateur'])
            ->add('firstname', 'text', ['label' => 'Prénom'])
            ->add('lastname', 'text', ['label' => 'Nom de famille'])
            ->add("interests", null, ['label' => 'Intérêts'])
            ->end()
            ->with("Général", ['class' => "col-md-6"])
            ->add('email', 'email')
            ->add('birthday', 'date', ['label' => 'Date de naissance'])
            ->add('sexe', 'choice', ['multiple' => false, 'choices' => ['Homme' => "Homme", 'Femme' => "Femme"]])
            ->add('address', null, ['label' => 'Adresse'])
            ->end()
            ->end()
            ->tab('Sécurité')
            ->with("Statut", ['class' => "col-md-6"])
            ->add('enabled', 'checkbox', ['label' => 'Activé'])
            ->end()
            ->with("Rôles", ['class' => "col-md-6"])
            ->add('roles', 'choice', ['multiple' => true, 'choices' => $roles])
            ->end()
            ->end();
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('username')->add('email');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('username', null, ['label' => 'Nom d\'utilisateur'])
            ->add('email')
            ->add('enabled', null, ['label' => 'Activé'])
            ->add('created_at', 'datetime', ['label' => 'Créé le'])
        ;
    }

}



