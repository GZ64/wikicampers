<?php

namespace App\Form;

use App\Data\SearchData;
use App\Entity\Equipment;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('q', TextType::class, [
				'label' => false,
	            'required' => false,
	            'attr' => [
					'placeholder' => 'Rechercher'
	            ]
            ])
	        ->add('city', TextType::class, [
				'label' => false,
		        'required' => false,
	        ])
	        ->add('pricePerDayMin', NumberType::class, [
		        'label' => false,
		        'required' => false,
		        'attr' => [
			        'placeholder' => 'Prix minimum'
		        ]
	        ])
	        ->add('pricePerDayMax', NumberType::class, [
		        'label' => false,
		        'required' => false,
		        'attr' => [
			        'placeholder' => 'Prix maximum'
		        ]
	        ])
	        ->add('availability', DateTimeType::class, [
				'label' => false,
		        'required' => false,
	        ])
	        ->add('equipment', EntityType::class, [
				'label' => false,
		        'required' => false,
		        'class' => Equipment::class,
		        'expanded' => true,
		        'multiple' => true
	        ])
	        ->add('campingCarSize', NumberType::class, [
				'label' => false,
		        'required' => false,
		        'attr' => [
					'placeholder' => 'Taille du camping-car'
		        ]
	        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
	        'method' => 'GET',
	        'csrf_protection' => false
        ]);
    }
	
	public function getBlockPrefix() {
		return '';
	}
}
