<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Tag;
use App\Repository\TagRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProductType extends AbstractType
{
    private $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder
            ->add('name',TextType::class,[
                'label' => 'Nom du produit'
            ])
            ->add('size',TextType::class,[
                'label' => 'Donner une taille'
            ])
            ->add('price',MoneyType::class,[
                'currency' => 'EUR'
            ])
            ->add('description',TextType::class,[
                'label' => 'Donner une description'
            ])
            ->add('file',FileType::class,[
                'label' => 'Ajouter une image',
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1m'
                    ])
                ],
            ])
            ->add('tag',EntityType::class,[
                'label' => 'Choisir un Tag',
                'placeholder' => '--Choisir un tag--',
                'class' => Tag::class,
                'choices' => $this->tagRepository->findBy([
                    'category' => $options['data']->getCategory()
                ])
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
