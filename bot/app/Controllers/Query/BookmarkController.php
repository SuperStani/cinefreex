<?php

namespace superbot\App\Controllers\Query;

use superbot\App\Controllers\QueryController;
use superbot\App\Configs\GeneralConfigs as cfg;
use superbot\Telegram\Client;
use superbot\App\Controllers\UserController;
use superbot\App\Storage\Repositories\MovieRepository;
use superbot\Telegram\Query as QueryUpdate;

class BookmarkController extends QueryController
{
    private $movieRepo;

    public function __construct(
        QueryUpdate $query,
        UserController $user,
        MovieRepository $movieRepo
    ) {
        $this->query = $query;
        $this->user = $user;
        $this->movieRepo = $movieRepo;
    }

    public function home($id)
    {
        $this->query->alert();
        $menu[] = $this->query->message->keyboard[0];
        $menu[1][] = $this->query->message->keyboard[1][0];
        $menu[1][] = ["text" => "📌", "callback_data" => "Bookmark:close|$id"];
        $menu[] = [["text" => "🔵 COMPLETED", "callback_data" => "Bookmark:complete|$id"]];
        $menu[] = [["text" => "⚪️ PLAN-TO-WATCH", "callback_data" => "Bookmark:plantowatch|$id"]];
        $menu[] = [["text" => "🟢 WATCHING", "callback_data" => "Bookmark:watching|$id"]];
        for ($i = 2; $i < count($this->query->message->keyboard); $i++) {
            $menu[] = $this->query->message->keyboard[$i];
        }
        $this->query->editButton($menu);
    }

    public function close($id)
    {
        $this->query->alert();
        $menu[] = $this->query->message->keyboard[0];
        for ($i = 0; $i < count($this->query->message->keyboard[1]) - 1; $i++) {
            $menu[1][] = $this->query->message->keyboard[1][$i];
        }
        $menu[1][] = ["text" => "📌", "callback_data" => "Bookmark:home|$id"];
        for ($i = 5; $i < count($this->query->message->keyboard); $i++) {
            $menu[] = $this->query->message->keyboard[$i];
        }
        return $this->query->editButton($menu);
    }

    public function complete($id)
    {
        return $this->watchList($id, 1, "🔵 COMPLETED-LIST");
    }

    public function plantowatch($id)
    {
        return $this->watchList($id, 3, "⚪️ PLAN-TO-WATCH-LIST");
    }

    public function watching($id)
    {
        return $this->watchList($id, 2, "🟢 WATCHING-LIST");
    }

    public function watchList($id, $list, $text)
    {
        $check = $this->user->checkMovieInWatchList($id);
        $movie = $this->movieRepo->getMovieSimpleById($id);
        $name = $movie->getName() . " " . $movie->getParsedSeason();
        if ($check !== false) {
            if ($list == $check) {
                $this->user->removeMovieFromWatchList($id);
                $this->query->alert(get_string('it', 'watchlist_remove', $name, $text), true);
            } else {
                $this->user->updateMovieOnWatchList($id, $list);
                $this->query->alert(get_string('it', 'watchlist_edit', $name, $text), true);
            }
        } else {
            $this->user->addMovieToWatchList($id, $list);
            $this->query->alert(get_string('it', 'watchlist_add', $name, $text), true);
        }
        return $this->close($id);
    }
}
