<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Contacto;
use Doctrine\Persistence\ManagerRegistry;


final class ContactoController extends AbstractController
{
 
#[Route('/contacto/{codigo}', name: 'contacto', requirements: ['codigo' => '[0-9]+'])]
public function ficha(ManagerRegistry $doctrine, int $codigo = 1): Response

{
    // La primera instrucción suele ser esta, ya que cogemos el repositorio de la entidad asociada
    $repositorio = $doctrine->getRepository(Contacto::class);

    // Ahora usamos uno de los métodos del repositorio
    $contacto = $repositorio->find($codigo);

    return $this->render('ficha_contacto.html.twig', [
        'contacto' => $contacto,
    ]);
}

#[Route('/contacto/nuevo/{nombre}/{telefono}/{email}', name: 'nuevo-con-datos')]
public function nuevoConDatos(
    ManagerRegistry $doctrine,
    string $nombre, 
    string $telefono, 
    string $email)
    {
        $contacto = new Contacto();
        
        $contacto->setNombre($nombre);
        $contacto->setTelefono($telefono);
        $contacto->setEmail($email);

        $entityManager = $doctrine->getManager();
        $entityManager->persist($contacto);
        $entityManager->flush();

        return $this->redirectToRoute('contacto', ['codigo' => $contacto->getId()]);
    }
    public function modificar(ManagerRegistry $doctrine,int $codigo, string $nombre_nuevo)
    {
        $contacto = $doctrine->getRepository(Contacto::class)->find($codigo);
        if($contacto){
            $contacto->setNombre($nombre_nuevo);
            $entityManager = $doctrine->getManager();
            try {
                $entityManager->persist($contacto);
                $entityManager->flush();

            return $this->redirectToRoute('contacto', ['codigo' => $contacto->getId()]);
            }catch (\Exception $e) {
            error_log("Error insertando objeto " . $e->getMessage());
            return new Response("Error insertando objeto " . $e->getMessage());
            }
        }
    return $this->render('contacto', ["codigo" => null]);
    }
}
    
