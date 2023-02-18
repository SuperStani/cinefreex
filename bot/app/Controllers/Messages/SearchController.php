<?php

namespace superbot\App\Controllers\Messages;

use superbot\App\Controllers\MessageController;
use superbot\Telegram\Client;
use superbot\App\Logger\Log;
use superbot\Telegram\Message;
use superbot\App\Controllers\UserController;
use superbot\App\Storage\Repositories\MovieRepository;
use superbot\App\Configs\GeneralConfigs as cfg;

class SearchController extends MessageController
{
    protected $movieRepo;
    
    public function __construct(
        Message $message,
        UserController $user,
        MovieRepository $movieRepo,
        Log $logger
    ) {
        $this->message = $message;
        $this->user = $user;
        $this->logger = $logger;
        $this->movieRepo = $movieRepo;
    }

    public function q($message_id = null)
    {
        if ($message_id != null)
            Client::deleteMessage($this->user->id, $message_id);
        $results = $this->movieRepo->getTotalSearchResultsByName($this->message->text);

        if ($results["tvseries"] == 0 && $results["films"] == 0) {
            $this->message->reply("Non ho trovato niente!");
            die;
        }

        //$search = $this->user->saveSearch("BY_NAME", $this->message->text);
        $q = urlencode($this->message->text);
        if ($results["tvseries"] != 0) {
            $menu[0][] = ["text" =>  "TV SERIES ($results[tvseries])", "web_app" => ["url" => cfg::$webapp . "/search/{$this->user->id}/TVSERIES/{$q}"]];
        }

        if ($results["films"] != 0) {
            $menu[0][] = ["text" => "FILMS ($results[films])", "web_app" => ["url" => cfg::$webapp . "/search/{$this->user->id}/FILM/{$q}"]];
        }

        $text = get_string("it", "search_results", $this->message->text, $results["films"], $results["tvseries"]);
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Search:home|1"]];
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
