<?php

namespace App\Form;

use App\Entity\Fish;
use App\Entity\FishFamily;
use App\Entity\Origin;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class AddFishType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le nom ne peut pas être vide.',
                    ]),
                    new Length([
                        'max' => 50,
                        'maxMessage' => 'Le nom ne doit pas dépasser {{ limit }} caractères.',
                    ]),
                ],
            ])
            ->add('latinName', TextType::class, [
                'label' => 'Nom Latin',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le nom latin ne peut pas être vide.',
                    ]),
                    new Length([
                        'max' => 50,
                        'maxMessage' => 'Le nom latin ne doit pas dépasser {{ limit }} caractères.',
                    ]),
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'constraints' => [
                    new NotBlank([
                        'message' => 'La description ne peut pas être vide.',
                    ]),
                    new Length([
                        'max' => 1000,
                        'maxMessage' => 'La description ne doit pas dépasser {{ limit }} caractères.',
                    ]),
                ],
            ])
            ->add('adultSize', NumberType::class, [
                'label' => 'Taille Adulte (en cm)',
                'constraints' => [
                    new NotBlank([
                        'message' => 'La taille adulte est requise.',
                    ]),
                    new Range([
                        'min' => 1,
                        'max' => 100,
                        'notInRangeMessage' => 'La taille adulte doit être comprise entre 1 et 100 cm.',

                    ]),
                ],
            ])
            ->add('minTemp', NumberType::class, [
                'label' => 'Température Minimum (°C)',
                'constraints' => [
                    new NotBlank([
                        'message' => 'La température minimum est requise.',
                    ]),
                ],
            ])
            ->add('maxTemp', NumberType::class, [
                'label' => 'Température Maximum (°C)',
                'constraints' => [
                    new NotBlank([
                        'message' => 'La température maximum est requise.',
                    ]),
                    new Callback([$this, 'validateTemperature']),
                ],
            ])
            ->add('minPh', NumberType::class, [
                'label' => 'pH Minimum',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le pH minimum est requis.',
                    ]),
                    new Range([
                        'min' => 1,
                        'max' => 14,
                        'notInRangeMessage' => 'Le pH doit être compris entre 1 et 14.',
                    ]),
                ],
            ])
            ->add('maxPh', NumberType::class, [
                'label' => 'pH Maximum',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le pH maximum est requis.',
                    ]),
                    new Range([
                        'min' => 1,
                        'max' => 14,
                        'notInRangeMessage' => 'Le pH doit être compris entre 1 et 14.',
                    ]),
                    new Callback([$this, 'validatePh']),
                ],
            ])
            ->add('minGh', NumberType::class, [
                'label' => 'GH Minimum',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le GH minimum est requis.',
                    ]),
                    new Range([
                        'min' => 1,
                        'max' => 34,
                        'notInRangeMessage' => 'Le Gh doit être compris entre 1 et 34.',
                    ]),
                ],
            ])
            ->add('maxGh', NumberType::class, [
                'label' => 'GH Maximum',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le GH maximum est requis.',
                    ]),
                    new Range([
                        'min' => 1,
                        'max' => 34,
                        'notInRangeMessage' => 'Le Gh doit être compris entre 1 et 34.',
                    ]),
                    new Callback([$this, 'validateGh']),
                ],
            ])

            ->add('imageName', FileType::class, [
                'label' => 'Image',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Image()
                ],
            ])
            ->add('family', EntityType::class, [
                'class' => FishFamily::class,
                'choice_label' => 'name',
            ])
            ->add('origin', EntityType::class, [
                'class' => Origin::class,
                'choice_label' => 'continent',
            ])
            
            ->add('submit', SubmitType::class, [
                'label'=> 'Ajout'
            ]);
    }

    public function validateTemperature($value, ExecutionContextInterface $context)
    {
        $form = $context->getRoot();
        $minTemp = $form->get('minTemp')->getData();
        if ($value <= $minTemp) {
            $context->buildViolation('La température maximale doit être supérieure à la température minimale.')
                ->addViolation();
        }
    }

    public function validatePh($value, ExecutionContextInterface $context)
    {
        $form = $context->getRoot();
        $minPh = $form->get('minPh')->getData();
        if ($value <= $minPh) {
            $context->buildViolation('Le pH maximal doit être supérieur au pH minimal.')
                ->addViolation();
        }
    }

    public function validateGh($value, ExecutionContextInterface $context)
    {
        $form = $context->getRoot();
        $minGh = $form->get('minGh')->getData();
        if ($value <= $minGh) {
            $context->buildViolation('Le GH maximal doit être supérieur au GH minimal.')
                ->addViolation();
        }
    }



    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fish::class,
        ]);
    }
}
