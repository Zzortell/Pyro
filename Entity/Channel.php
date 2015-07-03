<?php

namespace Zz\PyroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Channel
 *
 * @ORM\Table("zz_pyro_channel")
 * @ORM\Entity(repositoryClass="ChannelRepository")
 */
class Channel
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string")
     * @ORM\Id
     * @Assert\Type("string", message="Channel's id should be a {{ type }}.")
     * @Assert\NotBlank(message="Channel's id should not be blank.")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string")
     * @Assert\Type("string")
     * @Assert\NotNull
     */
    protected $title;
    
    /**
     * @ORM\Column(type="string")
     * @Assert\Url
     * @Assert\NotNull
     */
    protected $thumbnail;
    
    /**
     * @ORM\Column(type="string")
     * @Assert\Url
     * @Assert\NotNull
     */
    protected $banner;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function setId( $id )
    {
        $this->id = $id;
        
        return $this;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Channel
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
     * Set thumbnail
     *
     * @param string $thumbnail
     *
     * @return Channel
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * Get thumbnail
     *
     * @return string
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * Set banner
     *
     * @param string $banner
     *
     * @return Channel
     */
    public function setBanner($banner)
    {
        $this->banner = $banner;

        return $this;
    }

    /**
     * Get banner
     *
     * @return string
     */
    public function getBanner()
    {
        return $this->banner;
    }
}
