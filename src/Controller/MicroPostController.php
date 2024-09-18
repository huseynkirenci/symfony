<?php

namespace App\Controller;

use DateTime;
use App\Entity\MicroPost;
use App\Repository\MicroPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class MicroPostController extends AbstractController
{
    #[Route('/micro-post', name: 'app_micro_post')]
    public function index(MicroPostRepository $posts): Response
    {
        return $this->render('micro_post/index.html.twig', [
            'controller_name' => 'MicroPostController',
            'posts' => $posts->findAll(),
        ]);
    }

    #[Route('/micro-post/{post}', name: 'app_micro_post_show')]
    public function showOne(MicroPost $post): Response
    {
        return $this->render('micro_post/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/micro-post/{post}/edit', name: 'app_micro_post_edit')]
    public function edit(MicroPost $post ,Request $request, MicroPostRepository $posts, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createFormBuilder($post)
            ->add('title')
            ->add('text')
            ->getForm();
        $form -> handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form -> getData();
            $entityManager->persist($post);
            $entityManager->flush();

            // Add a flash, Bu kısım mesaj döndürcek başarılı diye ve yalnızca bir sefer görüntülenir.
            $this -> addFlash('success', "Your micro post have been added");
            return $this-> redirectToRoute('app_micro_post');

        }

        return $this->render(
            'micro_post/add.html.twig',
            [
                'form' => $form
            ]
        );
    }
}
