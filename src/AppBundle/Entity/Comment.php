<?php


namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommentRepository")
 * @ORM\Table(name="comment")
 *
 */
class Comment
{
        /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="auteur", type="string", length=255)
     * 
     */
    private $auteur;


    /**
     * @var int
     *
     * @ORM\Column(name="post_id", type="integer")
     */
    private $post_id;


    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text")
     * @Assert\Length(min=10)
     */
    private $contenu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="published", type="datetime")
     */
    private $published;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    

    /**
     * Get auteur
     *
     * @return string
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set auteur
     *
     * @param string $auteur
     *
     * @return Comment
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }



        /**
     * Get auteur
     *
     * @return string
     */
    public function getPost()
    {
        return $this->post_id;
    }

    /**
     * Set post_id
     *
     * @param string $post_id
     *
     * @return Comment
     */
    public function setPost($post_id)
    {
        $this->post_id = $post_id;

        return $this;
    }


    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Comment
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }



    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }


    /**
     * Get published
     *
     * @return \DateTime
     */
    public function getPublished()
    {
        return $this->published;
    }


    public function __toString()
{
    return $this->getContenu();
}

}
