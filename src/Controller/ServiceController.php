<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\CustomRepository;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/service")
 */
class ServiceController extends AbstractController
{
    /**
     * @Route("/", name="app_service_index", methods={"GET"})
     */
    public function index(ServiceRepository $serviceRepository): Response
    {
        return $this->render('service/index.html.twig', [
            'services' => $serviceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_service_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ServiceRepository $serviceRepository, CustomRepository $customRepository): Response
    {
        $service = new Service();
        $custom_id=$request->query->get('custom_id');
        $custom = $customRepository->findBy(['id' => $custom_id]);
        $custom=$custom[0];
        $service->setCustom($custom);
        $form = $this->createForm(ServiceType::class, $service, ['custom_id' => $custom_id]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serviceRepository->add($service, true);

            return $this->redirectToRoute('app_service_show', ['id' => $service->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service/new.html.twig', [
            'service' => $service,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_service_show", methods={"GET"})
     */
    public function show(Service $service): Response
    {
        $worker = $service->getWorker();
        $bay = $service->getBay();
        $custom = $service->getCustom();
        $materials = $service->getMaterial()->getValues();
        return $this->render('service/show.html.twig', [
            'worker' => $worker,
            'service' => $service,
            'bay' => $bay,
            'custom' => $custom,
            'materials' => $materials,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_service_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Service $service, ServiceRepository $serviceRepository): Response
    {
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serviceRepository->add($service, true);

            return $this->redirectToRoute('app_service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service/edit.html.twig', [
            'service' => $service,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_service_delete", methods={"POST"})
     */
    public function delete(Request $request, Service $service, ServiceRepository $serviceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $service->getId(), $request->request->get('_token'))) {
            $serviceRepository->remove($service, true);
        }

        return $this->redirectToRoute('app_service_index', [], Response::HTTP_SEE_OTHER);
    }
}
