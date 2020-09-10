<?php

namespace App\Form;

use App\Entity\Projets;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_site', TextType::class,[
                'required'=>true,
                'label'=>'Nom du site'
            ])
            ->add('outil', TextType::class,[
                'required'=>true,
                'label'=>'Outils'
            ])
            ->add('type', TextType::class,[
                'required'=>true,
                'label'=>'Type du site'
            ])
            ->add('description', TextType::class,[
                'required'=>true,
                'label'=>'Description'
            ])
            ->add('image', TextType::class,[
                'required'=>true,
                'label'=>'Image',
                'attr' =>[
                    'placeholder' => 'ex. image.jpg'
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
            'data_class' => Projets::class,
        ]);
    }
}
