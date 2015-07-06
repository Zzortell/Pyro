<?php

namespace Zz\PyroBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;
use Zz\PyroBundle\Entity\VideoRepository;

class ExtractBestOfType extends AbstractType
{
    protected $repo;
    
    public function __construct ( VideoRepository $repo ) {
        $this->repo = $repo;
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('bestof')
            ->remove('video')
            ->remove('externalVideo')
            ->add('video', 'hidden', [
                'data' => '__id__',
                'mapped' => false
            ])
            ->addEventListener( FormEvents::SUBMIT, [ $this, 'onSubmit' ] )
        ;
    }
    
    public function onSubmit ( FormEvent $e )
    {
        $extract = $e->getData();
        $form = $e->getForm();
        
        $videoId = $form->get('video')->getData();
        
        $video = $this->repo->findOneById($videoId);
        
        if ( $video ) {
            $extract->setVideo($video);
        } else {
            $form->addError(new FormError (
                'The extract has to be linked to a stored video. Please specify a video.'
            ));
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bestof_extract';
    }
    
    public function getParent ()
    {
        return 'extract';
    }
}
