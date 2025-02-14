<?php

namespace App\Controller;

use App\Descriptor\OrderStatusDescriptor;
use App\Descriptor\PickingStatusDescriptor;
use App\Entity\Issue;
use App\Entity\Order;
use App\Entity\Picking;
use App\Form\BoxType;
use App\Repository\OrderRepository;
use App\Repository\PickingRepository;
use App\Service\LoggerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/picking')]
class PickingController extends AbstractController
{
    #[Route('/', name: 'picking_index')]
    public function index(OrderRepository $repository,
                          PickingRepository $pickingRepository,
                          Security $security): Response {

        return $this->render('picking/index.html.twig', [
            'orders' => $repository->findBy([
                'status' => [
                    OrderStatusDescriptor::ORDER_RECEIVED,
                    OrderStatusDescriptor::ORDER_PROCESSING
                ]
            ]),
            'myPickings' => $pickingRepository->findBy([
                'owner' => $security->getUser(),
                'status' => PickingStatusDescriptor::OPEN
            ])
        ]);
    }

    #[Route('/start-picking/{id}', name: 'start_picking')]
    public function startPicking(Order $order,
                                 Security $security,
                                 EntityManagerInterface $entityManager,
                                 LoggerService $logger,
                                 Request $request): Response {

        if($order->getPicking() != null && $order->getPicking()->getStatus() == PickingStatusDescriptor::COMPLETED) {
            $request->getSession()
                ->getFlashBag()
                ->add('error', 'This order already have a picking action');
        } else {
            $order->setStatus(OrderStatusDescriptor::ORDER_PROCESSING);
            $picking = new Picking($order, $security->getUser());

            $entityManager->persist($picking);
            $entityManager->flush();

            $logger->logStartPicking($order);

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Picking opened successfully');
        }

        return $this->redirectToRoute('view_order', ['id' => $order->getId()]);
    }

    #[Route('/complete-picking/{id}', name: 'complete_picking', methods: ['GET', 'POST'])]
    public function completePicking(Order $order,
                                    EntityManagerInterface $entityManager,
                                    LoggerService $logger,
                                    Request $request): Response {

        if($order->getPicking() == null || $order->getPicking()->getStatus() == PickingStatusDescriptor::COMPLETED) {
            $request->getSession()
                ->getFlashBag()
                ->add('error', 'You need to open the order for picking first');

            return $this->redirectToRoute('view_order', ['id' => $order->getId()]);
        } else {
            $form = $this->createForm(BoxType::class, $order);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                $order->setStatus(OrderStatusDescriptor::ORDER_READY_TO_SHIP);
                $order->getPicking()->setStatus(PickingStatusDescriptor::COMPLETED);

                $entityManager->flush();

                $logger->logCompletePicking($order);

                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Picking completed successfully, order now is Ready to Ship');

                return $this->redirectToRoute('view_order', ['id' => $order->getId()]);
            }
        }

        return $this->render('picking/picking-box.html.twig', [
            'form' => $form->createView(),
            'order' => $order
        ]);
    }

    #[Route('/fix-issue/{id}/{issue}', name: 'fix_order_issue', methods: ['GET', 'POST'])]
    public function fixIssue(Order $order,
                             Issue $issue,
                             EntityManagerInterface $entityManager,
                             LoggerService $logger,
                             Request $request): Response {

        if(!$order->getHasIssue()) {
            $request->getSession()
                ->getFlashBag()
                ->add('error', 'Order does not have an issue to fix!');

            return $this->redirectToRoute('view_order', ['id' => $order->getId()]);
        } else {
            $form = $this->createForm(BoxType::class, $order);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                $issue->setIsFixed(true);
                $order->setStatus(OrderStatusDescriptor::ORDER_READY_TO_SHIP);
                $order->setHasIssue(false);

                $entityManager->flush();

                $logger->logCompletePicking($order);

                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Issue was fixed, order now is Ready to Ship');

                return $this->redirectToRoute('view_order', ['id' => $order->getId()]);
            }
        }

        return $this->render('picking/picking-box.html.twig', [
            'form' => $form->createView(),
            'order' => $order
        ]);
    }
}
