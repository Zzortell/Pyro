<?php

namespace Zz\PyroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Channel
 *
 * @ORM\Table("zz_pyro_channel")
 * @ORM\Entity
 */
class Channel
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string")
     * @ORM\Id
     * @Assert\Type("string")
     * @Assert\NotBlank
     */
    private $id;


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
}
