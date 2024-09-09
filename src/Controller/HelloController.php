<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController
{
    private array $messages = ["Hello", "Hi", "Bye"];

    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return new Response(implode(',', $this->messages));
    }

    #[Route('/messages/{id}', name: 'app_show_one')]
    public function showOne(int $id): Response
    {
        if (!isset($this->messages[$id])) {
            return new Response("Message not found", Response::HTTP_NOT_FOUND);
        }

        return new Response($this->messages[$id]);
    
    }
}

