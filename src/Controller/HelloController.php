<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Entity\Deneme;
use App\Entity\Comment;
use App\Entity\MicroPost;
use App\Entity\UserProfile;
use App\Repository\MicroPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserProfileRepository;
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
    #[Route('/', name: 'app_index')]
    public function index(MicroPostRepository $posts, UserProfileRepository $profiles,  EntityManagerInterface $entityManager): Response
    {
        /*  Bu kısımda onetomany ile ilgili veri ekleme işlemi yaptık
            // Yeni bir post oluşturuyoruz
            $post = new MicroPost();
            $post->setTitle('Hello World!');
            $post->setText('This is the content of the post.');
            $post->setCreated(new DateTime());

            // Yeni bir yorum oluşturuyoruz
            $comment = new Comment();
            $comment->setText('This is a comment for the post.');

            // Posta yorumu ekliyoruz
            $post->addComment($comment);

            // Post'u ve ilişkilendirilen yorumları veritabanına kaydediyoruz
            $entityManager->persist($post);  // Bu işlem comment'i de otomatik olarak kaydeder
            $entityManager->flush();  // Değişiklikler veritabanına yazılır
        */
        /* İd numarası belli olan verileri silme işlemi
        $post = $posts -> find(42); # id numarasına dikkat et
        $comment = $post -> getComments()[0];
        $comment -> setPost(null)
        $post -> removeComment($comment);
        // Post'u ve ilişkilendirilen yorumları veritabanına kaydediyoruz
        $entityManager->persist($post);  // Bu işlem comment'i de otomatik olarak kaydeder
        $entityManager->flush();  // Değişiklikler veritabanına yazılır
        */
        /*
            $user = new User();
            $user -> setEmail('email@email.com');
            $user -> setPassword('12345678');
            $profile = new UserProfile();  // Yeni UserProfile nesnesi oluşturuluyor
            $profile ->setUser($user);
            $entityManager->persist($profile);  // EntityManager bu nesneyi yönetir ve kaydetmeye hazırlar
            $entityManager->flush();  // Değişiklikler veritabanına yazılır
        */
        // Önce user_id'ye göre user_profile tablosundan ilgili kaydı buluyoruz

        /*
        $profile = $profiles->find(['user' => 11]);  // $id, user tablosundaki kullanıcı id'si

        if ($profile) {
            // Eğer bu user_id'ye sahip bir profil varsa, EntityManager bu nesneyi silmeye hazırlar
            $entityManager->remove($profile);

            // Değişiklikler veritabanına yazılır ve $profile kaydı silinir
            $entityManager->flush();

            // Silme işlemi başarılı mesajı
            $this->addFlash('success', 'Profile has been successfully deleted.');
        } else {
            // Eğer user_id'ye sahip bir profil bulunamazsa hata mesajı döner
            $this->addFlash('error', 'Profile not found.');
        }
        */


        return $this->render(
            'hello/index.html.twig',
            [
                'messages' => $this->messages,
                'limit' => 3
            ]
        );
    }

    #[Route('/messages/{id<\d+>}', name: 'app_show_one')]
    public function showOne(int $id): Response
    {
        return $this->render(
            "hello/show_one.html.twig",
            ['message' => $this->messages[$id]]
        );
    }
}
