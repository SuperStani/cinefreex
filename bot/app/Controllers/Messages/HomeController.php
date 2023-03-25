<?php

namespace superbot\App\Controllers\Messages;

use superbot\App\Configs\Interfaces\GeneralConfigs;
use superbot\App\Controllers\MessageController;
use superbot\Telegram\Client;
use superbot\Telegram\Message;
use superbot\App\Controllers\UserController;

class HomeController extends MessageController
{
    public function __construct(
        Message $message,
        UserController $user
    ) {
        $this->message = $message;
        $this->user = $user;
    }

    public function request($message_id) {
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Home:start"]];
        $keyboard["inline_keyboard"] = $menu;
        $this->message->delete();
        Client::editMessageText($this->user->id, $message_id, null, "Grazie per la richiesta ❤️", "html", null, false, $keyboard);
        $this->user->page();
        Client::sendMessage(GeneralConfigs::GROUP_STAFF, "#RICHIESTA\n🗣 | {$this->user->mention}\n📝 | Movie richiesto: {$this->message->text}", 'Markdown');
    }
}