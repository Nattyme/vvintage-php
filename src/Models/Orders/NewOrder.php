<?php
declare(strict_types=1);

namespace Vvintage\Models\Orders;

use RedBeanPHP\R;
use RedBeanPHP\OODBBean;

final class NewOrder
{
  private int $id;
  private string $name;
  private string $surname;
  private string $email;
  private string $phone;
  private string $address;
  private string $timestamp;
  private string $status;
  private bool $paid;
  private array $cart;

  public function __construct(OODBBean $bean)
  {
    $this->id = (int) $bean->id;
    $this->name = $bean->name;
    $this->surname = $bean->surname;
    $this->email = $bean->email;
    $this->phone = $bean->phone;
    $this->address = $bean->address;
    $this->timestamp = $bean->timestamp;
    $this->status = $bean->status;
    $this->paid = $bean->paid;
    $this->cart = is_string($bean->cart) ? json_decode($bean->cart ?? '[]', true) : [];
  }

  
    public function export(): array
    {
      return [
        'id' => $this->id,
        'name' => $this->name,
        'surname' => $this->surname,
        'email' => $this->email,
        'phone' => $this->phone,
        'address' => $this->address,
        'timestamp' => $this->timestamp,
        'status' => $this->status,
        'paid' => $this->paid,
        'cart' => $this->cart
      ];
    }
   
}