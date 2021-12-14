<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',TextType::class,[
                'required' => false,
                'label' => 'Votre email',
                'attr' => array('placeholder' => 'exemple@exemple.fr'),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez inscrire votre email.'
                    ]),
                ]
            ])
            ->add('subject',TextType::class,[
                'required' => false,
                'label' => 'Sujet du message',
                'attr' => array('placeholder' => 'Tapez votre mot de passe...'),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez renseigner le sujet de votre message.'
                    ]),
                ]
            ])
            ->add('content',TextareaType::class,[
                'required' => false,
                'label' => 'Contenu du message',
                'attr' => array('cols' => '5', 'rows' => '8', 'placeholder' => '  Tapez votre message...'),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez rédiger un contenu.'
                    ]),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
