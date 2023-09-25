<?php

namespace App\Controller;

use App\Services\Slugify;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Event\EntitySavedEvent;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_list_product')]
    public function listProducts(): Response
    {
        $title = 'Liste des produits :';
        return $this->render('product/listProducts.html.twig', [
            'title' => $title,
        ]);
    }

    #[Route('/product/{id<\d+>}', name: 'app_list_product')]
    public function viewProduct(int $id): Response
    {

        $dispatcher = new EventDispatcher();
        $dispatcher->addListener(EntitySavedEvent::class, function (EntitySavedEvent $event) {
            $entity = $event->getEntity();
            return $entity;
        });

        return $this->render('product/viewProduct.html.twig', [
            'id' => $id,
        ]);
    }

    #[Route('/product/slugify', name: 'app_slug_product')]
    public function slugProduct(Slugify $slugify): Response
    {
        $string = $slugify->generateSlug('Je suis en troisième année.');
        dd($string);
//        return $this->render('product/slugify.html.twig' , [
//            ]);
    }


}

