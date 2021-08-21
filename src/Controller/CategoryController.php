<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Form\GenreType;
use Doctrine\DBAL\ForwardCompatibility\Result;
use Exception;

use function PHPUnit\Framework\throwException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\VarDumper\Cloner\Data;

/**
 * @IsGranted("ROLE_USER")
 */
class CategoryController extends AbstractController
{
     /**
     * @Route ("/category", name="category_index")
     */
    public function indexCategory() {
        $categorys = $this->getDoctrine()
                       ->getRepository(Category::class)
                       ->findAll();
        return $this->render(
            "category/index.html.twig",
            [
               "category" => $categorys
            ]
        );
    }

    /**
     * @Route ("/category/detail/{id}", name="category_detail")
     */
    public function detailCategory($id){
         $category = $this->getDoctrine()
                         ->getRepository(Category::class)
                         ->find($id);
         return $this ->render(
            "category/detail.html.twig",
            [
               "category" => $category
            ]
         );
     }

     
     /**
      *  @IsGranted("ROLE_ADMIN")
     * @Route ("/category/update/{id}", name="category_update")
     */
    public function updateCategory(Request $request, $id) {
        $category = $this -> getDoctrine() -> getRepository(Category::class) -> find($id);
        $form = $this -> createForm(CategoryType::class, $category);
        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid())
        {
            $uploadFile = $form['images'] -> getData();
            if($uploadFile != null)
            {
                $image = $category -> getImages();

                //create a unique image name
                $fileName = md5(uniqid());
    
                //get image extension
                $fileExtension = $image -> guessExtension();
                $imageName = $fileName . '.' . $fileExtension;
    
                try{
                    $image -> move(
                        $this -> getParameter('category_image'), $imageName
                    );
                }
                catch(FileException $e)
                {
                    throwException($e);
                }

                $category -> setImages($imageName);
            }

            $manager = $this -> getDoctrine() -> getManager();
            $manager -> persist($category);
            $manager -> flush();

            $this -> addFlash("Info","update successfully!");
            return $this -> redirectToRoute("category_index");
        }

        $this -> addFlash("Error","update false!");
        return $this -> render(
            "category/update.html.twig",
            [
                "form" => $form -> createView()
            ]
        );
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route ("/category/delete/{id}", name="category_delete")
     */
    public function deleteCategory($id) {
        try{
            $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
            $chk = $category->getModelMangas();
            if(count($chk)>0){  
                $this->addFlash("Error","delete failed");
                return $this->redirectToRoute("category_index");
            }
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($category);
            $manager->flush();
            $this->addFlash("Info", "Delete succeed !");
            return $this->redirectToRoute("category_index");
        }catch(Exception $e){
            throwException($e);
        }
    }


    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route ("/category/create", name="category_create")
     */
    public function createModelManga(Request $request)
    {
        $category = new Category();
        $form = $this -> createForm(CategoryType::class, $category);
        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid())
        {
            //get image 
            $image = $category -> getImages();

            //create a unique image name
            $fileName = md5(uniqid());

            //get image extension
            $fileExtension = $image -> guessExtension();
            $imageName = $fileName . '.' . $fileExtension;

            try{
                $image -> move(
                    $this -> getParameter('category_image'), $imageName
                );
            }
            catch(FileException $e)
            {
                throwException($e);
            }

            $category -> setImages($imageName);

            $manager = $this -> getDoctrine() -> getManager();
            $manager -> persist($category);
            $manager -> flush();

            $this -> addFlash("Info","Create successfully!");
            return $this -> redirectToRoute("category_index");
        }

        
        return $this -> render(
            "category/create.html.twig",
            [
                "form" => $form -> createView()
            ]
        );
    }
}
