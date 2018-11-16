<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\CallbackTransformer;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom article'
            ])
            ->add('categorie', ChoiceType::class, [
                'choices'  => array(
                    'Canard' => 'canard',
                    'Espadon' => 'espadon',
                    'Girafe' => 'jambon',
                    'Jambon' => 'girafe',
                    'Sous-Marin' => 'sousmarin',
                ),
            ])
            ->add('prix')
            ->add('description')
            ->add('note')
            ->add('avis')
            ->add('photo', FileType::class,
                [
                    'label' => 'Photo',
                    'data_class' => null,
                ])
            ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
