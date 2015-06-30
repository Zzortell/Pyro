<?php

namespace Zz\PyroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    protected $startSeconds;

    /**
     * @var integer
     *
     * @ORM\Column(name="end_seconds", type="integer")
     */
    protected $endSeconds;
    
    /**
     * @ORM\ManyToOne(targetEntity="Zz\PyroBundle\Entity\Profile")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $author;
    
    /**
     * @ORM\ManyToOne(targetEntity="Zz\PyroBundle\Entity\Video")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $video;
    


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
