<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('slogan')
            ->add('description')
            ->add('ingredients')
            ->add('prix')
            ->add('imageUpload1')
            ->add('imageUpload2')
            ->add('imageUpload3')
            //->add('imageSrc1')
           // ->add('imageSrc2')
           // ->add('imageSrc3')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
