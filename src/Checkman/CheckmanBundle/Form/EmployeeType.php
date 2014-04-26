<?php

namespace Checkman\CheckmanBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EmployeeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', null, array("mapped" => false))
            ->add('firstName')
            ->add('secondName')
            ->add('salary')
            ->add('notes')
            ->add('region_id')
            ->add('status')
            ->add('involvementsDiff', null, array('mapped' => false, 'read_only' => true))
            ->add('projects', null, array('mapped' => false, 'read_only' => true))
            ->add('occupations', null, array("required" => false));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Checkman\CheckmanBundle\Entity\Employee',
            'csrf_protection' => false
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return '';
    }
}
