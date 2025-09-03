<?php

namespace App\Controller;

use App\Entity\Template;
use App\Entity\User;
use App\Entity\Order;
use App\Form\TemplateType;
use App\Form\UpUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AdminController extends AbstractController
{
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin', name: 'app_admin')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $templates = $entityManager->getRepository(Template::class)->findAll();
        $users = $entityManager->getRepository(User::class)->findAll();
        $orders = $entityManager->getRepository(Order::class)->findAll();

        // form process
        $newTemplate = new Template();
        $form = $this->createForm(TemplateType::class, $newTemplate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($newTemplate);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'templates' => $templates,
            'users' => $users,
            'orders' => $orders,
            'form' => $form,
        ]);
    }

    // template routes
    #[IsGranted("ROLE_ADMIN")]

    #[Route('/admin/templates', name: 'app_admin_templates')]
    public function showTemplates(EntityManagerInterface $entityManager): Response
    {
        $templates = $entityManager->getRepository(Template::class)->findAll();

        return $this->render('admin/show.html.twig', [
            'controller_name' => 'AdminController',
            'templates' => $templates,
        ]);
    }

    #[IsGranted("ROLE_ADMIN")]
    #[Route('admin/templates/{id}', name: 'app_admin_template')]
    public function showTemplate(Template $template): Response
    {

        return $this->render('admin/show1.html.twig', [
            'controller_name' => 'AdminController',
            'template' => $template,
        ]);
    }

    #[IsGranted("ROLE_ADMIN")]
    #[Route('admin/insert', name: 'app_admin_insert')]
    public function insertTemplate(Request $request, EntityManagerInterface $entityManager): Response
    {
        $newTemplate = new Template();
        $form = $this->createForm(TemplateType::class, $newTemplate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($newTemplate);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_templates');
        }

        return $this->render('admin/insert.html.twig', [
            'controller_name' => 'AdminController',
            'form' => $form,
        ]);
    }
    #[IsGranted("ROLE_ADMIN")]
    #[Route('admin/update/{id}', name: 'app_admin_update')]
    public function updateTemplate(Request $request, EntityManagerInterface $entityManager, Template $template): Response
    {
        $form = $this->createForm(TemplateType::class, $template);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('admin/update.html.twig', [
            'controller_name' => 'AdminController',
            'form' => $form,
            'template' => $template,
        ]);
    }
    #[IsGranted("ROLE_ADMIN")]
    #[Route('admin/delete/{id}', name: 'app_admin_delete')]
    public function delete(EntityManagerInterface $entityManager, Template $template): Response
    {
        
        $entityManager->remove($template);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin');
    }
    // user routes
    #[Route('admin/user/{id}', name: 'app_admin_user')]
    public function showUser(User $user): Response
    {

        return $this->render('admin/user.html.twig', [
            'controller_name' => 'AdminController',
            'user' => $user,
        ]);
    }
    #[Route('admin/upuser/{id}', name: 'app_admin_upuser')]
    public function updateUser(Request $request, EntityManagerInterface $entityManager, User $user): Response
    {
        $form = $this->createForm(UpUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('admin/up-user.html.twig', [
            'controller_name' => 'AdminController',
            'form' => $form,
            'user' => $user,
        ]);
    }
    #[Route('admin/deluser/{id}', name: 'app_admin_deluser')]
    public function deleteUser(EntityManagerInterface $entityManager, User $user): Response
    {
        
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin');
    }
    // order routes
    #[Route('admin/order/{id}', name: 'app_admin_order')]
    public function showOrder(EntityManagerInterface $entityManager, Order $order): Response
    {
        $orderTemplates = $order->getTemplates();

        return $this->render('admin/order.html.twig', [
            'controller_name' => 'AdminController',
            'order' => $order,
            'orderTemplates' => $orderTemplates,
        ]);
    }
    #[Route('admin/delorder/{id}', name: 'app_admin_delorder')]
    public function deleteOrder(EntityManagerInterface $entityManager, Order $order): Response
    {

        $entityManager->remove($order);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin');
    }
}
