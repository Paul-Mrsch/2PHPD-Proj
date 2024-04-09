<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', null, ['label' => 'First Name', 'required' => true, 'attr' => ['placeholder' => 'First Name'], 'constraints' => [new NotBlank(['message' => 'Please enter your first name.'])]])
            ->add('lastName', null, ['label' => 'Last Name', 'required' => true, 'attr' => ['placeholder' => 'Last Name'], 'constraints' => [new NotBlank(['message' => 'Please enter your last name.'])]])
            ->add('username', null, ['label' => 'Username', 'required' => true, 'attr' => ['placeholder' => 'Username'], 'constraints' => [new NotBlank(['message' => 'Please enter your username.'])]])
            ->add('email', null, ['label' => 'Email', 'required' => true, 'attr' => ['placeholder' => 'Email'], 'constraints' => [new NotBlank(['message' => 'Please enter your email.'])]])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
