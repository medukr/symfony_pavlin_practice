<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', FileType::class, [
                'label' => 'Главное изображение',
                'required' => false,
                'mapped' => false, // Отвязать от сущности
            ])
            ->add('category', EntityType::class, [
                'label' => 'Категории',
                'class' => Category::class, // Из какой сущности подгружать список
                'choice_label' => 'title',  // Какой поле будет отображаться как лейблов по полях списка
            ])
            ->add('title', TextType::class, [
                'label' => 'Заголовок поста',
                'attr' => [
                    'placeholder' => 'Введите текст'
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Содержимое',
                'attr' => [
                    'placeholder' => 'Введите текст'
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Сохранить',
                'attr' => [
                    'class' => 'btn btn-success float-left mr-3'
                ]
            ])
            ->add('delete', SubmitType::class, [
                'label' => 'Удалить',
                'attr' => [
                    'class' => 'btn btn-danger'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
