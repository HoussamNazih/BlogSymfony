<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Post;
use AppBundle\Entity\Comment;

use AppBundle\Entity\User;
use AppBundle\Repository\PostRepository;
use AppBundle\Repository\CommentRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;


class BlogController extends Controller
{
    /**
     * @Route("/" , name="View_All_Posts")
     */
    public function indexAction(Request $request)
    {

        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $repo = $this->getDoctrine()->getRepository(Post::class);
        $posts = $repo->findAll();

        $paginator = $this->get('knp_paginator');
        $results = $paginator->paginate
        (
              $posts,
              $request->query->getInt('page', 1) ,
              $request->query->getInt('limit', 5) 
              );

       
        
        return $this->render('@App/Blog/index.html.twig',[
            'posts' => $results,
            'user' =>  $user
            ]);

            
    }




/**
     * @Route("/display" , name="View_All_My_Posts")
     */
    public function displayAction(Request $request)
    {


        $repo = $this->getDoctrine()->getRepository(Post::class);
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $posts = $repo->findBy( ['auteur' =>  strval ($user) ] );
        $paginator = $this->get('knp_paginator');
        $results = $paginator->paginate
        (
              $posts,
              $request->query->getInt('page', 1) ,
              $request->query->getInt('limit', 5) 
              );

       
        
        return $this->render('@App/Blog/display.html.twig',[
            'posts' => $results
            ]);

            
    }









     /**
     * @Route("/post/{id}", name="blog_show", requirements={"id"="\d+"})
     */
    public function PostAction($id)
    {


        $repo = $this->getDoctrine()->getRepository(Post::class);
        $post = $repo->find($id);


        if (!$post) 
        
        {
            throw $this->createNotFoundException('Unable to find Blog post.');
        }
        
        return $this->render('@App/Blog/singlePost.html.twig',[
            'post' => $post ,
            ]);
        
    }


         /**
     * @Route("/post/{slug}", name="blogslug_show")
     */
    public function SlugAction($slug)
    {
        
        $repo = $this->getDoctrine()->getRepository(Post::class);
        $post = $repo->findOneBy(['slug' => $slug]);
        
        
        return $this->render('@App/Blog/singlePost.html.twig',[
            'post' => $post
            ]);
        
    }

    

    /**
     * @Route("/blog", name="show_posts")
     */
    public function showAction(Request $request)
    {
        die("showAction");

        
    }
}