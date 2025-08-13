<?php
declare(strict_types=1);

namespace Vvintage\Services\Admin;
use Vvintage\Services\Messages\FlashMessage;

/** Репозитории */
use Vvintage\Repositories\Order\OrderRepository;
use Vvintage\Services\Order\OrderService;

// use Vvintage\Repositories\MessageRepository;


final class AdminOrderService extends OrderService
{

  public function __construct(FlashMessage $note)
  {
    parent::__construct($note);
  }

  
}
