<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;
use Avanzu\AdminThemeBundle\Model\UserInterface as ThemeUser;

/**
 * User
 *
 * @ORM\Table(name="ddx_user")
 * @ORM\Entity
 */
class User extends BaseUser implements ThemeUser {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


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
     * __ctor()
     */
    public function __construct(){

        parent::__construct();
    }


    /**
     * @return string
     */
    public function getAvatar(){
        // TODO: Implement getAvatar() method.
        return '';
    }

    /**
     * @return string
     */
    public function getName(){
        // TODO: Implement getName() method.
        return $this->username;
    }

    /**
     * @return \DateTime
     */
    public function getMemberSince(){
        // TODO: Implement getMemberSince() method.
        return new \DateTime();
    }

    /**
     * @return bool
     */
    public function isOnline()
    {
        // TODO: Implement isOnline() method.
        return true;
    }

    /**
     * @return int
     */
    public function getIdentifier(){
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(){
        return 'Member';
    }
}

