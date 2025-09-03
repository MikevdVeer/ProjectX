<?php

namespace App\Storage;

use App\Repository\TemplateRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartSessionStorage
{
    private $templateRepository;
    private $session;
    private $shoppingCart;

    public function __construct(RequestStack $requestStack, TemplateRepository $templateRepository)
    {
        $this->session = $requestStack->getSession();
        $this->templateRepository = $templateRepository;
        $this->deserializeShoppingCart();
    }

    private function deserializeShoppingCart(): void
    {
        $this->shoppingCart = $this->session->get('cart', []);
    }

    public function addTemplateToCart(int $template_id): bool
    {
        // Check if template already exists in cart
        if (isset($this->shoppingCart[$template_id])) {
            return false;
        }

        $template = $this->templateRepository->find($template_id);
        if ($template) {
            $this->shoppingCart[$template_id] = [
                'id' => $template->getId(),
                'name' => $template->getName(),
                'price' => $template->getPrice(),
                'previewImg' => $template->getPreviewImg()
            ];
            $this->serializeShoppingCart();
            return true;
        }
        return false;
    }

    private function serializeShoppingCart(): void
    {
        $this->session->set('cart', $this->shoppingCart);
    }

    public function getNumberOfTemplatesInCart(): int
    {
        return count($this->shoppingCart);
    }

    public function getTotalPrice(): float
    {
        $total = 0;
        foreach ($this->shoppingCart as $item) {
            $total += $item['price'];
        }
        return $total;
    }

    public function getTotalPriceWithVAT(): float
    {
        return $this->getTotalPrice() * 1.21; // 21% BTW
    }

    public function getVATAmount(): float
    {
        return $this->getTotalPrice() * 0.21; // 21% BTW
    }

    public function getShoppingCart(): array
    {
        return $this->shoppingCart;
    }

    public function clearShoppingCart(): void
    {
        $this->session->set('cart', []);
        $this->shoppingCart = [];
    }

    public function removeTemplateFromCart(int $template_id): void
    {
        if (isset($this->shoppingCart[$template_id])) {
            unset($this->shoppingCart[$template_id]);
            $this->serializeShoppingCart();
        }
    }
} 