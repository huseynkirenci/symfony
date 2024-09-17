<?php

namespace App\Controller;

use DateTime;
use App\Entity\MicroPost;
use App\Repository\MicroPostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MicroPostController extends AbstractController
{
    #[Route('/micro/post', name: 'app_micro_post')]
    public function index(MicroPostRepository $posts): Response
    {
        dd($posts->findAll());
        
        return $this->render('micro_post/index.html.twig', [
            'controller_name' => 'MicroPostController',
        ]);
    }
    #[Route('/micro/post/{id}', name: 'app_micro_post_show')]
    public function showOne($id, MicroPostRepository $posts): Response{
        dd($posts->find($id));
    }
}
