<?php

namespace App\Controller;

use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/orders')]
class OrderController extends AbstractController
{
    #[Route('/view/{id}', name: 'view_order')]
    public function index(Order $order): Response
    {
        return $this->render('order-details.html.twig', [
            'order' => $order
        ]);
    }

    #[Route('/view_issues/{id}', name: 'view_issues')]
    public function viewIssues(Order $order): Response
    {
        return $this->render('issues.html.twig', ['order' => $order]);
    }
}
