<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminAddUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class,[
                'label' => 'Email'
            ])
            ->add('name', TextType::class,[
                'label' => 'Nom'
            ])
            ->add('password', TextType::class,[
                'label' => 'Mot de passe'
            ])
            ->add('roles', ChoiceType::class, array(
                'choices'  => array(
                    'Admin' => "ROLE_ADMIN",
                    'User' => "ROLE_USER",
                ),
                'multiple' => true,
            ))
            ->add('Modifier', SubmitType::class, array('label' => 'Enregistrer'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
