<?php

namespace Zz\PyroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContextInterface;

/**
 * BestOf
 *
 * @ORM\Table("zz_pyro_bestof")
 * @ORM\Entity
 */
class BestOf
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="proposal_date", type="datetime")
     */
    private $proposalDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="datetime")
     */
    private $endDate;

    /**
     * @var array
     *
     * @ORM\ManyToMany(targetEntity="Zz\PyroBundle\Entity\Channel")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid
     * @Assert\NotNull
     */
    private $channels;

    /**
     * @ORM\ManyToMany(targetEntity="Zz\PyroBundle\Entity\Video")
     * @ORM\JoinColumn(nullable=true)
     * @Assert\Valid
     */
    private $videos;

    /**
     * @ORM\ManyToOne(targetEntity="Zz\PyroBundle\Entity\Profile")
     * @ORM\JoinColumn(nullable=false)
     */
    private $manager;

    /**
     * @var boolean
     *
     * @ORM\Column(name="done", type="boolean")
     * @Assert\Type("boolean")
     * @Assert\NotNull
     */
    private $done;

    /**
     * @ORM\ManyToOne(targetEntity="Zz\PyroBundle\Entity\Video")
     * @ORM\JoinColumn(nullable=true)
     * @Assert\Valid
     * TODO: with done
     */
    private $video;
    
    /**
     * @Assert\Callback
     */
    public function validateVideo ( ExecutionContextInterface $context )
    {
        if ( $this->done && !$this->video ) {
            $context->addViolationAt(
                'done',
                'A done BestOf must be linked to a video.'
            );
        }
    }

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->videos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->channels = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return BestOf
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set proposalDate
     *
     * @param \DateTime $proposalDate
     *
     * @return BestOf
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
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return BestOf
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Add channel
     *
     * @param \Zz\PyroBundle\Entity\Channel $channel
     *
     * @return BestOf
     */
    public function addChannel(\Zz\PyroBundle\Entity\Channel $channel)
    {
        $this->channels[] = $channel;

        return $this;
    }

    /**
     * Remove channel
     *
     * @param \Zz\PyroBundle\Entity\Channel $channel
     */
    public function removeChannel(\Zz\PyroBundle\Entity\Channel $channel)
    {
        $this->channels->removeElement($channel);
    }

    /**
     * Get channels
     *
     * @return array
     */
    public function getChannels()
    {
        return $this->channels;
    }

    /**
     * Set done
     *
     * @param boolean $done
     *
     * @return BestOf
     */
    public function setDone($done)
    {
        $this->done = $done;

        return $this;
    }

    /**
     * Is done
     *
     * @return boolean
     */
    public function isDone()
    {
        return $this->done;
    }

    /**
     * Add video
     *
     * @param \Zz\PyroBundle\Entity\Video $video
     *
     * @return BestOf
     */
    public function addVideo(\Zz\PyroBundle\Entity\Video $video)
    {
        $this->videos[] = $video;

        return $this;
    }

    /**
     * Remove video
     *
     * @param \Zz\PyroBundle\Entity\Video $video
     */
    public function removeVideo(\Zz\PyroBundle\Entity\Video $video)
    {
        $this->videos->removeElement($video);
    }

    /**
     * Get videos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * Set manager
     *
     * @param \Zz\PyroBundle\Entity\Profile $manager
     *
     * @return BestOf
     */
    public function setManager(\Zz\PyroBundle\Entity\Profile $manager)
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * Get manager
     *
     * @return \Zz\PyroBundle\Entity\Profile
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * Set video
     *
     * @param \Zz\PyroBundle\Entity\Video $video
     *
     * @return BestOf
     */
    public function setVideo(\Zz\PyroBundle\Entity\Video $video = null)
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
