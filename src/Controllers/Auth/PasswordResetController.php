<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Auth;

use Vvintage\Service\Auth\PasswordResetService;

if (isset($_POST['lost-password'])) {
    if (!check_csrf($_POST['csrf'] ?? '')) {
        $_SESSION['errors'][] = ['error', 'Неверный токен безопасности'];
    } else {
        $passwordResetService = new PasswordResetService();
        $result = $passwordResetService->processPasswordResetRequest($_POST['email']);

        if ($result['success']) {
            $_SESSION['success'][] = [
                'title' => 'Проверьте почту', 
                'desc' => '<p>На указанную почту был отправлен email с ссылкой для сброса пароля.</p>'
            ];
        } else {
            foreach ($result['errors'] as $error) {
                $_SESSION['errors'][] = $error;
            }
        }
    }
}
