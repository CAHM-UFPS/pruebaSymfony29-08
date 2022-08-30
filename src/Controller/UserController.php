<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/create', name: 'createUser', methods: ['POST'])]
    public function create(Request $request, UserRepository $userRepository) : JsonResponse
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->submit($request->toArray());

        if($form->isValid() && $form->isSubmitted()){
            $userRepository->add($user, true);
            return $this->json($user);
        }

        return $this->json($form->getErrors(true), 400);
    }

    #[Route('/read', name: 'listUsers', methods: ['GET'])]
    public function read(UserRepository $userRepository) : JsonResponse
    {
        return $this->json($userRepository->findAll());
    }

    #[Route('/read/{id}', name: 'listUserById', methods: ['GET'])]
    public function readById(User $user = null) : JsonResponse
    {
        if(!$user)
        {
            $this->json(['message'=>'User not found'], 404);
        }

        return $this->json($user);
    }

    #[Route('/update/{id}', name: 'updateUser', methods: ['PUT'])]
    public function update(User $user=null, Request $request, UserRepository $userRepository) : JsonResponse
    {
        if(!$user)
        {
            $this->json(['message'=>'User not found'], 404);
        }

        $form = $this->createForm(UserType::class, $user);
        $form->submit($request->toArray());

        if($form->isSubmitted() && $form->isValid())
        {
            $userRepository->add($user, true);
            return $this->json($user, 201);
        }

        return $this->json([], 400);
    }

    #[Route('/delete/{id}', name: 'deleteUser', methods: ['DELETE'])]
    public function delete(User $user = null, UserRepository $userRepository) : JsonResponse
    {
        if(!$user)
        {
            $this->json(['message'=> 'User not found'], 404);
        }

        $userRepository->remove($user, true);

        return $this->json(['message'=> 'User deleted'], 200);
    }
}
