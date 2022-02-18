<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                'label' => 'EMAIL'
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'label' => "MOT DE PASSE",
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe'
                    ]),
                ],
            ])
            ->add('firstname',TextType::class,[
                'label' => 'PRENOM'
            ])
            ->add('lastname',TextType::class,[
                'label' => 'NOM'
            ])
            ->add('dateofbirth',DateType::class,[
                'label' => 'DATE DE NAISSANCE',
                'widget' => 'single_text'
                
            ])
            ->add('adress',TextType::class,[
                'label' => 'Votre adresse',
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez renseigner l'adresse.",
                    ]),
                ],
            ])
            ->add('cp',TextType::class,[
                'label' => 'Votre code postale',
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner le code postale.',
                    ]),
                ],
            ])
            ->add('city',TextType::class,[
                'label' => 'Votre ville',
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner la ville.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
           
        ]);
    }
}
