<?php

namespace App\Form;

use App\Entity\Matchs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class MatchsType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('name', ChoiceType::class, array(
				'choices' => $options['matchsOptions'],
				'label' => 'Match',
				'placeholder' => 'Choisir un match'))
			->add('results', TextType::class, array(
				'attr' => array('autocomplete' =>'off'),
				'label' => 'Resultat')
			);

	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => Matchs::class,
			'matchsOptions' => array()
		));
	}
}