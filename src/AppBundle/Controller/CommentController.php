<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Post;
use AppBundle\Entity\User;
use AppBundle\Entity\Comment;
use AppBundle\Repository\PostRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Form\PostType;
use AppBundle\Form\CommentType;





class CommentController extends Controller
{

     /**
     * @Route("/newComment", name="new_comment")
     */

    public function NewAction()
    {
        $comment = new Comment();
        //$form = $this->createFormBuilder($post)
        $form = $this->createForm(CommentType::class , $comment);
            /* ->add('Titre')
             ->add('Contenu')
             ->getForm(); */

             if($form->isSubmitted() && $form ->isValid()){

                   $user = $this->container->get('security.token_storage')->getToken()->getUser();
                   $comment -> setAuteur($user);
                   $comment -> setPost("1");
                   $comment -> setPublished(new \DateTime());
                   $manager = $this->getDoctrine()->getManager();
                   $manager->persist($comment);
                   $manager->flush();

                   return $this->redirectToRoute('blog_show', ['id' => $comment->getId()]);

                    
             }
            
            	
        return $this->render('@App/Crud/new.html.twig',[
            'formPost' => $form -> createView()
       ]);
    }

}



    