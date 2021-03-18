<?php

namespace App\Controller\Post;

use App\Entity\Post;
use App\Form\PostSearchType;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ListController extends AbstractController
{
    private PostRepository $postRepository;
    private CategoryRepository $categoryRepository;

    public function __construct(PostRepository $postRepository, CategoryRepository $categoryRepository)
    {
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function __invoke(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(PostSearchType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $post = $form->getData();
            $title = $post->getTitle();
            $categories = $post->getCategories();
            if (!$categories->count()) {
                return $this->redirectToRoute('blog_post_list');
            }
            $categoryId = $post->getCategories()->get(0)->getId();
            return $this->render("post_list.html.twig", [
                'form_search' => $form->createView(),
                'posts' => $this->postRepository->findByTitleAndCategory($title, $categoryId)
            ]);
        }

        return $this->render("post_list.html.twig", [
            'form_search' => $form->createView(),
            'posts' => $this->postRepository->findAll(),
        ]);
    }
}