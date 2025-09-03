<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Template;
use App\Entity\Order;
use App\Storage\CartSessionStorage;

class CartController extends AbstractController
{
    private $cartSessionStorage;

    public function __construct(CartSessionStorage $cartSessionStorage)
    {
        $this->cartSessionStorage = $cartSessionStorage;
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add')]
    public function addToCart(Template $template): Response
    {
        if ($this->cartSessionStorage->addTemplateToCart($template->getId())) {
            $this->addFlash('success', 'Template added to cart');
        } else {
            $this->addFlash('info', 'This template is already in your cart');
        }
        
        return $this->redirectToRoute('app_template_details', ['id' => $template->getId()]);
    }

    #[Route('/cart/update/{id}', name: 'app_cart_update', methods: ['POST'])]
    public function updateCart(Template $template, Request $request): Response
    {
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/remove/{id}', name: 'app_cart_remove')]
    public function removeFromCart(Template $template): Response
    {
        $this->cartSessionStorage->removeTemplateFromCart($template->getId());
        $this->addFlash('success', 'Template removed from cart');
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/checkout', name: 'app_cart_checkout')]
    public function checkout(EntityManagerInterface $entityManager): Response
    {
        $cart = $this->cartSessionStorage->getShoppingCart();

        if (empty($cart)) {
            $this->addFlash('error', 'Your cart is empty');
            return $this->redirectToRoute('app_cart');
        }

        // Create new order
        $order = new Order();
        $order->setUser($this->getUser());
        
        foreach ($cart as $item) {
            $template = $entityManager->getRepository(Template::class)->find($item['id']);
            if ($template) {
                $order->addTemplate($template);
            }
        }
        
        // Sla totaalprijs inclusief BTW op
        $order->setTotalPrice($this->cartSessionStorage->getTotalPriceWithVAT());
        
        // Save order to database
        $entityManager->persist($order);
        $entityManager->flush();

        // Clear cart
        $this->cartSessionStorage->clearShoppingCart();

        $this->addFlash('success', 'Your order has been successfully placed!');
        return $this->redirectToRoute('app_home');
    }

    #[Route('/cart', name: 'app_cart')]
    public function showCart(): Response
    {
        return $this->render('cart/index.html.twig', [
            'cart' => $this->cartSessionStorage->getShoppingCart(),
            'total' => $this->cartSessionStorage->getTotalPrice()
        ]);
    }
} 