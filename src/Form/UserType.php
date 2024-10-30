<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
	        ->add('lastName', TextType::class, [
				"required" => true,
		        "label" => "Nom*"
	        ])
	        ->add('firstName', TextType::class, [
		        "required" => true,
		        "label" => "Prénom*"
	        ])
	        ->add('roles', ChoiceType::class, [
				'label' => 'Vous êtes:*',
		        'choices'  => [
			        'Propriétaire' => 'ROLE_PROPRIETAIRE',
			        'Locataire' => 'ROLE_LOCATAIRE'
		        ],
	        ])
            ->add('email', EmailType::class, [
				"required" => true,
	            "label" => 'Email*'
            ])
            ->add('password', RepeatedType::class, [
	            "required" => true,
	            'type' => PasswordType::class,
	            'invalid_message' => 'Les champs mot de passe doivent être identiques.',
	            'first_options'  => ['label' => 'Mot de passe*'],
	            'second_options' => ['label' => 'Répétez le mot de passe*'],
            ])
	        ->add('save', SubmitType::class, [
				"label" => "créer un compte"
	        ])
        ;
	    $builder->get('roles')
		    ->addModelTransformer(new CallbackTransformer(
			                          function ($rolesArray) {
				                          // transform the array to a string
				                          return count($rolesArray)? $rolesArray[0]: null;
			                          },
			                          function ($rolesString) {
				                          // transform the string back to an array
				                          return [$rolesString];
			                          }
		                          ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
