<?php

namespace Zz\PyroBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BestOfType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',       'text')
            ->add('channels',   'collection', [
                'type'          => 'channel',
                'allow_add'     => true,
                'allow_delete'  => true
            ])
            ->add('videos',     'entity', [
                'class'     => 'ZzPyroBundle:Video',
                'property'  => 'title',
                'multiple'  => true,
                'required'  => false
            ])
            ->add('externalVideos', 'collection', [
                'type'      => 'video',
                'allow_add'     => true,
                'allow_delete'  => true,
                'mapped'    => false
            ])
            ->add('save',       'submit', [ 'label' => 'form.save' ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zz\PyroBundle\Entity\BestOf',
            'translation_domain' => 'ZzPyroBundle_form'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bestof';
    }
}
