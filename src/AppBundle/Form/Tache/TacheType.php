<?php

namespace AppBundle\Form\Tache;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class TacheType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('statut')

            ->add('description', TextareaType::class, array(
                'attr' => array('cols' => '5', 'rows' => '3'),
            ))
            ->add('objectif', TextareaType::class, array(
                'attr' => array('cols' => '5', 'rows' => '3'),
                'required' => false
            ))
            ->add('remarque', TextareaType::class, array(
                'attr' => array('cols' => '5', 'rows' => '3'),
                'required' => false
            ))
            ->add('ordre', IntegerType::class, array(
                'attr' => array('min' => '0'),
                'required' => false
            ))
        ;
    }

    /**
     * {@enhiritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Tache\Tache'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_tache';
    }
}