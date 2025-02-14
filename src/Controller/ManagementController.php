<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/management')]
class ManagementController extends AbstractController
{
    #[Route('/', name: 'management_index')]
    public function index(OrderRepository $repository): Response
    {
        return $this->render('management/index.html.twig', [
            'orders' => $repository->findAll()
        ]);
    }

    #[Route('/search-order', name: 'management_search_order')]
    public function searchOrder(OrderRepository $repository, Request $request): Response
    {
        $order = $repository->find($request->get('order'));

        if (!$order) {
            throw new NotFoundHttpException('No order found with the provided ID');
        }

        return $this->redirectToRoute('view_order', ['id' => $order->getId()]);
    }

    #[Route('/view-logs/{id}', name: 'management_view_logs')]
    public function viewOrderLog(Order $order): Response
    {
        return $this->render('management/logs.html.twig', ['order' => $order]);
    }

    #[Route('/view-issues/{id}', name: 'management_view_issues')]
    public function viewOrderIssues(Order $order): Response
    {
        return $this->render('management/issues.html.twig', ['order' => $order]);
    }
}
