<?php

namespace App\Controller\Post;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetController extends AbstractController
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function __invoke(Request $request, Post $post): Response
    {
        if (!$post) {
            $this->redirectToRoute('blog_post_list');
        }
        return $this->render("post.html.twig", [
            'post' => $post,
        ]);
    }
}