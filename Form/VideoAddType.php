<?php

namespace Zz\PyroBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Zz\PyroBundle\Entity\YoutubeRequestor;
use Doctrine\ORM\EntityManager;

class VideoAddType extends AbstractType
{
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
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'force_new' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'video_add';
    }
    
    public function getParent ()
    {
        return 'video';
    }
}
