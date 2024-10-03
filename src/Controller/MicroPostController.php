<?php

namespace App\Controller;

use DateTime;
use App\Entity\Comment;
use App\Entity\MicroPost;
use App\Form\CommentType;
use App\Form\MicroPostType;
use App\Repository\CommentRepository;
use App\Repository\MicroPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class MicroPostController extends AbstractController
{
    #[Route('/micro-post', name: 'app_micro_post')]
    public function index(MicroPostRepository $posts): Response
    {
        return $this->render(
            'micro_post/index.html.twig',
            [
                'posts' => $posts->findAllWithComments(),
            ]
        );
    }

    #[Route('/micro-post/{post}', name: 'app_micro_post_show')]
    #[IsGranted(MicroPost::VIEW, 'post')]
    public function showOne(MicroPost $post): Response
    {
        return $this->render(
            'micro_post/show.html.twig',
            [
                'post' => $post,
            ]
        );
    }

    #[Route('/micro-post/add', name: 'app_micro_post_add', priority: 2)]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function add(Request $request, MicroPostRepository $posts, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MicroPostType::class, new MicroPost());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $post->setAuthor($this->getUser());

            $entityManager->persist($post);
            $entityManager->flush();

            // Add a flash, Bu kısım mesaj döndürcek başarılı diye ve yalnızca bir sefer görüntülenir.
            $this->addFlash(
                'success',
                'Your micro post have been addded.'
            );

            return $this->redirectToRoute('app_micro_post');
        }
        return $this->render(
            'micro_post/add.html.twig',
            [
                'form' => $form
            ]
        );
    }

    #[Route('/micro-post/{post}/edit', name: 'app_micro_post_edit')]
    #[IsGranted(MicroPost::EDIT, 'post')]
    public function edit(MicroPost $post, Request $request, MicroPostRepository $posts, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createFormBuilder($post)
            ->add('title')
            ->add('text')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $entityManager->persist($post);
            $entityManager->flush();

            // Add a flash, Bu kısım mesaj döndürcek başarılı diye ve yalnızca bir sefer görüntülenir.
            $this->addFlash('success', "Your micro post have been updated");
            return $this->redirectToRoute('app_micro_post');
        }

        return $this->render(
            'micro_post/edit.html.twig',
            [
                'form' => $form,
                'post' => $post
            ]
        );
    }
    #[Route('/micro-post/{post}/comment', name: 'app_micro_post_comment')]
    #[IsGranted('ROLE_COMMENTER')]
    public function addComment(MicroPost $post, Request $request, EntityManagerInterface $entityManager): Response
{
    $comment = new Comment();
    $form = $this->createForm(CommentType::class, $comment);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $comment->setPost($post); // Yorum gönderiyle ilişkilendiriliyor
        $comment->setAuthor($this->getUser()); // Yorum yazarı atanıyor

        $entityManager->persist($comment);
        $entityManager->flush();

        // Başarı mesajı
        $this->addFlash('success', 'Your comment has been added.');

        return $this->redirectToRoute('app_micro_post_show', [
            'post' => $post->getId(),
        ]);
    }

    return $this->render('micro_post/comment.html.twig', [
        'form' => $form,
        'post' => $post,
    ]);
}
}
