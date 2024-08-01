<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/admin/categorie', name: 'admin_category_')]
class CategoryController extends AbstractController
{
    #[Route('/{id}', name: 'index', methods: ['GET', 'POST'], requirements: ['id' => Requirement::DIGITS], defaults: ['id' => null])]
    public function index(?Category $category, CategoryRepository $repository, Request $request, EntityManagerInterface $em): Response
    {
        if (!$category) {
            $category = new Category();
        }

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($category);
            $em->flush();

            $this->addFlash('success', 'Bravo');
            return $this->redirectToRoute('admin_category_index');
        }

        return $this->render('admin/category/index.html.twig', [
            'categories' => $repository->findAll(),
            'form' => $form,
        ]);
    }

    #[Route('/supprimer/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(Category $category, EntityManagerInterface $em)
    {
        $em->remove($category);
        $em->flush();

        $this->addFlash('danger', 'Une categorie a été supprimé');
        return $this->redirectToRoute('admin_category_index');
    }
}
