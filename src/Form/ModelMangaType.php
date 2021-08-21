<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\ModelManga;
use Doctrine\DBAL\Types\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType as TypeDateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModelMangaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Name')
            ->add('CharacterName')
            ->add('Series')
            ->add('Price')
            ->add('Material')
            ->add('UsingModel')
            ->add('image',
                    FileType::class,
                    [
                        'label' => 'Image',
                        'data_class' => null,
                        'required' => is_null($builder -> getData() -> getImage()),
                    ])
                    ->add('Category',
                    EntityType::class,
                    [
                        'class' => Category::class,
                        'choice_label' => 'name',
                        'multiple' => false,
                        'expanded' => false
                    ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ModelManga::class,
        ]);
    }
}
