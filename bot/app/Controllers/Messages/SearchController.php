<?php

namespace superbot\App\Controllers\Messages;

use superbot\App\Controllers\MessageController;
use superbot\Telegram\Client;
use superbot\App\Logger\Log;
use superbot\Telegram\Message;
use superbot\App\Controllers\UserController;
use superbot\App\Storage\Repositories\MovieRepository;
use superbot\App\Configs\Interfaces\SearchCategory;

class SearchController extends MessageController
{
    protected MovieRepository $movieRepo;

    public function __construct(
        Message $message,
        UserController $user,
        MovieRepository $movieRepo,
        Log $logger
    )
    {
        $this->message = $message;
        $this->user = $user;
        $this->logger = $logger;
        $this->movieRepo = $movieRepo;
    }

    public function q($message_id = null)
    {
        if ($message_id != null)
            Client::deleteMessage($this->user->id, $message_id);
        $results = $this->movieRepo->searchMoviesbyNameOrSynonyms($this->message->text, 0);

        if (count($results) == 0) {
            $this->message->reply("Non ho trovato niente!");
            die;
        }

        $search_id = $this->user->saveSearch(SearchCategory::BY_NAME, $this->message->text);

        $text = null;
        $x = $y = 0;
        $emoji = ["1️⃣", "2️⃣", "3️⃣", "4️⃣", "5️⃣", "6️⃣", "7️⃣", "8️⃣", "9️⃣", "🔟"];
        foreach ($results as $key => $movie) {
            if ($key == 10) {
                $menu[] = [["text" => "»»»", "callback_data" => "Search:q|$search_id|10"]];
                continue;
            }
            $key = $emoji[$key];
            $text .= $key . " | *" . $movie->getName() . " " . $movie->getParsedSeason() . "*\n";
            if ($x < 5) $x++;
            else {
                $x = 1;
                $y++;
            }
            $menu[$y][] = ["text" => $key, "callback_data" => "Movie:view|{$movie->getId()}|1"];
        }
        $text .= "\nRisultati per « *{$this->message->text}* »";
        $menu[] = [["text" => get_button("it", "back"), "callback_data" => "Search:home|1"]];
        $this->message->reply($text, $menu);
        $this->message->delete();
    }

    public function groupFormovie($id, $message_id)
    {
        $this->message->delete();
        $groups = $this->conn->rqueryAll("SELECT id, name FROM groups_list WHERE name LIKE ? LIMIT 10", "%{$this->message->text}%");
        foreach ($groups as $group) {
            $menu[] = [["text" => $group->name, "callback_data" => "Settings:addInGroup|$id|$group->id"]];
        }
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:group|$id"]];
        $keyboard["inline_keyboard"] = $menu;
        Client::editMessageText($this->user->id, $message_id, null, "Seleziona il gruppo", "html", null, false, $keyboard);
    }
}
