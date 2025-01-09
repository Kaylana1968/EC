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
            ->add('book_id', ChoiceType::class, [
                'choices' => $this->getBookChoices($options['books']),
                'attr' => [
                    "id" => "book",
                    "class" => "select"
                ]
            ])
            ->add('rating', ChoiceType::class, [
                'choices' => [
                    '1' => 1,
                    '1.5' => 1.5,
                    '2' => 2,
                    '2.5' => 2.5,
                    '3' => 3,
                    '3.5' => 3.5,
                    '4' => 4,
                    '4.5' => 4.5,
                    '5' => 5
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
                'mapped' => false,
                'attr' => [
                    'value' => 0
                ]
            ])
        ;
    }

    private function getBookChoices($books)
    {
        $choices = [];
        foreach ($books as $book) {
            $choices[$book->getName()] = $book->getId();
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
