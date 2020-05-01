<?php


namespace Zavoca\CoreBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Zavoca\CoreBundle\Entity\System;
use Zavoca\CoreBundle\Entity\User;
use Zavoca\CoreBundle\Enums\Boolean;

class UserBaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname',
                TextType::class,
                [
                    'label' => 'Firstname'
                ]
            )
            ->add('lastname',
                TextType::class,
                [
                    'label' => 'Lastname'
                ]
            )
            ->add('telephone',
                TextType::class,
                [
                    'label' => 'Telephone',
                    'required' => false
                ]
            )
            ->add('mobile',
                TextType::class,
                [
                    'label' => 'Mobile'
                ]
            )
            ->add('email',
                EmailType::class,
                [
                    'label' => 'Email',
                    'disabled' => 'disabled'
                ]
            )
            ->add('address',
                TextareaType::class,
                [
                    'label' => 'Address'
                ]
            )
            ->add('zipcode',
                TextType::class,
                [
                    'label' => 'Postal Code',
                    'required' => false
                ]
            )
            ->add('country',
                CountryType::class,
                [
                    'label' => 'Country'
                ]
            )
            ->add('autoDarkMode',
                ChoiceType::class,
                [
                    'choices' => Boolean::getFOList(),
                    'multiple' => false,
                    'expanded' => true,
                    'label' => "Automatic dark mode",
                    'help' => 'Dark theme will be applied between 6.00pm to 6.00am'
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}