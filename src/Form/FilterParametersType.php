<?php

namespace App\Form;

use App\Entity\Origin;
use App\Repository\OriginRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterParametersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Température avec des plages prédéfinies entre 10°C et 30 °C
            ->add('temperature', ChoiceType::class, [
                'choices' => [
                    '1°C à 10°C' => '1-10',
                    '11°C à 20°C' => '11-20',
                    '21°C à 30°C' => '21-30',
                ],
                'required' => false,
                'label' => 'Température (°C)',
            ])

            // pH avec des plages prédéfinies entre 1 et 14
            ->add('ph', ChoiceType::class, [
                'choices' => [
                    '1-4' => '1-4',
                    '5-6.9' => '5-6.9',
                    '7-8.9' => '7-8.9',
                    '10-12' => '10-12',
                    '13-14' => '13-14',
                ],
                'required' => false,
                'label' => 'pH',
            ])

            // GH avec des plages prédéfinies entre 1 et 34)
            ->add('gh', ChoiceType::class, [
                'choices' => [
                    '1-4' => '1-4',
                    '5-8' => '5-8',
                    '9-12' => '9-12',
                    '13-16' => '13-16',
                    '17-20' => '17-20',
                    '21-24' => '21-24',
                    '25-28' => '25-28',
                    '29-32' => '29-32',
                    '33-34' => '33-34',
                ],
                'required' => false,
                'label' => 'GH',
            ])

            // Taille adulte avec des plages prédéfinies (exemple de tailles)
            ->add('adultSize', ChoiceType::class, [
                'choices' => [
                    '0-2 cm' => '0-2',
                    '3-6 cm' => '3-6',
                    '7-10 cm' => '7-10',
                    '10-15 cm' => '10-15',
                    '16-25 cm' => '16-25',
                    '26 cm et plus' => '26+',
                ],
                'required' => false,
                'label' => 'Taille adulte (cm)',
            ]);
    }

    // Cette méthode permet de supprimer l'ajout du prefixe "filter_parameters" devant les paramètres dans l'URL
    public function getBlockPrefix(): string
    {
        return '';
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }
}
