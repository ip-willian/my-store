<?php

namespace App\Controller;

use App\Descriptor\OrderStatusDescriptor;
use App\Entity\Issue;
use App\Entity\Order;
use App\Entity\OrderShipping;
use App\Form\IssueType;
use App\Form\ShippingType;
use App\Repository\OrderRepository;
use App\Service\LoggerService;
use App\Service\UploaderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/shipping')]
class ShippingController extends AbstractController
{
    #[Route('/', name: 'shipping_index')]
    public function index(OrderRepository $repository): Response
    {
        return $this->render('shipping/index.html.twig', [
            'orders' => $repository->findBy(['status' => OrderStatusDescriptor::ORDER_READY_TO_SHIP])
        ]);
    }

    #[Route('/ship-order/{id}', name: 'ship_order', methods: ['GET', 'POST'])]
    public function shipOrder(Order $order,
                              EntityManagerInterface $entityManager,
                              LoggerService $logger,
                              UploaderService $uploaderService,
                              Request $request): Response {

        $shipping = new OrderShipping($order);
        $form = $this->createForm(ShippingType::class, $shipping);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $order->setStatus(OrderStatusDescriptor::ORDER_SHIPPED);

            $label = $request->files->get('shipping')['shippingLabelFile'];
            $shipping->setShippingLabel($uploaderService->handleUpload($label));

            $entityManager->persist($shipping);
            $entityManager->flush();

            $logger->logShipping($shipping, $order);

            $request->getSession()->getFlashBag()->add('success', 'Order has been shipped!');

            return $this->redirectToRoute('view_order', ['id' => $order->getId()]);
        }

        return $this->render('shipping/ship-order.html.twig', [
            'form' => $form->createView(),
            'order' => $order
        ]);
    }

    #[Route('/report-an-issue/{id}', name: 'report_issue_order', methods: ['GET', 'POST'])]
    public function reportIssue(Order $order,
                                EntityManagerInterface $entityManager,
                                LoggerService $logger,
                                Request $request): Response {

        if ($order->getStatus() !== OrderStatusDescriptor::ORDER_READY_TO_SHIP) {
            $request->getSession()->getFlashBag()->add('error', 'Order is not in a valid status for this action!');

            return $this->redirectToRoute('view_order', ['id' => $order->getId()]);
        }

        $issue = new Issue($order);
        $form = $this->createForm(IssueType::class, $issue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $order->setStatus(OrderStatusDescriptor::ORDER_PROCESSING);
            $order->setHasIssue(true);

            $entityManager->persist($issue);
            $entityManager->flush();

            $logger->logNewIssue($issue, $order);

            $request->getSession()->getFlashBag()->add('success', 'Order has returned to picking department!');

            return $this->redirectToRoute('view_order', ['id' => $order->getId()]);
        }

        return $this->render('shipping/issue.html.twig', [
            'form' => $form->createView(),
            'order' => $order
        ]);
    }
}
