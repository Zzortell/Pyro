<?php

namespace Zz\PyroBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Zz\PyroBundle\Entity\YoutubeRequestor;

class VideoAddType extends AbstractType
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
            ->add('save', 'submit')
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'zz_pyrobundle_video_add';
    }
    
    public function getParent ()
    {
        return new VideoType ($this->ytRequestor);
    }
}
