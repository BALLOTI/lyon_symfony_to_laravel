<?php

namespace ForumBundle\Form;

use ForumBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', TextType::class, [
                    "attr" => [
                        "class" => "white-text"
                    ],
                    "label" => "Identifiant",
                    "label_attr" => [
                        "class" => "white-text",
                    ]
                ])
                ->add('password', PasswordType::class, [
                    "attr" => [
                        "class" => "white-text",
                    ],
                    "label" => "Mot de passe",
                    "label_attr" => [
                        "class" => "white-text",
                    ]
                ])
                ->add('submit', SubmitType::class, ["label" => "Se connecter"]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }

    public function getBlockPrefix()
    {
        return 'forum_bundle_login_type';
    }
}
