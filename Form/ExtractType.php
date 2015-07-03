<?php

namespace Zz\PyroBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;

class ExtractType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('bestof', 		'entity', [
				'class' 	=> 'ZzPyroBundle:BestOf',
				'property' 	=> 'name',
				'multiple' 	=> false
			])
			->add('video', 			'entity', [
				'class' 	=> 'ZzPyroBundle:Video',
				'property' 	=> 'title',
				'multiple' 	=> false,
				'required' 	=> false
			])
			->add('externalVideo', 	'video',
					[ 'mapped' => false, 'required' => false ])
			->add('startSeconds', 	'integer')
			->add('endSeconds', 	'integer')
			->add('save', 			'submit')
            ->addEventListener( FormEvents::SUBMIT, [ $this, 'onSubmit' ] )
		;
	}
    
    public function onSubmit ( FormEvent $e )
    {
        $data = $e->getData();
        $form = $e->getForm();
        
        $externalVideo = $form->get('externalVideo')->getData();
        
        if ( !($data->getVideo() || $externalVideo) ) {
        	$form->addError(new FormError (
                'The extract has to be linked to a video. Please specify a video.'
            ));
        }
        
        if ( $externalVideo ) {
        	$data->setVideo($externalVideo);
        }
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
		return 'extract';
	}
}
