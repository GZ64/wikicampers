<?php

namespace App\Form;

use App\Entity\Advert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeImmutableToDateTimeTransformer;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdvertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Titre'])
            ->add('description')
            ->add('pricePerDay', NumberType::class, ['label' => 'Prix par jour'])
            ->add('availability', DateTimeType::class, ['label' => 'Disponibilité'])
            ->add('city', TextType::class, ['label' => 'Ville'])
	        ->add('equipment', CollectionType::class, [
				'label' => 'Equipements',
		        'entry_type' => EquipmentType::class,
		        'allow_add' => true,
				'allow_delete' => true,
		        'by_reference' => false,
		        'entry_options' => ['label' => false],
		        'attr' => [
					'data-controller' => 'form-collection',
				        'data-form-collection-add-label-value' => 'Ajouter un équipement',
			        'data-form-collection-delete-label-value' => 'Supprimer un équipement'
		        ]
	        ])
	        ->add('thumbnails', CollectionType::class, [
				'label' => 'Photos',
		        'entry_type' => ThumbnailType::class,
		        'allow_add' => true,
		        'allow_delete' => true,
		        'by_reference' => false,
		        'entry_options' => ['label' => false],
		        'attr' => [
			        'data-controller' => 'form-collection',
			        'data-form-collection-add-label-value' => 'Ajouter une image',
			        'data-form-collection-delete-label-value' => 'Supprimer une image'
		        ]
	        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Advert::class,
        ]);
    }
}
