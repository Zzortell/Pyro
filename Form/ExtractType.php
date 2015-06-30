<?php

namespace Zz\PyroBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ExtractType extends AbstractType
{
	protected $typeFactory;
	
	public function __construct ( TypeFactory $typeFactory )
	{
		$this->typeFactory = $typeFactory;
	}
	
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('video', 			'entity', [
				'class' 	=> 'ZzPyroBundle:Video',
				'property' 	=> 'title',
				'multiple' 	=> false
			])
			->add('newVideo', 		$this->typeFactory->createVideoType(),
										[ 'mapped' => false ])
			->add('startSeconds', 	'integer')
			->add('endSeconds', 	'integer')
			->add('save', 			'submit')
		;
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Zz\PyroBundle\Entity\Extract'
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'zz_pyrobundle_extract';
	}
}
