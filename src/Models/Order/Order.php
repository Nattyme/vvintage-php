<?php
declare(strict_types=1);

namespace Vvintage\Models\Order;

use RedBeanPHP\R;
use RedBeanPHP\OODBBean;

/** DTO */
use Vvintage\Public\DTO\Order\OrderDTO;

final class Order
{
  private ?int $id;
  private string $name = '';
  private string $surname = '';
  private string $email = '';
  private string $phone = '';
  private string $address = '';
  private \DateTime $datetime;
  private string $status = '';
  private bool $paid = false;
  private array $cart = [];
  private int $price = 0;
  private string $tracking_number = '';
  private string $canceled_reason = '';
  private string $comment = '';
  private string $payment_type = '';
  private ?int $user_id = null;

  // Приватный пустой конструктор
  private function __construct() {}

  // Метод создает объект заказа для сохранения в БД
  public static function fromDTO(OrderDTO $dto): self
  {
   
    $order = new self();
    $order->id = $dto->id ?? 0;
    $order->name = $dto->name;
    $order->surname = $dto->surname;
    $order->email = $dto->email;
    $order->phone = $dto->phone;
    $order->address = $dto->address;
    $order->datetime = $dto->datetime;
    $order->status = $dto->status;
    $order->paid = $dto->paid;
    $order->cart = $dto->cart;
    $order->price = $dto->price;
    $order->tracking_number = $dto->tracking_number;
    $order->canceled_reason = $dto->canceled_reason;
    $order->comment = $dto->comment;
    $order->payment_type = $dto->payment_type;
    $order->user_id = $dto->user_id;

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
    $order->datetime = new \DateTime($bean->datetime);
    $order->status = $bean->status;
    $order->paid = (bool) $bean->paid;
    $cartJson = $bean->cart;
    $decodedCart = json_decode($cartJson, true);
    $order->cart = is_array($decodedCart) ? $decodedCart : [];

    $order->price = (int) $bean->price;
    $order->tracking_number = (string) $bean->tracking_number;
    $order->canceled_reason = (string) $bean->canceled_reason;
    $order->comment = (string) $bean->comment;
    $order->payment_type = (string) $bean->payment_type;
    $order->user_id =(int) $bean->user_id;

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
      'datetime' => $this->datetime,
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

  public function getDateTime(): \DateTime
  {
    return $this->datetime;
  }

  public function getStatus(): string
  {
    return $this->status;
  }

  public function getPaid(): bool
  {
    return $this->paid;
  }

  public function getCart(): array
  {
    return $this->cart;
  }

  public function getPrice(): int
  {
    return $this->price;
  }

  public function getTrackingNumber(): string
  {
    return $this->tracking_number;
  }

  public function getCanceledReason (): string
  {
    return $this->canceled_reason;
  }

  public function getComment (): string
  {
    return $this->comment;
  }

  public function getPaymentType(): string
  {
    return $this->payment_type;
  }

  public function setCart (array $data): void
  {
    $this->cart = $data;
  }

  public function getUserId(): int
  {
    return $this->user_id;
  }
   
}

