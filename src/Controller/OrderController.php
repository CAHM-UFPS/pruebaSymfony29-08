<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\User;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/orders')]
class OrderController extends AbstractController
{
    #[Route('/create/{email}', name: 'createOrder', methods: ['POST'])]
    public function create(User $user = null, Request $request, OrderRepository $orderRepository) : JsonResponse
    {
        if(!$user)
        {
            return $this->json(null, Response::HTTP_NOT_FOUND);
        }

        $order = new Order();
        $order->setUserid($user->getId());
        $form = $this->createForm(OrderType::class, $order);
        $form->submit($request->toArray());

        if($form->isValid() && $form->isSubmitted())
        {
            $orderRepository->add($order, true);
            return $this->json($order, Response::HTTP_CREATED);
        }

        return $this->json($form->getErrors(), Response::HTTP_BAD_REQUEST);
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
            return $this->json(null, Response::HTTP_NOT_FOUND);
        }

        return $this->json(
            [
            'email'=>$user->getEmail(),
            'orders'=>$orderRepository->findBy(['userid'=>$user->getId()])
            ],
            Response::HTTP_OK
        );
    }

    #[Route('/update/user/{email}/order/{id}', name: 'updateOrder', methods: ['PUT'])]
    #[Entity('Order', expr: 'repository.findByOne(id)')]
    public function update(User $user = null, Order $order = null, Request $request, OrderRepository $orderRepository) : JsonResponse
    {
        if(!$user || !$order)
        {
            return $this->json(null, Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(OrderType::class, $order);
        $form->submit($request->toArray());

        if($form->isSubmitted() && $form->isValid())
        {
            $orderRepository->add($order, true);
            return $this->json($order, Response::HTTP_ACCEPTED);
        }

        return $this->json($form->getErrors(), 400);
    }

    #[Route('/delete/user/{email}/order/{id}', name: 'deleteOrder', methods: ['DELETE'])]
    #[Entity('Order', expr: 'repository.findByOne(id)')]
    public function delete(User $user = null, Order $order = null, OrderRepository $orderRepository)
    {
        if(!$user || !$order)
        {
            return $this->json(null, Response::HTTP_NOT_FOUND);
        }

        $orderRepository->remove($order, true);

        return $this->json([], Response::HTTP_NO_CONTENT);
    }
}
