<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('name', TextType::class, array('label' => 'Nom'))
			->add('email', EmailType::class)
			->add('username', TextType::class, array('label' => 'Nom d\'utilisateur'))
			->add('password', RepeatedType::class, array(
				'type' => PasswordType::class,
				'first_options' => array('label' => 'Mot de passe'),
				'second_options' => array('label' => 'Ressaisir mot de passe')
			));

	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => User::class,
		));
	}
}