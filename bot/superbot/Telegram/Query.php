<?php

namespace superbot\Telegram;

use superbot\Telegram\Client;

class Query
{
    public $message;
    public $data, $id;
    public $chat_id;
    public function __construct(Update $update, Message $message)
    {   
        $update = $update->getUpdate();
        $this->data = $update->data ?? null;
        $this->id = $update->id ?? null;
        $this->message = $message;
        $update = null;
    }

    public function alert(string $text = "💙", bool $show = false, string $url = null)
    {
        return Client::answerCallbackQuery($this->id, $text, $show, $url);
    }

    public function editButton(array $menu)
    {
        $keyboard["inline_keyboard"] = $menu;
        return Client::editMessageReplyMarkup($this->message->chat_id, $this->message->id, null, $keyboard);
    }
}
