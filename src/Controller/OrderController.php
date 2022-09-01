<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\User;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/orders')]
class OrderController extends AbstractController
{
    #[Route('/create/{email}', name: 'createOrder', methods: ['POST'])]
    public function create(User $user = null, Request $request, OrderRepository $orderRepository) : JsonResponse
    {
        if(!$user)
        {
            return $this->json(['message'=>'User not found'], 404);
        }

        $order = new Order();
        $order->setUserid($user->getId());
        $form = $this->createForm(OrderType::class, $order);
        $form->submit($request->toArray());

        if($form->isValid() && $form->isSubmitted())
        {
            $orderRepository->add($order, true);
            return $this->json($order);
        }

        return $this->json($form->getErrors(), 400);
    }

    #[Route('/read', name: 'listOrders', methods: ['GET'])]
    public function read(OrderRepository $orderRepository) : JsonResponse
    {
        return $this->json($orderRepository->findAll());
    }

    #[Route('/read/{email}', name: 'listOrdersByEmail', methods: ['GET'])]
    public function readById(User $user = null, OrderRepository $orderRepository) : JsonResponse
    {
        if(!$user)
        {
            return $this->json(['message'=> 'User not found'], 404);
        }

        return $this->json([
            'email'=>$user->getEmail(),
            'orders'=>$orderRepository->findBy(['userid'=>$user->getId()])
        ]);
    }

    #[Route('/update/{id}', name: 'updateOrder', methods: ['PUT'])]
    public function update(Order $order = null, Request $request, OrderRepository $orderRepository) : JsonResponse
    {
        if(!$order)
        {
            return $this->json(['message'=>'Order not found'], 404);
        }

        $form = $this->createForm(OrderType::class, $order);
        $form->submit($request->toArray());

        if($form->isSubmitted() && $form->isValid())
        {
            $orderRepository->add($order, true);
            return $this->json($order, 201);
        }

        return $this->json($form->getErrors(), 400);
    }

    #[Route('/delete/{id}', name: 'deleteOrder', methods: ['DELETE'])]
    public function delete(Order $order = null , OrderRepository $orderRepository)
    {
        if(!$order)
        {
            return $this->json(['message'=>'Order not found'], 404);
        }

        $orderRepository->remove($order, true);

        return $this->json(['message'=>'Order deleted'], 204);
    }
}
