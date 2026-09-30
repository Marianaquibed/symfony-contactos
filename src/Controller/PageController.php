<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Contacto;

final class PageController extends AbstractController
{
    #[Route('/', name: 'app_page')]
    public function inicio(ManagerRegistry $doctrine): Response
    {
       $repositorio = $doctrine->getRepository(Contacto::class);
       $contactos = $repositorio->findAll();
        return $this->render('inicio.html.twig', ['contactos' => $contactos]);
    }
}
