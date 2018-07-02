<?php

namespace App\Form;

use App\Entity\Parc;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ParcCreationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', TextType::class)
            ->add('marque', TextType::class)
            ->add('nserie', TextType::class, array('label' => 'Numéro de série'))
            ->add('propriete', TextType::class, array('label' => 'Propriété'))
            ->add('immatriculation', TextType::class)
            ->add('annee', IntegerType::class, array('label' => 'Année'))
            ->add('commentaires', TextType::class)
            ->add('validation', SubmitType::class, array('label' => 'Valider'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Parc::class,
        ]);
    }
}
