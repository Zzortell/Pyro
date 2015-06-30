<?php

namespace Zz\PyroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Extract
 *
 * @ORM\Table("zz_pyro_extract")
 * @ORM\Entity
 */
class Extract
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="start_seconds", type="integer")
     * @Assert\Type("integer")
     * @Assert\GreaterThanOrEqual(0)
     * @Assert\NotNull
     */
    protected $startSeconds;

    /**
     * @var integer
     *
     * @ORM\Column(name="end_seconds", type="integer")
     * @Assert\Type("integer")
     * @Assert\NotNull
     */
    protected $endSeconds;
    
    /**
     * @ORM\ManyToOne(targetEntity="Zz\PyroBundle\Entity\Profile")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $author;
    
    /**
     * @ORM\ManyToOne(targetEntity="Zz\PyroBundle\Entity\Video", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid
     */
    protected $video;
    
    /**
     * @Assert\Callback
     */
    public function validateRange ( ExecutionContextInterface $context )
    {
        //Validate startSeconds: [0; duration[
        if ( $this->getStartSeconds() >= $this->getVideo()->getDuration() ) {
            $context->addViolationAt(
                'startSeconds',
                'The extract must start before the end of the video (starts at %start%).',
                [ '%start%' => $this->getStartSeconds() ],
                $this->getStartSeconds()
            );
        }
        
        //Validate endSeconds: ]start; duration]
        if ( $this->getEndSeconds() <= $this->getStartSeconds() ) {
            $context->addViolationAt(
                'endSeconds',
                'The extract must end after starting (ends at %end%).',
                [ '%end%' => $this->getEndSeconds() ],
                $this->getEndSeconds()
            );
        }
        if ( $this->getEndSeconds() > $this->getVideo()->getDuration() ) {
            $context->addViolationAt(
                'endSeconds',
                'The extract must end before or at the same time as the video (ends at %end%).',
                [ '%end%' => $this->getEndSeconds() ],
                $this->getEndSeconds()
            );
        }
    }
    


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set startSeconds
     *
     * @param integer $startSeconds
     *
     * @return Extract
     */
    public function setStartSeconds($startSeconds)
    {
        $this->startSeconds = $startSeconds;

        return $this;
    }

    /**
     * Get startSeconds
     *
     * @return integer
     */
    public function getStartSeconds()
    {
        return $this->startSeconds;
    }

    /**
     * Set endSeconds
     *
     * @param integer $endSeconds
     *
     * @return Extract
     */
    public function setEndSeconds($endSeconds)
    {
        $this->endSeconds = $endSeconds;

        return $this;
    }

    /**
     * Get endSeconds
     *
     * @return integer
     */
    public function getEndSeconds()
    {
        return $this->endSeconds;
    }

    /**
     * Set author
     *
     * @param \Zz\PyroBundle\Entity\Profile $author
     *
     * @return Extract
     */
    public function setAuthor(\Zz\PyroBundle\Entity\Profile $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \Zz\PyroBundle\Entity\Profile
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set video
     *
     * @param \Zz\PyroBundle\Entity\Video $video
     *
     * @return Extract
     */
    public function setVideo(\Zz\PyroBundle\Entity\Video $video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return \Zz\PyroBundle\Entity\Video
     */
    public function getVideo()
    {
        return $this->video;
    }
}
