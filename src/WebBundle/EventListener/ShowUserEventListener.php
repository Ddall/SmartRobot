<?php
/**
 * Created by PhpStorm.
 * User: Allan
 * Date: 03/11/2015
 * Time: 01:21
 */

namespace WebBundle\EventListener;

use Avanzu\AdminThemeBundle\Event\ShowUserEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class ShowUserEventListener{

    /**
     * @var TokenStorageInterface
     */
    private $token_storage;

    public function __construct(TokenStorageInterface $token_storage){
        $this->token_storage = $token_storage;
    }


    /**
     * @param ShowUserEvent $event
     */
    public function onShowUser(ShowUserEvent $event){
        $user = $this->token_storage->getToken()->getUser();
        $event->setUser($user);
    }


}
