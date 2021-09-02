<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Post;
use App\Form\PostType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPostController extends AdminBaseController
{
    /**
     * @Route("/admin/post", name="admin_post")
     */
    public function index(): Response
    {
        $posts = $this->getDoctrine()->getRepository(Post::class)
            ->findAll();

        $checkCategory = $this->getDoctrine()->getRepository(Category::class)
            ->findAll();

        return $this->render('admin/post/index.html.twig', array_merge($this->renderDefault(), [
            'title' => 'Посты',
            'posts' => $posts,
            'check_category' => $checkCategory
        ]));
    }

    /**
     * @Route("/admin/post/create", name="admin_post_create")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function create(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setCrateAtValue();
            $post->setUpdateAtValue();
            $post->setIsPublished();

            $em->persist($post);
            $em->flush();

            $this->addFlash('success', 'Пост добавлен');

            return $this->redirectToRoute('admin_post');
        }

        return $this->render('admin/post/form.html.twig', array_merge($this->renderDefault(), [
            'title' => 'Создание поста',
            'form' => $form->createView()
        ]));
    }


    /**
     * @Route("/admin/post/update/{id}", name="admin_post_update")
     * @param int $id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function update(int $id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $post = $this->getDoctrine()->getRepository(Post::class)
            ->find($id);

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('save')->isClicked()) {
                $post->setUpdateAtValue();

                $this->addFlash('success', 'Пост обновлен');
            }
            if ($form->get('delete')->isClicked()) {
                $em->remove($post);

                $this->addFlash('success', 'Пост удален');
            }

            $em->flush();
            return $this->redirectToRoute('admin_post');
        }

        return $this->render('admin/post/form.html.twig', array_merge($this->renderDefault(), [
            'title' => 'Редактирование поста',
            'form' => $form->createView()
        ]));
    }
}
