<?php

namespace Zz\PyroBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BestOfType extends AbstractType
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
            ->add('name',       'text')
            ->add('channels',   'collection', [
                'type'      => new ChannelType,
                'allow_add' => true
            ])
            ->add('videos',     'entity', [
                'class'     => 'ZzPyroBundle:Video',
                'property'  => 'title',
                'multiple'  => true,
                'required'  => false
            ])
            ->add('externalVideos', 'collection', [
                'type'      => $this->typeFactory->createVideoType(),
                'options'   => [ 'mapped' => false, 'required' => false ],
                'mapped'    => false
            ])
            ->add('save',       'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zz\PyroBundle\Entity\BestOf'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'zz_pyrobundle_bestof';
    }
}
