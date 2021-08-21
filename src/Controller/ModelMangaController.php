<?php

namespace App\Controller;

use App\Entity\ModelManga;
use App\Form\ModelMangaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use function PHPUnit\Framework\throwException;

class ModelMangaController extends AbstractController
{
    /**
     * @Route("/modelmanga", name="modelmanga_index")
     */
    public function index()
    {
        $modelmanga = $this->getDoctrine()->getRepository(ModelManga::class)->findAll();

        return $this->render(
            'model_manga/index.html.twig',
            [
                'modelmanga' => $modelmanga
            ]
        ); 
    }

    /**
     * @Route("/modelmana/detail/{id}", name="modelmanga_detail")
     */
    public function detailModelManga($id) {
        $modelmanga = $this->getDoctrine()->getRepository(ModelManga::class)->find($id);

        return $this->render(
            'model_manga/detail.html.twig',
            [
                'modelmanga' => $modelmanga
            ]
        );
    }

    /**
     * @Route("/modelmanga/create", name="modelmanga_create")
     */
    public function createModelManga(Request $request)
    {
        $modelmanga = new ModelManga();
        $form = $this -> createForm(ModelMangaType::class, $modelmanga);
        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid())
        {
            //get image 
            $image = $modelmanga -> getImage();

            //create a unique image name
            $fileName = md5(uniqid());

            //get image extension
            $fileExtension = $image -> guessExtension();
            $imageName = $fileName . '.' . $fileExtension;

            try{
                $image -> move(
                    $this -> getParameter('modelmanga_image'), $imageName
                );
            }
            catch(FileException $e)
            {
                throwException($e);
            }

            $modelmanga -> setImage($imageName);

            $manager = $this -> getDoctrine() -> getManager();
            $manager -> persist($modelmanga);
            $manager -> flush();

            $this -> addFlash("Info","Create successfully!");
            return $this -> redirectToRoute("modelmanga_index");
        }

        
        return $this -> render(
            "model_manga/create.html.twig",
            [
                "form" => $form -> createView()
            ]
        );
    }

    /**
     * @Route("/modelmanga/update{id}", name="modelmanga_update")
     */
    public function updateModelManga(Request $request, $id)
    {
        $modelmanga = $this -> getDoctrine() -> getRepository(ModelManga::class) -> find($id);
        $form = $this -> createForm(ModelMangaType::class, $modelmanga);
        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid())
        {
            $uploadFile = $form['image'] -> getData();
            if($uploadFile != null)
            {
                $image = $modelmanga -> getImage();

                //create a unique image name
                $fileName = md5(uniqid());
    
                //get image extension
                $fileExtension = $image -> guessExtension();
                $imageName = $fileName . '.' . $fileExtension;
    
                try{
                    $image -> move(
                        $this -> getParameter('modelmanga_image'), $imageName
                    );
                }
                catch(FileException $e)
                {
                    throwException($e);
                }

                $modelmanga -> setImage($imageName);
            }

            $manager = $this -> getDoctrine() -> getManager();
            $manager -> persist($modelmanga);
            $manager -> flush();

            $this -> addFlash("Info","update successfully!");
            return $this -> redirectToRoute("modelmanga_index");
        }

        $this -> addFlash("Error","update false!");
        return $this -> render(
            "model_manga/update.html.twig",
            [
                "form" => $form -> createView()
            ]
        );
    }

    /**
     * @Route("/modelmanga/delete{id}", name="modelmanga_delete")
     */
    public function deleteModelManga(Request $request, $id)
    {
        $modelmanga = $this -> getDoctrine() -> getRepository(ModelManga::class) -> find($id);

        if($modelmanga != null)
        {
            $manager = $this -> getDoctrine() -> getManager();
            $manager -> remove($modelmanga);
            $manager -> flush();

            $this -> addFlash("Info","delete successfully!");
            return $this -> redirectToRoute("modelmanga_index");
        }

        $this -> addFlash("Error","delete false!");
        return $this -> redirectToRoute("modelmanga_index");
    }
}
