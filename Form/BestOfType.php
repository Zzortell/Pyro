<?php

namespace Zz\PyroBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Zz\PyroBundle\Entity\ChannelRepository;

class BestOfType extends AbstractType
{
    protected $channelRepo;
    
    public function __construct ( ChannelRepository $channelRepo )
    {
        $this->channelRepo = $channelRepo;
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
                'type'          => 'channel',
                'allow_add'     => true,
                'allow_delete'  => true,
                'options'       => [ 'required'  => false ],
                'required'      => false
            ])
            ->add('videos',     'entity', [
                'class'     => 'ZzPyroBundle:Video',
                'property'  => 'title',
                'multiple'  => true,
                'required'  => false
            ])
            ->add('externalVideos', 'collection', [
                'type'          => 'video',
                'allow_add'     => true,
                'allow_delete'  => true,
                'mapped'        => false,
                'options'       => [ 'required'  => false ]
            ])
            ->add('save',       'submit', [ 'label' => 'form.save' ])
            ->addEventListener( FormEvents::PRE_SUBMIT, [ $this, 'onPreSubmit' ] )
            ->addEventListener( FormEvents::SUBMIT, [ $this, 'onSubmit' ] )
        ;
    }
    
    public function onPreSubmit ( FormEvent $e )
    {
        $data = $e->getData();
        $form = $e->getForm();
        
        if ( array_key_exists('channels', $data) ) {
            foreach ( $data['channels'] as $key => $channelData ) {
                if ( !$channelData['idOrUser'] ) {
                    unset($data['channels'][$key]);
                }
            }
            $e->setData($data);
        }
    }
    
    public function onSubmit ( FormEvent $e )
    {
        $bestof = $e->getData();
        $form = $e->getForm();
        
        $externalVideos = $form->get('externalVideos')->getData();
        foreach ( $externalVideos as $video ) {
            if ( $video ) {
                if ( !$bestof->getVideos()->contains($video) ) {
                    $bestof->addVideo($video);
                }
            }
        }
        
        $bestof->addChannel($this->channelRepo->findOneById('UC-FEf0oTFfmJQBIDJZmJgYA'));
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
