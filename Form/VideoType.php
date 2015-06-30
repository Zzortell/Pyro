<?php

namespace Zz\PyroBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Zz\PyroBundle\Entity\YoutubeRequestor;
use Symfony\Component\Form\FormError;

class VideoType extends AbstractType
{
    protected $ytRequestor;
    
    public function __construct ( YoutubeRequestor $ytRequestor )
    {
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
        
        if ( $video->getId() ) {
            if ( !$this->ytRequestor->hydrateVideo($video) ) {
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
            'data_class' => 'Zz\PyroBundle\Entity\Video'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'zz_pyrobundle_video';
    }
}
