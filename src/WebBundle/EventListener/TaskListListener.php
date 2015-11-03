<?php
/**
 * Created by PhpStorm.
 * User: Allan
 * Date: 03/11/2015
 * Time: 04:02
 */

namespace WebBundle\EventListener;

use Avanzu\AdminThemeBundle\Event\TaskListEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class TaskListListener{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage){
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param TaskListEvent $event
     */
    public function onListTasks(TaskListEvent $event){
        foreach($this->getTasks() as $task){
            $event->addTask($task);
        }
    }

    /**
     * @return array
     */
    protected function getTasks(){
        $user = $this->tokenStorage->getToken()->getUser();

        if($this->tokenStorage->getToken()->isAuthenticated() === false){
            throw new AccessDeniedHttpException();
        }

        $tasks = $this->entityManager->getRepository('WebBundle:Task')->findBy(array(
            'user' => $user->getId(),
        ));

        return $tasks;
    }

}