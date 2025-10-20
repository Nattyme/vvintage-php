<?php
declare(strict_types=1);

namespace Vvintage\DTO\Order;
use Vvintage\Models\Order\Order;
use Vvintage\Config\LanguageConfig; 

use Vvintage\DTO\Order\OrderProfileSummaryDTO;
use Vvintage\DTO\Order\OrderProfileDetailsDTO;
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

      return new OrderProfileDetailsDTO (
          id: (int) $order->getId() ?? null,

          name: (string) $order->getName() ?? '',
          surname: (string) $order->getSurname() ?? '',
          email: (string) $order->getEmail() ?? '',
          phone: (string) $order->getPhone() ?? '',
          address: (string) $order->getAddress() ?? '',
          formatted_date: (string) ( $this->localeService->formatDateTime($order->getDateTime()) ),
          status: (string) $order->getStatus() ?? null,
          paid: (bool) $order->getPaid() ?? false,

          // cart: $cart, 
          price: (int) $order->getPrice() ?? null,
          tracking_number: (string) $order->getTrackingNumber() ?? null,
          canceled_reason: (string) $order->getCanceledReason() ?? null,
          comment: (string) $order->getComment() ?? '',
      );
    }
}
