<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Categoria;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class)
            ->add('image',IntegerType::class)
            ->add('enviar',SubmitType::class)
            ->add('categoria',EntityType::class,[
                'class'=>Categoria::class,
                'mapped'=>false,
                'choice_label'=> function(Categoria $categoria){
                    return $categoria->getName();
                }
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
            'csrf_protection'=>true,
            'csrf_token_id'=>'book',
            'csrf_field_name'=>'token',
        ]);
    }
}
