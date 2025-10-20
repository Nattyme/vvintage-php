<?php
declare(strict_types=1);

namespace Vvintage\DTO\Order;
use Vvintage\Models\Order\Order;
use Vvintage\Config\LanguageConfig; 

use Vvintage\DTO\Order\OrderProfileSummaryDTO;
use Vvintage\DTO\Order\OrderProfileDetailsDTO;
use Vvintage\DTO\Order\OrderProductDTO;
use Vvintage\Services\Locale\LocaleService;


final class OrderProfileDTOFactory
{
    private string $currentLang;

    public function __construct(private LocaleService $localeService) 
    {
      $this->localeService = $localeService;
      $this->currentLang = LanguageConfig::getDefault();
    }


    public function createSummary(
      Order $order
    ): OrderProfileSummaryDTO
    {

      return new OrderProfileSummaryDTO (
          id: (int) $order->getId() ?? null,
          formatted_date: (string) ( $this->localeService->formatDateTime($order->getDateTime()) ),
          status: (string) $order->getStatus() ?? null,
          paid: (bool) $order->getPaid() ?? false,
          price: (int) $order->getPrice() ?? null
      );
    }


    public function createDetailed(
      Order $order
    ): OrderProfileDetailsDTO

    {
  
      $cart = $order->getCart() ?? [];
      $cartDto = array_map(function($product): OrderProductDTO 
        {
          return new OrderProductDTO(
            id : (int) ($product['id'] ?? 0),
            title: (string) ($product['title'] ?? ''),
            price: (int) ($product['price'] ?? 0),
            image: (string) ($product['image'] ?? 'no-photo.jpg'),
            amount: (int) ($product['amount'] ?? 1)
          );
        }, $cart);

      return new OrderProfileDetailsDTO (
          id: (int) $order->getId(),

          name: (string) $order->getName(),
          surname: (string) $order->getSurname(),
          email: (string) $order->getEmail(),
          phone: (string) $order->getPhone(),
          address: (string) $order->getAddress(),
          formatted_date: (string) ( $this->localeService->formatDateTime($order->getDateTime()) ),
          status: (string) $order->getStatus(),
          paid: (bool) $order->getPaid(),

          cart: $cartDto, 
          price: (int) $order->getPrice() ?? null,
          tracking_number: (string) ($order->getTrackingNumber() ?? ''),
          canceled_reason: (string) ($order->getCanceledReason() ?? ''),
          comment: (string) ($order->getComment() ?? ''),
          user_id: (int) $order->getUSerId()
      );
    }
}

