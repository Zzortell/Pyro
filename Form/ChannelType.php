<?php

namespace Zz\PyroBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Zz\PyroBundle\Entity\YoutubeRequestor;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManager;

class ChannelType extends AbstractType
{
    protected $em;
    protected $ytRequestor;
    
    public function __construct (
        EntityManager $em, YoutubeRequestor $ytRequestor
    ) {
        $this->em = $em;
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
        
        $repo = $this->em->getRepository('ZzPyroBundle:Channel');
        
        if ( strpos($idOrUser, 'user:') === 0 ) {
            $channel->setUsername(substr($idOrUser, 5));
            
            if ( !$this->ytRequestor->hydrateChannel($channel) ) {
                $form->addError(new FormError (
                    'The channel from the user ' . $channel->getUsername() . ' doesn\'t exist.'
                ));
            }
        } else {
            $channel->setId($idOrUser);
        }
        if ( $repo->isStored($channel) ) {
            $e->setData($repo->findOneById($channel->getId()));
            
        } elseif ( !$channel->getUsername() && !$this->ytRequestor->hydrateChannel($channel) ) {
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
        return 'zz_pyrobundle_channel';
    }
}
