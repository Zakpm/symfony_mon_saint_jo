<?php

namespace App\Controller\Visitor\Blog;

use App\Entity\City;
use App\Entity\Post;
use App\Entity\Category;
use App\Repository\TagRepository;
use App\Repository\CityRepository;
use App\Repository\PostRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    #[Route('/blog/saint-joseph', name: 'visitor.blog.saint_joseph.index')]
    public function index_saint_joseph(
        CategoryRepository $categoryRepository,
        TagRepository $tagRepository,
        PostRepository $postRepository,
        CityRepository $cityRepository,
    ): Response
    {

        $categories  = $categoryRepository->findAll();
        $tags        = $tagRepository->findAll();
        $posts       = $postRepository->findBy(['isPublished' => true]);
       
        return $this->render('pages/visitor/blog/saint_joseph/index.html.twig', [
        'categories' => $categories, 
        'tags' => $tags, 
        'posts' => $posts,
    ]);
    
}

#[Route('/blog/saint-philippe', name: 'visitor.blog.saint_philippe.index')]
public function index_saint_philippe(
    CategoryRepository $categoryRepository,
    TagRepository $tagRepository,
    PostRepository $postRepository,
    CityRepository $cityRepository,
    ): Response
    {
        
        $categories  = $categoryRepository->findAll();
        $tags        = $tagRepository->findAll();
        $cities      = $cityRepository->findAll(['slug' => 'saint-philippe']);
        $posts       = $postRepository->findBy(['isPublished' => true]);


        
        return $this->render('pages/visitor/blog/saint_philippe/index.html.twig', compact('categories', 'tags', 'posts', 'cities'));
        
    }
    
    #[Route('/blog/petite-ile', name: 'visitor.blog.petite_ile.index')]
    public function index_petite_ile(
        CategoryRepository $categoryRepository,
        TagRepository $tagRepository,
        PostRepository $postRepository,
        CityRepository $cityRepository,
        ): Response
        {
            
            $categories  = $categoryRepository->findAll();
            $tags        = $tagRepository->findAll();
            $cities      = $cityRepository->findAll(['slug' => 'petite-ile']);
            $posts       = $postRepository->findBy(['isPublished' => true]);
            
            
            return $this->render('pages/visitor/blog/petite_ile/index.html.twig', compact('categories', 'tags', 'posts', 'cities'));
            
        }
        
        #[Route('/blog/post/{id<\d+>}/{slug}', name: 'visitor.blog.post.show')]
        public function showSaintJoseph(Post $post) : Response
        {
            return $this->render('pages/visitor/blog/saint_joseph/show.html.twig', compact('post'));
        }
        
        #[Route('/blog/posts/filter_by_category/{id<\d+>}/{slug}', name: 'visitor.blog.posts.filter_by_category')]
        public function filterByCategory(
            Category $category,
            CategoryRepository $categoryRepository,
            TagRepository $tagRepository,
            PostRepository $postRepository,
            ) : Response
        {
            $categories = $categoryRepository->findAll();
            $tags       = $tagRepository->findAll();
            $posts      = $postRepository->filterPostByCategory($category->getId());
            

            return $this->render('pages/visitor/blog/saint_joseph/index.html.twig', [
                'categories' => $categories, 
                'tags' => $tags, 
                'posts' => $posts,
            ]);
        }


        
        
    }
    