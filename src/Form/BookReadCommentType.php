<?php

namespace App\Form;

use App\Entity\BookRead;
use App\Entity\BookReadComment;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookReadCommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class, [
                'attr' => [
                    'placeholder' => "Contenu du commentaire",
                    'class' => 'textarea'
                ]
            ])
            ->add('book_read', EntityType::class, [
                'class' => BookRead::class,
                'choice_label' => 'id',
                'attr' => [
                    'class' => 'hidden'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BookReadComment::class,
            'attr' => [
                'id' => 'add-comment-form',
                'class' => 'mt-4 flex gap-2'
            ]
        ]);
    }
}
