<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Post;
use AppBundle\Entity\User;
use AppBundle\Repository\PostRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Form\PostType;


class CrudController extends Controller
{
    /**
     * @Route("/newPost", name="new_post")
     */
    public function NewAction(Request $request , ObjectManager $manager)
    {
        $post = new Post();
        //$form = $this->createFormBuilder($post)
        $form = $this->createForm(PostType::class , $post);
            /* ->add('Titre')
             ->add('Contenu')
             ->getForm(); */
             $form->handleRequest($request); 



             if($form->isSubmitted() && $form ->isValid()){


                  //Image
                  $file = $post->getImage();
                  $fileName = md5(uniqid()).'.'.$file->guessExtension();

                  $file->move(
                      $this->getParameter('image_directory'),$fileName
                  );

                  $post->setImage($fileName);


                   //$manager = $this->getDoctrine()->getManager();
                   $post -> setPublished(new \DateTime());
                   $slug = strtolower(trim(preg_replace('/[\s-]+/', '_', preg_replace('/[^A-Za-z0-9-]+/', '_', preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $post -> getTitre()))))), '_'));
                   $post -> setSlug($slug);
                   $user = $this->container->get('security.token_storage')->getToken()->getUser();
                   $post -> setAuteur($user);
                   $manager->persist($post);
                   $manager->flush();

                   return $this->redirectToRoute('blog_show', ['id' => $post->getId()]);

                    
             }
            
            	
        return $this->render('@App/Crud/new.html.twig',[
            'formPost' => $form -> createView()
       ]);
    }


    /**
     * @Route("/edit/{id}", name="edit_post")
     */
    public function EditAction(Post $post , Request $request , ObjectManager $manager)
    {
      
             $form = $this->createForm(PostType::class , $post);
             $form->handleRequest($request);
             
             $user = $this->container->get('security.token_storage')->getToken()->getUser();
             if ($post->getAuteur() != $user)
             {
                return $this->render('@App/Blog/forbidden.html.twig');
             }


             if($form->isSubmitted() && $form ->isValid()){

                
                  //Image
                  $file = $post->getImage();
                  $fileName = md5(uniqid()).'.'.$file->guessExtension();

                  $file->move(
                      $this->getParameter('image_directory'),$fileName
                  );

                  $post->setImage($fileName);

                   

                   $manager->persist($post);
                   $manager->flush();

                   return $this->redirectToRoute('blog_show', ['id' => $post->getId()]);

                    
             }
            
            	
        return $this->render('@App/Crud/edit.html.twig',[
            'formPost' => $form -> createView()
       ]);
    }



    /**
     * @Route("/delete/{id}", name="delete_post")
     */
    public function DeleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository('AppBundle:Post');
        $repo2 = $this->getDoctrine()->getRepository('AppBundle:Comment');
        $post = $repository->find($id);
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        if ($post->getAuteur() != $user)
        {
           return $this->render('@App/Blog/forbidden.html.twig');
        }

        $comments = $repo2 -> findBy( ['post' => $post ] );
        foreach($comments as $comment)
            {
                $em->remove($comment);

            }
        $em->remove($post);
        $em->flush();
        //$this ->get('session')->getFlashBag()->add('notice','Validation faite avec succes');
        return $this->redirectToRoute('View_All_My_Posts');
    }




}
