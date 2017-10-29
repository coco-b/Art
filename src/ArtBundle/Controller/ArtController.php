<?php
/**
 * Created by PhpStorm.
 * User: cecileberger
 * Date: 22/10/2017
 * Time: 21:19
 */
namespace ArtBundle\Controller;


use ArtBundle\Entity\Category;
use ArtBundle\Entity\Oeuvre;
use ArtBundle\Form\CategoryType;
use ArtBundle\Form\OeuvreType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class ArtController extends Controller
{
    /**
     * @Route("/", name="oeuvre_list")
     */
    public function ArtAction(Request $request)
    {
        $i=0;
        $em = $this->getDoctrine()->getManager();
        $oeuvres = $em->getRepository(Oeuvre::class)->findAll();

        $oeuvre = new Oeuvre();
        $form = $this->createForm(OeuvreType::class, $oeuvre);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $file = $oeuvre->getPicture();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('pictures_directory'),
                $fileName
            );
            $oeuvre->setPicture($fileName);
            $em->persist($oeuvre);
            $em->flush();

            return $this->redirectToRoute('oeuvre_list');
        }

        return $this->render('art/list.html.twig', array(
            'i' => $i,
            'oeuvre' => $oeuvre,
            'oeuvres' => $oeuvres,
            'form' => $form->createView(),
        ));
    }



    /**
     * @Route("/category", name="category")
     */
    public function CategoryAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository(Category::class)->findAll();

        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em -> persist($category);
            $em -> flush();

            return $this->redirectToRoute('category');

        }

        return $this->render('list.html.twig', array (
            'category' => $category,
            'categories' => $categories,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/delete/{id}", name="oeuvre_list_delete")
     */
    public function ArtDeleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $oeuvre = $em->getRepository('ArtBundle:Oeuvre')->findOneById($id);

        if($oeuvre != null){

            $em->remove($oeuvre);
            $em->flush();
        }


        return $this->redirectToRoute('oeuvre_list');
    }


}