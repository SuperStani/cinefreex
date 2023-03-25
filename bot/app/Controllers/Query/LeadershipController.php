<?php

namespace superbot\App\Controllers\Query;

use superbot\App\Controllers\QueryController;
use superbot\Telegram\Client;
use superbot\App\Controllers\UserController;
use superbot\App\Services\CacheService;
use superbot\App\Storage\Repositories\GeneralRepository;
use superbot\App\Storage\Repositories\MovieRepository;
use superbot\Telegram\Query as QueryUpdate;


class LeadershipController extends QueryController
{
    private MovieRepository $movieRepo;
    private CacheService $cacheService;

    public function __construct(
        QueryUpdate $query,
        UserController $user,
        MovieRepository $movieRepo,
        CacheService $cacheService
    )
    {
        $this->query = $query;
        $this->user = $user;
        $this->movieRepo = $movieRepo;
        $this->cacheService = $cacheService;
    }

    public function home($index, $delete = false)
    {
        $this->query->alert();
        $prev_index = $index - 10;
        $next_index = $index + 10;
        $res = $this->movieRepo->getLeadership($index);
        $text = "";
        foreach ($res as $key => $m) {
            if ($key == 10)
                continue;
            $text .= "*#" . $m->getRank() . "*\n ➥ [ " . $m->getName() . " " . $m->getParsedSeason() . "](https://t.me/Cinefrexv3_bot?start=movieID_" . $m->getId() . ") *" . $m->getScore() . "⭐️ ~ " . $m->getTotalVotes() . " voti*\n\n";
        }
        $text = get_string('it', 'leadership', $text);
        if (count($res) == 11) {
            if ($index == 0)
                $menu[] = [["text" => "ᐅ ᐅ ᐅ", "callback_data" => "Leadership:home|$next_index"]];
            else
                $menu[] = [["text" => "ᐊ ᐊ ᐊ", "callback_data" => "Leadership:home|$prev_index"], ["text" => "ᐅ ᐅ ᐅ", "callback_data" => "Leadership:home|$next_index"]];
        } else {
            if ($index > 0)
                $menu[] = [["text" => "ᐊ ᐊ ᐊ", "callback_data" => "Leadership:home|$prev_index"]];
        }

        $menu[] = [["text" => "◀️ INDIETRO", "callback_data" => "Home:start|0"]];
        if ($delete) {
            $this->query->message->delete();
            return $this->query->message->reply($text, $menu, "Markdown", false);
        }
        return $this->query->message->edit($text, $menu, "Markdown", false);
    }
}
