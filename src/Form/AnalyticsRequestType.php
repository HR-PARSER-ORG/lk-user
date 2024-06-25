<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class AnalyticsRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('searchField', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Поле поиска не должно быть пустым']),
                ],
            ])
            ->add('qualificationLevel', TextType::class)
            ->add('region', CollectionType::class)
            ->add('vmi', CheckboxType::class)
            ->add('searchModifier', CollectionType::class)
            ->add('submit', SubmitType::class)
            ->add('industry', CollectionType::class)
            ->add('hasSalary', CheckboxType::class)
            ->add('employment', TextType::class)
            ->add('schedule', TextType::class)
            ->add('experience', TextType::class)
        ;
    }

}
