<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
            return $this->json($user, Response::HTTP_CREATED);
        }

        return $this->json($form->getErrors(true), Response::HTTP_BAD_REQUEST);
    }

    #[Route('/read', name: 'listUsers', methods: ['GET'])]
    public function read(UserRepository $userRepository) : JsonResponse
    {
        return $this->json($userRepository->findAll());
    }

    #[Route('/read/{email}', name: 'listUserById', methods: ['GET'])]
    public function readById(User $user = null) : JsonResponse
    {
        if(!$user)
        {
            return $this->json([], Response::HTTP_NOT_FOUND);
        }

        return $this->json($user, Response::HTTP_OK);
    }

    #[Route('/update/{email}', name: 'updateUser', methods: ['PUT'])]
    public function update(User $user = null, Request $request, UserRepository $userRepository) : JsonResponse
    {
        if(!$user)
        {
            return $this->json([], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(UserType::class, $user);
        $form->submit($request->toArray());

        if($form->isSubmitted() && $form->isValid())
        {
            $userRepository->add($user, true);
            return $this->json($user, Response::HTTP_ACCEPTED);
        }

        return $this->json($form->getErrors(true), 400);
    }

    #[Route('/delete/{email}', name: 'deleteUser', methods: ['DELETE'])]
    public function delete(User $user = null, UserRepository $userRepository) : JsonResponse
    {
        if(!$user)
        {
            return $this->json([], Response::HTTP_NOT_FOUND);
        }

        $userRepository->remove($user, true);

        return $this->json(null,Response::HTTP_NO_CONTENT);
    }
}
