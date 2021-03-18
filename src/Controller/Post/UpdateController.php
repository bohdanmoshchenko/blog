<?php

namespace App\Controller\Post;

use App\Entity\Post;
use App\Entity\User;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateController extends AbstractController
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function __invoke(Request $request, Post $post): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $userId = $user->getId();

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $post = $form->getData();
            if ($post !== null || $userId !== $post->getAuthor()->getId()) {
                return $this->redirectToRoute('blog_post_list');
            }
            $entityManager->persist($post);
            $entityManager->flush();
            return $this->redirectToRoute('blog_post_list');
        }
        if ($userId !== $post->getAuthor()->getId()) {
            return $this->redirectToRoute('blog_post_list');
        }
        return $this->render("post_update.html.twig", [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }
}