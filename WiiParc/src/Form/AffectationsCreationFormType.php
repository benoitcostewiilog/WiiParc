<?php

namespace App\Form;

use App\Entity\Affectations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\ParcCreationFormType;
use App\Form\SocieteCreationFormType;

class AffectationsCreationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dentree', DateTimeType::class, array(
                'label' => 'Date d\'entrée',
                'widget' => 'single_text', 
                'format' => "MM/dd/yyyy", 
                ))
            ->add('dsortie', DateTimeType::class, array(
                'label' => 'Date de sortie',
                'widget' => 'single_text', 
                'format' => "MM/dd/yyyy", 
                ))
            ->add('parc', ParcCreationFormType::class, array('label' => 'Id de parc'))
            ->add('societe', SocieteCreationFormType::class, array('label' => 'Id de société'))
            ->add('nparc', TextType::class, array('label' => 'Numéro de parc'))
            ->add('validation', SubmitType::class, array('label' => 'Valider'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Affectations::class,
        ]);
    }
}
