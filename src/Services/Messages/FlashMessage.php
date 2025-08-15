<?php
declare(strict_types=1);

namespace Vvintage\Services\Messages;


final class FlashMessage
{
    public function pushError(string $title, ?string $desc = null, ?string $flag = null) {
        $this->addMessage('errors', $title, $desc, $flag);
    }

    public function pushSuccess(string $title, ?string $desc = null, ?string $flag = null) {
        $this->addMessage('success', $title, $desc, $flag);
    }

    private function addMessage(string $type, string $title, ?string $desc = null, ?string $flag = null) {
        $message = ['title' => $title];

        if ($desc !== null) {
            $message['desc'] = $desc;
        }

        if ($flag !== null) {
            $message['flag'] = $flag;
        }

        $_SESSION[$type][] = $message;
    }
}
