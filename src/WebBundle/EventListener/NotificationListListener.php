<?php
/**
 * Created by PhpStorm.
 * User: Allan
 * Date: 03/11/2015
 * Time: 05:30
 */

namespace WebBundle\EventListener;


use Avanzu\AdminThemeBundle\Event\NotificationListEvent;
use Doctrine\ORM\EntityManagerInterface;

class NotificationListListener{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    /**
     * @param NotificationListEvent $event
     */
    public function onListNotifications(NotificationListEvent $event) {
        foreach($this->getNotifications() as $Notification) {
            $event->addNotification($Notification);
        }

    }

    /**
     * @return array
     */
    protected function getNotifications() {
        $notifications = $this->entityManager->getRepository('WebBundle:Notification')->findAll();
        return $notifications;
    }

}
