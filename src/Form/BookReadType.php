<?php

namespace App\Form;

use App\Entity\BookRead;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookReadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('book', ChoiceType::class, [
                'choices' => $this->getBookChoices($options['books']),
                'attr' => [
                    "id" => "book",
                    "class" => "select"
                ]
            ])
            ->add('rating', ChoiceType::class, [
                'choices' => [
                    '0' => "0.00",
                    '1' => "1.00",
                    '2' => "2.00",
                    '3' => "3.00",
                    '4' => "4.00",
                    '5' => "5.00"
                ],
                'attr' => [
                    "id" => "rating",
                    "class" => "select"
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'placeholder' => "Notez-ici les idées importantes de l'oeuvre.",
                    'id' => 'description',
                    'class' => 'textarea'
                ]
            ])
            ->add('is_read', CheckboxType::class, [
                'required' => false,
                'attr' => [
                    'id' => 'is_read'
                ]
            ])
        ;
    }

    private function getBookChoices($books)
    {
        $choices = [];
        foreach ($books as $book) {
            $choices[$book->getName()] = $book;
        }

        return $choices;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BookRead::class,
            'books' => [],
            'attr' => ['id' => "book-read-form"]
        ]);
    }
}
