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
        // Veri Silme
        $microPost = $posts->find(8);
        $posts->remove($microPost, true);
        
        // Güncelleme
        #$microPost = $posts->find(7);  // ID'si 7 olan MicroPost kaydını bul
        #if ($microPost) {
        #    $microPost->setTitle('Welcome in General!');  // Başlığı güncelle
         #   $posts->save($microPost, true);  // Değişiklikleri kaydet
        #}

        // Bu kısımda veri tabanına yeni eklemeler yaptık
        #$microPost = new MicroPost();
        #$microPost->setTitle('It comes from controller');  ## MicroPost nesnesine başlık atanıyor
        #$microPost->setCreated(new DateTime());  ## MicroPost nesnesine oluşturulma tarihi atanıyor

        #$posts -> save($microPost, true);


        // Bu Kısımda Sorgulama İşlemlerinin Fonksiyonlarını İnceledik.
        # dd($posts->findAll()); # Tüm MicroPost kayıtlarını döndürür.
        # dd(vars: $posts->find(1)); # ID'si 1 olan MicroPost kaydını döndürür.
        # dd(vars: $posts->findOneBy(['title' => 'Welcome to Çorum!'])); # 'Welcome to Çorum!' başlıklı ilk MicroPost kaydını döndürür.
        ## dd(vars: $posts->findBy(['title' => 'Welcome to Çorum!'])); # 'Welcome to Çorum!' başlığına sahip tüm MicroPost kayıtlarını döndürür.
        
        return $this->render('micro_post/index.html.twig', [
            'controller_name' => 'MicroPostController',
        ]);
    }
}
