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
            ->add('searchModifier', TextType::class)
            ->add('submit', SubmitType::class)
            ->add('industry', TextType::class)
            ->add('hasSalary', CheckboxType::class)
            ->add('employment', ChoiceType::class, [
                'choices'  => [
                    'Полная занятость' => 'full',
                    'Частичная занятость' => 'part',
                    'Проектная работа' => 'project',
                    'Волонтерство' => 'volunteer',
                    'Стажировка' => 'probation',
                ],
            ])
            ->add('schedule', ChoiceType::class, [
                'choices'  => [
                    'Полный день' => 'fullDay',
                    'Сменный график' => 'shift',
                    'Гибкий график' => 'flexible',
                    'Удаленная работа' => 'remote',
                    'Вахтовый метод' => 'flyInFlyOut',
                ],
            ])
            ->add('experience', ChoiceType::class, [
                'choices'  => [
                    'Нет опыта' => 'noExperience',
                    'От 1 года до 3 лет' => 'between1And3',
                    'От 3 до 6 лет' => 'between3And6',
                    'Более 6 лет' => 'moreThan6',
                ],
            ])
        ;
    }

}
