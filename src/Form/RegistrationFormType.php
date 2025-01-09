<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;

class RegistrationFormType extends AbstractType
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
            ->add("check", CheckboxType::class, [
                "mapped" => false,
                "attr" => [
                    "class" => "checkbox checkbox-sm",
                ],
                "constraints" => [
                    new IsTrue([
                        "message" => "Il faut accepter les conditions pour créer un compte.",
                    ]),
                ],
            ])
            ->add("password", PasswordType::class, [
                "mapped" => false,
                "attr" => [
                    "placeholder" => "Mot de passe",
                    "class" => "password-field",
                ],
                "constraints" => [
                    new Length([
                        "min" => 8,
                        "minMessage" => "Le mot de passe doit avoir au moins {{ limit }} caractères",
                    ]),
                ],
            ])
            ->add("confirmPassword", PasswordType::class, [
                "mapped" => false,
                "attr" => [
                    "placeholder" => "Confirmez le mot de passe",
                    "class" => "password-field",
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        // Add attributes to the <form> tag in twig
        $resolver->setDefaults([
            "data_class" => User::class,
            "attr" => [
                "id" => "sign_up_form",
                "class" => "card-body flex flex-col gap-5 p-10",
            ],
        ]);
    }
}
