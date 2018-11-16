<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function monCompte(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $updatedUser = $form->getData();

            $this->em->persist($updatedUser);
            $this->em->flush();
        }

        return $this->render("Front/Pages/monCompte.html.twig",[
            'form' => $form->createView(),
        ]);
    }

    //ADMIN
    public function adminIndex()
    {
        return $this->render("Back/Pages/adminIndex.html.twig");
    }

    public function adminAddProduct(Request $request)
    {
        if($id = $request->query->get("id")){
            $product = $this->em->find(Article::class, $id);
        }
        else
            $product = new Article();

        $form = $this->createForm(ArticleType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();

            $file = new UploadedFile($product->getPhoto(), "Photo");
            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

            try {
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                echo "RED ALERT!! FILE CORRUPTED !!!!!!!";
            }

            $product->setPhoto($fileName);
            $this->em->persist($product);
            $this->em->flush();

            $this->addFlash(
                'notice',
                'Article enregistré !'
            );
            return $this->redirectToRoute("admin_add_product");
        }

        return $this->render("Back/Pages/adminAddProduct.html.twig",[
             'form' => $form->createView(),
            ]);
    }

    public function adminListProduct(Request $request)
    {
        if($request->query->get("status") === "suppr"){
            $id = $request->query->get("id");
            $toDeleteProduct = $this->em->find(Article::class, $id);

            if($toDeleteProduct !== null){
                $this->em->remove($toDeleteProduct);
                $this->em->flush();
            }
        }

        if($request->query->get("status") === "edit"){
            $id = $request->query->get("id");
            return $this->redirectToRoute("admin_add_product", ['id' => $id ]);
        }

        $allProducts = $this->em->getRepository(Article::class)->findAll();

        return $this->render("Back/Pages/adminListProducts.html.twig",[
            'products' => $allProducts,
        ]);
    }

    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }

}
