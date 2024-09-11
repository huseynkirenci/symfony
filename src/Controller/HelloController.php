<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HelloController extends AbstractController
{
    private array $messages = [
        ['message' => 'Hello', 'created' => '2024/09/10'],
        ['message' => 'Hi', 'created' => '2024/07/10'],
        ['message' => 'Bye!', 'created' => '2023/08/10']
    ];
    #[Route('/{limit?3}', name: 'app_index')]
    public function index(int $limit): Response
    {
        return $this->render(
            'hello/index.html.twig', 
            [
                'messages' => $this -> messages,
                'limit' => $limit
            ]
        );
    }

    #[Route('/messages/{id<\d+>}', name: 'app_show_one')]
    public function showOne(int $id): Response
    {
        return $this->render("hello/show_one.html.twig",['message' => $this->messages[$id]]
        );
    }
}
