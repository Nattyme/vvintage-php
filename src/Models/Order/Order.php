<?php
declare(strict_types=1);

namespace Vvintage\Models\Orders;

use RedBeanPHP\R;
use RedBeanPHP\OODBBean;

final class Order
{
  private int $id = 0;
  private string $name = '';
  private string $surname = '';
  private string $email = '';
  private string $phone = '';
  private string $address = '';
  private string $timestamp = '';
  private string $status = '';
  private bool $paid = false;
  private array $cart = [];

  // Приватный пустой конструктор
  private function __construct() {}

  // Метод создает объект заказа для сохранения в БД
  public static function fromDTO(OrderDTO $dto): self
  {
    $order = new self();
    $order->name = $dto->name;
    $order->surname = $dto->surname;
    $order->email = $dto->email;
    $order->phone = $dto->phone;
    $order->address = $dto->address;
    $order->timestamp = (string) time();
    $order->status = 'new';
    $order->paid = false;
    $order->cart = $dto->cart;
    return $order;
  }

  /**
   * Метод создает объект заказа при загрузке из БД
   */
  public static function fromBean(OODBBean $bean): self
  {
    $order = new self();
    $order->id = (int) $bean->id;
    $order->name = $bean->name;
    $order->surname = $bean->surname;
    $order->email = $bean->email;
    $order->phone = $bean->phone;
    $order->address = $bean->address;
    $order->timestamp = $bean->timestamp;
    $order->status = $bean->status;
    $order->paid = $bean->paid;
    $order->cart = is_string($bean->cart) ? json_decode($bean->cart ?? '[]', true) : [];
    return $order;
  }

  /**
   * Метод вернет объект заказа в виде массива
   */
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
      'cart' => $this->cart,
    ];
  }

  /**
   * Метод вернет id заказа
   */
  public function getId(): int
  {
    return $this->id;
  }
   
}