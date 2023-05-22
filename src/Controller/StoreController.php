<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ArticleRepository;
use App\Repository\BlogRepository;
use App\Repository\MessageRepository;
use App\Entity\Article;
use App\Entity\Blog;
use App\Entity\Message;
use App\Form\ArticleType;
use App\Form\BlogType;
use App\Form\MessageType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
class StoreController extends AbstractController
{
//-------------------------------home-----------------------
    #[Route('/', name: 'app_store')]
    public function index(Request $request, EntityManagerInterface
    $entityManager,
    ArticleRepository $articleRepository,BlogRepository $blogRepository): Response
    { 
        $articles = $articleRepository->findBy([], ['id' => 'DESC'], 6);
        $blogs = $blogRepository->findAll();
return $this->render('store/index.html.twig',
['blogs' => $blogs,'articles' => $articles]);  
    }
//--------------------------------afficher tt les articles----------------------
   
    #[Route('/private/article', name: 'apstore')]
   
    public function article(Request $request, EntityManagerInterface
    $entityManager,
    ArticleRepository $articleRepository,BlogRepository $blogRepository): Response
    { 
        $articles = $articleRepository->findBy([], ['id' => 'DESC']);
        $blogs = $blogRepository->findAll();
        
        return $this->render('store/articles.html.twig',
         ['blogs' => $blogs,'articles' => $articles]);
    }
  

    //------------------------------------Form pour ajouter new article---------------------------------
    #[Route('/AddNewArticle', name: 'NewArticle')]
            public function AddNewArticle(Request $request, EntityManagerInterface $entityManager,
ArticleRepository $articleRepository): Response
         { 
      $article = new Article();
      $form = $this->createForm(ArticleType::class, $article);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
          $article = $form->getData();
           $entityManager->persist($article);
            $entityManager->flush();
            $articles = $articleRepository->findBy([], ['id' => 'DESC']);
            $entityManager->flush();
          $this->addFlash('success', 'Larticle a été Ajouté avec succès');
          return $this->render('store/showAll.html.twig',
        ['articles' => $articles]);
    }
return $this->render('store/create.html.twig', [
'form' => $form->createView(),
]);
}
//--------------------------------------Afficher par id ----------------------------------------
  #[Route('/store/{id}', name: 'single')]
  public function single_article($id,Request $request, EntityManagerInterface $entityManager,
  ArticleRepository $articleRepository): Response
  { 
      $article = $articleRepository->find($id);
      return $this->render('store/single.html.twig',
       ['article' => $article]);
  }
  //---------------------------------------Afficher  /Admin ------------------------------------ 
#[Route('/all', name: 'all')]
public function showall(EntityManagerInterface $entityManager,
ArticleRepository $articleRepository): Response
{ 
$articles = $articleRepository->findBy([], ['id' => 'DESC']);
return $this->render('store/showAll.html.twig',
['articles' => $articles]);
}
//----------------------------------------supprimer--------------------------------------
#[Route('/delete/{id}', name: 'delete')]
public function delete($id,Request $request, EntityManagerInterface $entityManager,
ArticleRepository $articleRepository): Response
{ 
    $article = $articleRepository->find($id);
    $entityManager->remove($article);
    $entityManager->flush();
    $this->addFlash('success', 'Larticle a été supprimé avec succès');
    $articles = $articleRepository->findAll();
    return $this->render('store/showAll.html.twig',
     ['articles' => $articles]);
}
//------------------------------------modifier-------------------------------------------
#[Route('/edit/{id}', name: 'edit')]
public function edit($id,Request $request, EntityManagerInterface $entityManager,
ArticleRepository $articleRepository): Response
{ 
    $article = $articleRepository->find($id);
    $form = $this->createForm(ArticleType::class, $article);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $article = $form->getData();
    $entityManager->flush();
    $this->addFlash('success', 'Larticle a été modifié avec succès');
    $articles = $articleRepository->findBy([], ['id' => 'DESC']);
    
    return $this->render('store/showAll.html.twig',
    ['articles' => $articles]);
    }
    return $this->render('store/edit.html.twig', [
    'form' => $form->createView(),
    ]);
    }

    //---------------------------Form pour ajouter new blog--------------------------------------------
     #[Route('/AddNewBlog', name: 'NewBlog')]
     public function AddNewBlog(Request $request, EntityManagerInterface
     $entityManager,
     BlogRepository $blogRepository, ArticleRepository $articleRepository): Response
     { 
        $blog = new Blog();
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $blog = $form->getData();
        $entityManager->persist($blog);
        $entityManager->flush();
        $blogs = $blogRepository->findAll();
        $articles = $articleRepository->findAll();
        
        return $this->render('store/index.html.twig',
        [
            'articles' => $articles,
            'blogs' => $blogs]);
        }
        return $this->render('store/newBlog.html.twig', [
        'form' => $form->createView(),
        ]);
        }
//-----------------------------------Afficher single blog
#[Route('/blog/{id}', name: 'blogid')]
public function blogId($id,Request $request, EntityManagerInterface $entityManager,
BlogRepository $blogRepository): Response
{ 
    $blog = $blogRepository->find($id);
    return $this->render('store/blog.html.twig',
     ['blog' => $blog]);
}

//------------------------------Categoey 1----------------------------
#[Route('/article/category1', name: 'category1')]
public function category1(EntityManagerInterface $entityManager,
ArticleRepository $articleRepository, BlogRepository $blogRepository): Response
{ 
    $blogs = $blogRepository->findAll();
$articles = $articleRepository->findByCategory(1);
return $this->render('store/articles.html.twig',
['articles' => $articles,'blogs' => $blogs]);
}
//------------------Category2----------------------------
#[Route('/article/category2', name: 'category2')]
public function category2(EntityManagerInterface $entityManager,
ArticleRepository $articleRepository, BlogRepository $blogRepository): Response
{ 
    $blogs = $blogRepository->findAll();
$articles = $articleRepository->findByCategory(2);
return $this->render('store/articles.html.twig',
['articles' => $articles,'blogs' => $blogs]);
}
//-------------------------------3--------------------------
#[Route('/article/category3', name: 'category3')]
public function category3(EntityManagerInterface $entityManager,
ArticleRepository $articleRepository, BlogRepository $blogRepository): Response
{ 
    $blogs = $blogRepository->findAll();
$articles = $articleRepository->findByCategory(3);
return $this->render('store/articles.html.twig',
['articles' => $articles,'blogs' => $blogs]);
}


//---------------------------- afficher Panier----------------------

#[Route('/cart', name: 'cart')]
public function cart(SessionInterface $session,ArticleRepository $articleRepository): Response
{ 
    $panier = $session->get('panier', []); //Cette ligne récupère le panier de l'utilisateur depuis la session. Si le panier n'existe pas encore, il est initialisé à une liste vide
    $panierWithData =[];
    foreach($panier as $id => $quantity){ 

        //parcourt les éléments du panier de l'utilisateur et récupère les informations de chaque article associé (via l'id) depuis la base de données
    $panierWithData[] = [
        'article'=> $articleRepository->find($id),
        'quantity' => $quantity
    ];
    } 
    $total =0;

    foreach($panierWithData as $item){
      $totalItem = $item['article']->getPrice() * $item['quantity'];
      $total+=$totalItem;

    }
    //dd($panierWithData);
return $this->render('store/cart.html.twig',[
    'items' => $panierWithData,
    'total' => $total

]); 
}
//------------------------Ajouter au panier
#[Route('/Cart/add/{id}', name: 'AddToCart')]
public function AddTocart($id, SessionInterface $session)
{ 
 $panier = $session->get('panier',[]);
 if(!empty($panier[$id])){
    $panier[$id]++;
 }else{
    $panier[$id]=1;
 }
  
 $session->set('panier',$panier);
 return $this->redirectToRoute("cart");
}


//-----------------supprimer

#[Route('/Cart/remove/{id}', name: 'remove')]
public function Remove($id, SessionInterface $session)
{ 
$panier =$session->get('panier',[]);
 if(!empty($panier[$id])){
    unset($panier[$id]);
 }
 $session->set('panier', $panier);
 return $this->redirectToRoute("cart");

}
//-------quantity bb ---------------------------
#[Route('/Cart/update/{id}', name: 'update')]
public function Update($id, Request $request, SessionInterface $session)
{ 
    $panier = $session->get('panier',[]);
    $quantity = $request->request->get('quantity');

    //checks if the product is already in the shopping cart. 
    //If it is, the quantity of the product is updated to the new quantity. If it isn't, nothing happens.
    if(!empty($panier[$id])){
        $panier[$id] = $quantity;
    }

    $session->set('panier', $panier);
    return $this->redirectToRoute("cart");
}


}
