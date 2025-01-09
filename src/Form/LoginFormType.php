<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("email", EmailType::class, [
                "attr" => [
                    "class" => "input",
                    "placeholder" => "Adresse email",
                ]
            ])
            ->add("password", PasswordType::class, [
                "attr" => [
                    "placeholder" => "Mot de passe",
                    "class" => "password-field",
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        // Add attributes to the <form> tag in twig
        $resolver->setDefaults([
            "data_class" => User::class,
            "attr" => [
                "id" => "sign_in_form",
                "class" => "card-body flex flex-col gap-5 p-10",
            ],
        ]);
    }
}
