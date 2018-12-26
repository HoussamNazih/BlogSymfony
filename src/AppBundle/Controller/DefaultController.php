<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Post;
use AppBundle\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
   /**
     * @Route("/add" , name="add_post")
     */
    public function createAction()
{

// you can fetch the EntityManager via $this->getDoctrine()
    // or you can add an argument to your action: createAction(EntityManagerInterface $entityManager)
    $entityManager = $this->getDoctrine()->getManager();

    $post= new Post();
    $post->setTitre('premier post');
    $post->setSlug('first_post');
    $post->setContenu('Contenu du test post!');
    $post->setPublished( new \DateTime());

    // tells Doctrine you want to (eventually) save the Product (no queries yet)
    $entityManager->persist($post);

    // actually executes the queries (i.e. the INSERT query)
    $entityManager->flush();

    return new Response('Saved new post with id '.$post->getId());

}

}
