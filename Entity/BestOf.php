<?php

namespace Zz\PyroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContextInterface;
use Gedmo\Mapping\Annotation as Gedmo;

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
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\Type("string", message="BestOf's title should be a {{ type }}.")
     * @Assert\Length(max=255, maxMessage="BestOf's title is too long. It should have {{ limit }} characters or less.")
     * @Assert\NotBlank(message="BestOf's title should not be blank.")
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="proposal_date", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $proposalDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="change", field="done", value=true)
     */
    private $endDate;

    /**
     * @var array
     *
     * @ORM\ManyToMany(targetEntity="Zz\PyroBundle\Entity\Channel", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Collection
     * @Assert\Valid
     * @Assert\Count(min=1, minMessage="The BestOf should be linked to at least {{ limit }} channel.")
     * @Assert\All({ @Assert\NotNull(message="Channels should not be null.") })
     */
    private $channels;

    /**
     * @ORM\ManyToMany(targetEntity="Zz\PyroBundle\Entity\Video", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     * @Assert\Collection
     * @Assert\Valid
     * @Assert\All({ @Assert\NotNull(message="Videos should not be null.") })
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
    private $done = false;

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
     * Set title
     *
     * @param string $title
     *
     * @return BestOf
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
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
