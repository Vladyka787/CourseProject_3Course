<?php

namespace App\Controller;

use App\Entity\Material;
use App\Form\MaterialType;
use App\Repository\MaterialRepository;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/material")
 */
class MaterialController extends AbstractController
{
    /**
     * @Route("/", name="app_material_index", methods={"GET"})
     */
    public function index(MaterialRepository $materialRepository): Response
    {
        return $this->render('material/index.html.twig', [
            'materials' => $materialRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_material_new", methods={"GET", "POST"})
     */
    public function new(Request $request, MaterialRepository $materialRepository, ServiceRepository $serviceRepository): Response
    {
        $material = new Material();
        $service_id=$request->query->get('service_id');
        $service = $serviceRepository->findBy(['id' => $service_id]);
        $service=$service[0];
        $material->setService($service);
        $form = $this->createForm(MaterialType::class, $material, ['service_id' => $service_id]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $materialRepository->add($material, true);

            return $this->redirectToRoute('app_material_show', ['id' => $material->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('material/new.html.twig', [
            'material' => $material,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_material_show", methods={"GET"})
     */
    public function show(Material $material): Response
    {
        $service = $material->getService();

        return $this->render('material/show.html.twig', [
            'material' => $material,
            'service' => $service,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_material_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Material $material, MaterialRepository $materialRepository): Response
    {
        $form = $this->createForm(MaterialType::class, $material);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $materialRepository->add($material, true);

            return $this->redirectToRoute('app_material_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('material/edit.html.twig', [
            'material' => $material,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_material_delete", methods={"POST"})
     */
    public function delete(Request $request, Material $material, MaterialRepository $materialRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $material->getId(), $request->request->get('_token'))) {
            $materialRepository->remove($material, true);
        }

        return $this->redirectToRoute('app_material_index', [], Response::HTTP_SEE_OTHER);
    }
}
