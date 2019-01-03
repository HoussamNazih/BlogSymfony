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
use Symfony\Component\HttpFoundation\Response;






class CommentController extends Controller
{

     /**
     * @Route("/newComment", name="new_comment")
     */

    public function NewAction(Request $request)

    {
        //$this->$container->setParameter('blogid', '1');

        $comment = new Comment();
        $post = new Post();

        $contenu = $request->query->get('contenu');
        $blogid = $request->query->get('blogid');
        $repo = $this->getDoctrine()->getRepository(Post::class);
        $post = $repo->find($blogid);

            

            $manager = $this->getDoctrine()->getManager();
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $comment -> setAuteur($user);
            $comment -> setPost($post);
            $comment -> setContenu($contenu);
            $comment -> setPublished(new \DateTime());
            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('blogslug_show', ['slug' => $post->getSlug()]);

             
      





    }

}



    