<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('motif', ChoiceType::class,[
                'label' => 'Motif',
                'choices' => [
                    "Le canard que j'ai recu n'est pas de la bonne couleur. Que dois-je faire?" => 1,
                    "Mon sous-marin a torpillé la maison du voisin lors du démarrage. Est-ce normal?" => 2,
                    "Ma girafe a mangé mes 2 enfants, je souhaite faire une demande de remboursement." => 3,
                    "Mon espadon tente de s'échapper lorsque je l'utilise en tant que fleuret. Pouvez vous me faire parvenir un manuel d'utilisation?" => 4,
                    "Le Jambon, c'est vraiment très bon." => 5
                ],
            ])
            ->add('nom', TextType::class,[
                'label' => 'Nom',
            ])
            ->add('prenom', TextType::class,[
                'label' => 'Prenom',
            ])
            ->add('email', EmailType::class,[
                'label' => 'Email',
            ])
            ->add('message', TextareaType::class,[
                'label' => 'Votre message',
                'data' => 'Le saviez vous? Google est le seul endroit ou vous pouvez taper Chuck Norris...',
            ])
            ->add("aze", CheckboxType::class,[
                'label' => "En cochant cette case, je confirme utiliser le service de contact uniquement pour me plaindre de iComm",
            ])
            ->add('Modifier', SubmitType::class, array('label' => 'Contactez nous!'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
