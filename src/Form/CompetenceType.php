<?php

namespace App\Form;

use App\Entity\Competences;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CompetenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', TextType::class,[
                'required'=>true,
                'label'=>'Type du compétence'
            ])
            ->add('nom', TextType::class,[
                'required'=>true,
                'label'=>'Nom du compétence'
            ])
            ->add('picto', FileType::class,[
                'required'=>true,
                'mapped' => false,
                'label'=>'Picto',
                'attr' =>[
                    'placeholder' => 'ex. picto.jpg'
                ]
            ])

            ->add('save', SubmitType::class, [
                'label' =>'Valider'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Competences::class,
        ]);
    }
}
