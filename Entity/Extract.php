<?php

namespace Zz\PyroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

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
     * @Assert\Type("integer", message="Extract's startSeconds should be a {{ type }}.")
     * @Assert\GreaterThanOrEqual(0, message="Extract's startSeconds should be positive.")
     * @Assert\NotNull(message="Extract's startSeconds should not be null.")
     */
    protected $startSeconds;

    /**
     * @var integer
     *
     * @ORM\Column(name="end_seconds", type="integer")
     * @Assert\Type("integer", message="Extract's endSeconds should be a {{ type }}.")
     * @Assert\NotNull(message="Extract's endSeconds should not be null.")
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
     * @ORM\ManyToOne(targetEntity="Zz\PyroBundle\Entity\BestOf")
     * @ORM\JoinColumn(nullable=true, name="bestof_id")
     * @Assert\Valid
     */
    protected $bestOf;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\Type("boolean", message="Extract's chosen should be a {{ type }}.")
     * @Assert\NotNull(message="Extract's chosen should not be null.")
     */
    protected $chosen = false;
    
    /**
     * @ORM\Column(name="proposal_date", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $proposalDate;
    
    /**
     * @Assert\Callback
     */
    public function validateRange ( ExecutionContextInterface $context )
    {
        if ( !$this->getVideo() || !$this->getVideo()->getDuration() ) {
            return;
        }
        
        $durationInterval = new \DateInterval ($this->getVideo()->getDuration());
        $durationSeconds = $durationInterval->days*86400 + $durationInterval->h*3600
                            + $durationInterval->i*60 + $durationInterval->s;
        
        //Validate startSeconds: [0; duration[
        if ( $this->getStartSeconds() >= $durationSeconds ) {
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
        if ( $this->getEndSeconds() > $durationSeconds ) {
            $context->addViolationAt(
                'endSeconds',
                'The extract must end before or at the same time as the video (ends at %end%).',
                [ '%end%' => $this->getEndSeconds() ],
                $this->getEndSeconds()
            );
        }
    }
    
    /**
     * @Assert\Callback
     */
    public function validateChosen ( ExecutionContextInterface $context )
    {
        if ( $this->isChosen() && !$this->getBestOf() ) {
            $context->addViolationAt(
                'chosen',
                'The extract must not be chosen if it\'s not linked to a BestOf.'
            );
        }
    }
    
    /**
     * @Assert\Callback
     */
    public function validateVideo ( ExecutionContextInterface $context )
    {
        if ( !$this->isChosen() ) {
            return;
        }
        
        if ( !in_array($this->getVideo(), $this->getBestOf()->getVideos(), true) ) {
            $context->addViolationAt(
                'video',
                'The extract must refer to a video linked to the BestOf.'
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
        $this->startSeconds = (int) $startSeconds;

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
        $this->endSeconds = (int) $endSeconds;

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

    /**
     * Set chosen
     *
     * @param boolean $chosen
     *
     * @return Extract
     */
    public function setChosen($chosen)
    {
        $this->chosen = $chosen;

        return $this;
    }

    /**
     * Get chosen
     *
     * @return boolean
     */
    public function isChosen()
    {
        return $this->chosen;
    }

    /**
     * Set proposalDate
     *
     * @param \DateTime $proposalDate
     *
     * @return Extract
     */
    public function setProposalDate($proposalDate)
    {
        $this->proposalDate = $proposalDate;

        return $this;
    }

    /**
     * Get proposalDate
     *
     * @return \DateTime
     */
    public function getProposalDate()
    {
        return $this->proposalDate;
    }

    /**
     * Set bestOf
     *
     * @param \Zz\PyroBundle\Entity\BestOf $bestOf
     *
     * @return Extract
     */
    public function setBestOf(\Zz\PyroBundle\Entity\BestOf $bestOf = null)
    {
        $this->bestOf = $bestOf;

        return $this;
    }

    /**
     * Get bestOf
     *
     * @return \Zz\PyroBundle\Entity\BestOf
     */
    public function getBestOf()
    {
        return $this->bestOf;
    }
}
