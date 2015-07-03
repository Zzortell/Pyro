<?php

namespace Zz\PyroBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;
use Zz\PyroBundle\Entity\YoutubeRequestor;
use Zz\PyroBundle\Entity\VideoRepository;

class VideoType extends AbstractType
{
    protected $repo;
    protected $ytRequestor;
    
    public function __construct (
        VideoRepository $repo, YoutubeRequestor $ytRequestor
    ) {
        $this->repo = $repo;
        $this->ytRequestor = $ytRequestor;
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'text')
            ->addEventListener( FormEvents::SUBMIT, [ $this, 'onSubmit' ] )
        ;
    }
    
    public function onSubmit ( FormEvent $e )
    {
        $video = $e->getData();
        $form = $e->getForm();
        
        if ( $video && $video->getId() ) {
            //Check the video is not already in the database
            if ( $this->repo->isStored($video) ) {
                // Force the video to be new depending on the config
                if ( $form->getConfig()->getOption('force_new') ) {
                    $form->addError(new FormError (
                        'The video ' . $video->getId() . ' already exists.'
                    ));
                } else {
                    $e->setData($this->repo->findOneById($video->getId()));
                }
            }
            // Else check if the video exists and hydrate it
            elseif ( !$this->ytRequestor->hydrateVideo($video) ) {
                $form->addError(new FormError (
                    'The video ' . $video->getId() . ' doesn\'t exist.'
                ));
            }
        }
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zz\PyroBundle\Entity\Video',
            'force_new' => false
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'video';
    }
}
