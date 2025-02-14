<?php

namespace App\Service;

use App\Descriptor\OrderStatusDescriptor;
use App\Entity\Issue;
use App\Entity\Logger;
use App\Entity\Order;
use App\Entity\OrderShipping;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class LoggerService {

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $em;

    /**
     * @var App/Entity/User
     */
    private $user;

    public function __construct(EntityManagerInterface $em, Security $security) {
        $this->em = $em;
        $this->user = $security->getUser();
    }

    public function logNewOrder($order) {
        $message = 'Order #'.$order->getId(). ' has been received by the system';
        $this->createLogger($order, OrderStatusDescriptor::ORDER_RECEIVED, $message);
    }

    public function logStartPicking($order) {
        $message = 'Order #'.$order->getId(). ' has been changed to PROCESSING by ' . $this->user->getEmail();
        $this->createLogger($order, OrderStatusDescriptor::ORDER_PROCESSING, $message);
    }

    public function logCompletePicking($order) {
        $message = 'Order #'.$order->getId(). ' has been changed to READY TO SHIP by ' . $this->user->getEmail();
        $this->createLogger($order, OrderStatusDescriptor::ORDER_READY_TO_SHIP, $message);
    }

    public function logShipping(OrderShipping $shipping, $order) {

        $message = 'Order #'
            . $order->getId()
            . ' has been changed to SHIPPED by '
            . $this->user->getEmail()
            . ' with AWB: '
            . $shipping->getTrackingNumber()
            . ' by ' . $shipping->getCompany();

        $this->createLogger($order, OrderStatusDescriptor::ORDER_SHIPPED, $message);
    }

    public function logNewIssue(Issue $issue, $order) {

        $message = 'Order #'
            . $order->getId()
            . ' has been changed to PROCESSING by '
            . $this->user->getEmail()
            . ' with reason: '
            . $issue->getCauseDescription()
            . '( ' . $issue->getMessage() .' )';

        $this->createLogger($order, OrderStatusDescriptor::ORDER_PROCESSING, $message);
    }

    private function createLogger(Order $order, $status, $message) {
        $logger = new Logger($order);
        $logger->setOrderStatus($status);
        $logger->setMessage($message);
        $this->em->persist($logger);
        $this->em->flush();
    }

}