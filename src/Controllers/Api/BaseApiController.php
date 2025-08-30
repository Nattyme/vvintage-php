<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Api;



class BaseApiController {
    // общий для всех API-контроллеров
    protected function jsonResponse($data, int $status = 200) {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function isAdmin(): bool {
        $sessionManager = new SessionManager();
        $userModel = $sessionManager->getLoggedInUser();

        if (!($userModel instanceof User) || $userModel->getRole() !== 'admin') {
            $this->jsonResponse(['error' => 'Недостаточно прав'], 403);
        }

        return true;
    }
}