<?php

namespace Zz\PyroBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Zz\PyroBundle\Entity\VideoYtFactory;

class VideoType extends AbstractType
{
    protected $factory;
    
    public function __construct ( VideoYtFactory $factory )
    {
        $this->factory = $factory;
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id',     'text')
            ->add('save',   'submit')
            ->addEventListener( FormEvents::SUBMIT, [ $this, 'onSubmit' ] )
        ;
    }
    
    public function onSubmit ( FormEvent $e )
    {
        $video = $e->getData();
        
        if ( $video->getId() ) {
            $this->factory->hydrateVideo($video);
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
