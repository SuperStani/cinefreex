<?php

namespace superbot\App\Controllers\Messages;

use superbot\App\Controllers\MessageController;
use superbot\Telegram\Client;
use superbot\App\Storage\Entities\Movie;
use superbot\App\Storage\Repositories\GenreRepository;
use superbot\App\Storage\Repositories\MovieRepository;
use superbot\Telegram\Message;
use superbot\App\Controllers\UserController;

class HomeController extends MessageController
{
    private $movieRepo;
    private $genreRepo;
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
        Client::sendMessage(-865784147, "#RICHIESTA\n🗣 | {$this->user->mention}\n📝 | Movie richiesto: {$this->message->text}", 'Markdown');
    }
}