<?php

namespace App\Controller\Visitor\Blog;

use App\Entity\Tag;
use App\Entity\City;
use App\Entity\Post;
use App\Entity\Comment;
use App\Entity\Category;
use App\Form\CommentFormType;
use App\Repository\TagRepository;
use App\Repository\CityRepository;
use App\Repository\PostRepository;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
        #[Route('/blog', name: 'visitor.blog.index')]
        public function index(
            CategoryRepository $categoryRepository,
            TagRepository $tagRepository,
            PostRepository $postRepository,
            CityRepository $cityRepository,
            PaginatorInterface $paginator,
            Request $request,
        ): Response
        {
            
            $ville = new City();
            $categories  = $categoryRepository->findAll();
            $tags        = $tagRepository->findAll();
            $cities      = $cityRepository->findAll();
            $posts       = $postRepository->findBy(['isPublished' => true]);
            
            $posts_paginated = $paginator->paginate(
                $posts, /* query NOT result */
                $request->query->getInt('page', 1), /*page number*/
                6 /*limit per page*/
            );

        
        return $this->render('pages/visitor/blog/index.html.twig', compact('categories', 'tags', 'posts', 'cities', 'posts_paginated'));
        
        }

  
        
        #[Route('/blog/post/{id<\d+>}/{slug}', name: 'visitor.blog.post.show')]
        public function show(Post $post, Request $request, CommentRepository $commentRepository ) : Response
        {
            $comment = new Comment();
            $form = $this->createForm(CommentFormType::class, $comment);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $comment->setPost($post);
                $comment->setUser($this->getUser());
                $commentRepository->save($comment, true);

                $this->addFlash("success", "Les commentaire a été envoyé.");
                return $this->redirectToRoute('visitor.blog.post.show', [
                    'id' => $post->getId(),
                    'slug' => $post->getSlug()
                ]);
            }

            return $this->render('pages/visitor/blog/show.html.twig',[
                'post' => $post,
                'form' => $form->createView()

            ]);
        }


        
        #[Route('/blog/posts/filter_by_category/{id<\d+>}/{slug}', name: 'visitor.blog.posts.filter_by_category')]
        public function filterByCategory(
            Category $category,
            CategoryRepository $categoryRepository,
            TagRepository $tagRepository,
            PostRepository $postRepository,
            CityRepository $cityRepository,
            PaginatorInterface $paginator,
            Request $request,
            ) : Response
        {
            $categories = $categoryRepository->findAll();
            $tags       = $tagRepository->findAll();
            $cities = $cityRepository->findAll();
            $posts      = $postRepository->filterPostByCategory($category->getId());

            $posts_paginated = $paginator->paginate(
                $posts, /* query NOT result */
                $request->query->getInt('page', 1), /*page number*/
                6 /*limit per page*/
            );
            

            return $this->render('pages/visitor/blog/index.html.twig', [
                'categories' => $categories, 
                'tags' => $tags, 
                'cities' => $cities,
                'posts_paginated' => $posts_paginated
            ]);
        }  
        
        #[Route('/blog/posts/filter_by_tag/{id<\d+>}/{slug}', name: 'visitor.blog.posts.filter_by_tag')]
        public function filterByTag(
            Tag $tag,
            CategoryRepository $categoryRepository,
            TagRepository $tagRepository,
            PostRepository $postRepository,
            CityRepository $cityRepository,
            PaginatorInterface $paginator,
            Request $request,
            ) : Response
        {
            $categories = $categoryRepository->findAll();
            $tags = $tagRepository->findAll();
            $cities = $cityRepository->findAll();
            $posts = $postRepository->filterPostByTag($tag);

            $posts_paginated = $paginator->paginate(
                $posts, /* query NOT result */
                $request->query->getInt('page', 1), /*page number*/
                6 /*limit per page*/
            );
            
            
            return $this->render('pages/visitor/blog/index.html.twig', compact('categories', 'tags', 'cities', 'posts_paginated'));
        }

        #[Route('/blog/posts/filter_by_city/{id<\d+>}/{slug}', name: 'visitor.blog.posts.filter_by_city')]
        public function filterByCity(
            City $city,
            CategoryRepository $categoryRepository,
            TagRepository $tagRepository,
            CityRepository $cityRepository,
            PostRepository $postRepository,
            PaginatorInterface $paginator,
            Request $request,
            ) : Response
        {
            $categories = $categoryRepository->findAll();
            $tags = $tagRepository->findAll();
            $cities = $cityRepository->findAll();
            $posts = $postRepository->filterPostByCity($city);

            $posts_paginated = $paginator->paginate(
                $posts, /* query NOT result */
                $request->query->getInt('page', 1), /*page number*/
                6 /*limit per page*/
            );
            
            
            return $this->render('pages/visitor/blog/index.html.twig', compact('categories', 'tags', 'cities', 'posts_paginated'));
        }
        
    }
    