<?php
declare(strict_types=1);

namespace Vvintage\Models\Order;

use RedBeanPHP\R;
use RedBeanPHP\OODBBean;

/** DTO */
use Vvintage\DTO\Order\OrderDTO;

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
  private string $paid = 'false';
  private array $cart = [];
  private int $price = 0;
  private $user_id = null;

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
    $order->paid = 'false';
    $order->cart = $dto->cart;
    $order->price = $dto->price;
    $order->id = $dto->user_id;

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
  
    $cartJson = $bean->cart;
    $decodedCart = json_decode($cartJson, true);
    $order->cart = is_array($decodedCart) ? $decodedCart : [];

    $order->price = $bean->price;
    $order->user_id = $bean->user_id;

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


  public function getName(): string
  {
    return $this->name;
  }

  public function getSurname(): string
  {
    return $this->surname;
  }

  public function getEmail(): string
  {
    return $this->email;
  }

  public function getPhone(): string
  {
    return $this->phone;
  }

  public function getAddress(): string
  {
    return $this->address;
  }

  public function getTimestamp(): string
  {
    return $this->timestamp;
  }

  public function getStatus(): string
  {
    return $this->status;
  }

  public function getPaid(): string
  {
    return $this->paid;
  }

  public function getCart(): array
  {
    return $this->cart;
  }

  public function setCart (array $data): void
  {
    $this->cart = $data;
  }
   
}