<?php

namespace App\Controller\Api;

use App\Descriptor\OrderStatusDescriptor;
use App\Entity\Order;
use App\Form\OrderType;
use App\Service\LoggerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/order')]
class OrderApiController extends AbstractApiController
{
    #[Route('/place', name: 'place_order_api', methods: ['POST'])]
    public function placeOrder(Request $request,
                               LoggerService $logger,
                               EntityManagerInterface $entityManager): Response {

        $form = $this->buildForm(OrderType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }

        $order = $form->getData();
        $entityManager->persist($order);
        $entityManager->flush();

        $logger->logNewOrder($order);

        return $this->respond($order, Response::HTTP_CREATED);
    }

    #[Route('/cancel/{id}', name: 'cancel_order_api', methods: ['PATCH'])]
    public function cancelOrder(EntityManagerInterface $entityManager,
                                Order $order = null): Response {

        if ($order === null) {
            return $this->respond(null, Response::HTTP_NOT_FOUND);
        }

        $order->setStatus(OrderStatusDescriptor::ORDER_CANCELED);
        $entityManager->flush();

        return $this->respond($order, Response::HTTP_OK);
    }
}
