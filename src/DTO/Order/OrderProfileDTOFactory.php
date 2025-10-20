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


    public function createOrderForSummary(
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
}