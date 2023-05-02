<?php

namespace App\Form\Book;

use App\Entity\Book;
use App\Entity\Publisher;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Название',
            ])
            ->add('first_name', TextType::class, [
                'label' => 'Имя автора',
                'mapped' => false,
            ])
            ->add('last_name', TextType::class, [
                'label' => 'Фамилия автора',
                'mapped' => false,
            ])
            ->add('publisher', EntityType::class, [
                'class' => Publisher::class,
                'label' => 'Издатель',
                'choice_label' => 'name',
            ])
            ->add('year_of_publishing', NumberType::class, [
                'label' => 'Год издания',
            ])
            ->add('save', SubmitType::class, ['label' => 'Сохранить']);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
