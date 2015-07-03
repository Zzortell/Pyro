<?php

namespace Zz\PyroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Profile
 *
 * @ORM\Table("zz_pyro_profile")
 * @ORM\Entity
 */
class Profile
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
     * @ORM\OneToOne(targetEntity="Zz\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $user;


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
     * Set user
     *
     * @param \Zz\UserBundle\Entity\User $user
     *
     * @return Profile
     */
    public function setUser(\Zz\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Zz\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
