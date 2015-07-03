<?php

namespace Zz\PyroBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;
use Zz\PyroBundle\Entity\YoutubeRequestor;
use Zz\PyroBundle\Entity\ChannelRepository;

class ChannelType extends AbstractType
{
    protected $repo;
    protected $ytRequestor;
    
    public function __construct (
        ChannelRepository $repo, YoutubeRequestor $ytRequestor
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
            ->add('idOrUser', 'text', [ 'mapped' => false ])
            ->addEventListener( FormEvents::SUBMIT, [ $this, 'onSubmit' ] )
        ;
    }
    
    public function onSubmit ( FormEvent $e )
    {
        $channel = $e->getData();
        $form = $e->getForm();
        
        $idOrUser = $form->get('idOrUser')->getData();
        
        if ( !($channel && $idOrUser) ) {
            return;
        }
        
        if ( strpos($idOrUser, 'user:') === 0 ) {
            $username = substr($idOrUser, 5);
            $e->setData($channel = $this->ytRequestor->resolveChannel($username));
            
            if ( !$channel ) {
                $form->addError(new FormError (
                    'The channel from the user ' . $username . ' doesn\'t exist.'
                ));
            }
        } else {
            $channel->setId($idOrUser);
        }
        
        if ( $this->repo->isStored($channel) ) {
            $e->setData($this->repo->findOneById($channel->getId()));
            
        } elseif ( !$this->ytRequestor->hydrateChannel($channel) ) {
            $form->addError(new FormError (
                'The channel ' . $channel->getId() . ' doesn\'t exist.'
            ));
        }
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zz\PyroBundle\Entity\Channel'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'channel';
    }
}
