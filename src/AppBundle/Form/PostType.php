<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\FileType;



class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Titre')
            ->add('image', FileType::class, array('label'=>'inserer une image'))
            ->add('contenu', CKEditor::class, array(
                'config' => array(
                    'uiColor' => '#ffffff',
                    'base_path' => 'ckeditor',
                    'js_path'   => 'ckeditor/ckeditor.js'
                    //...
                ),
            ))
            

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Post'
        ]);
    }


}
