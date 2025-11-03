<?php
declare(strict_types=1);

namespace Vvintage\Services\Session;


use Vvintage\Contracts\User\UserInterface;

/** Модели */
use Vvintage\Models\User\User;
use Vvintage\Models\User\GuestUser;

/** Репозитории */
use Vvintage\Repositories\User\UserRepository;

/** Хранилище */
use Vvintage\Store\Cart\GuestCartStore;
use Vvintage\Store\Favorites\GuestFavoritesStore;

class SessionService
{

    public function startSession(): void 
    {
      session_start();
      $this->clearFlashNotes(); // на старте очитстим уведомления
    }

    public function clearFlashNotes(): void 
    {
      $_SESSION['errors'] = [];
      $_SESSION['success'] = [];
    }


    public function setUserSession(User $user): bool
    {
        // Автологин пользователя после регистрации
        $_SESSION['logged_user'] = $user->export($user);
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['login'] = 1;
        $_SESSION['role'] = $user->getRole();
     
        $_SESSION['cart'] =  $user->getCart();
        $_SESSION['fav_list'] = $user->getFavList();

        if ($_SESSION['login']) {
            return true;
        }

        return false;
    }

    public function setCurrentLocale (string $lang): void
    {
       $_SESSION['locale'] = $lang;
    }


    public function logout(): void
    {
      if (empty($_SESSION['errors'])) {
        session_destroy();
        setcookie(session_name(), '', time() - 60);
        header("Location: " . HOST);
      }
    }

    public function isLoggedIn(): bool
    {
        $result = false;

        if (isset($_SESSION['logged_user']) && $_SESSION['user_id'] && $_SESSION['login'] === 1) {
            $result = true;
        }
        return $result;
    }

    public function isProfileOwner(int $profileId): bool 
    {
        if (!$this->isLoggedIn()) {
            return false;
        }

        $user = $this->getLoggedInUser();
        if (!$user) {
            return false;
        }

        return $user->getId() === $profileId;
    }


    public function getLoggedInUserId(): ?int
    {
      if (!$this->isLoggedIn()) return null;
      return (int) $_SESSION['user_id'];
    }

    public function getLoggedInUser(): ?UserInterface
    {
        // Если не пользователь - возвращаем экземпляр гостя с корзиной из куки
        if (!isset($_SESSION['user_id'])) {
          $guestCart = ( new GuestCartStore() )->load();
          $guestFav = ( new GuestFavoritesStore() )->load();
          return new GuestUser( ['cart'=> $guestCart, 'fav' => $guestFav] );
        }

        $userRepository = new UserRepository();
        
        return $userRepository->getUserById((int) $_SESSION['user_id']);
    }

    public function getCurrentLocale (): ?string
    {
      return $_SESSION['locale'] ?? null;
    }

    public function getFlashNotes (): array 
    {
      return [
        'success' => $_SESSION['success'] ?? [],
        'errors' => $_SESSION['errors'] ?? []
      ];

    }

    public function setSessionByKey (string $type, array $message): void
    {
        $_SESSION[$type][] = $message;
    }

    public function getSessionByKey (string $type): array
    {
        return $_SESSION[$type] ?? [];
    }
 
    /**
     *Обновляет сессию  для указанного ключа
     * 
     * @param string $sessionKey ключ сессии
     */
    public function updateLogggedUserSessionItemsList(string $sessionKey, array $items): void
    {
      // Обновляем сессию
      $_SESSION['logged_user'][ $sessionKey] =  $items;
      $_SESSION[ $sessionKey] =  $items;
    }
}
