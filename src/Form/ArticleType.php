<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Continent;
use App\EventSubscriber\Form\ArticleFormSubscriber;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;


class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
           $builder
               ->add('name', TextType::class, [
                   'constraints' => [
                       new NotBlank([
                           'message' => "Le nom est obligatoire"
                       ])
                   ]
               ])
               ->add('description', TextareaType::class, [
                   'constraints' => [
                       new NotBlank([
                           'message' => "La description est obligatoire"
                       ])
                   ]
               ])
               ->add('continent', EntityType::class, [
                   'class' => Continent::class,
                   'choice_label' => 'name',
                   'placeholder' => '',
                   'constraints' => [
                       new NotBlank([
                           'message' => 'Le continent est obligatoire'
                       ])
                   ]
               ])
               ->add('image', FileType::class, [
                   'data_class' => null
               ]);
               // Champ image dans ProductFormSubscriber
           ;

    //ajout du Subscriber
//    $builder->addEventSubscriber(new ArticleFormSubscriber());
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
