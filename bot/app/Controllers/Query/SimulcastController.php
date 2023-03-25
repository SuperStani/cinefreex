<?php

namespace superbot\App\Controllers\Query;

use superbot\App\Controllers\QueryController;
use superbot\App\Configs\Interfaces\GeneralConfigs;
use superbot\App\Services\CacheService;
use superbot\Telegram\Client;
use superbot\App\Controllers\UserController;
use superbot\App\Logger\Log;

use superbot\App\Storage\Repositories\MovieRepository;
use superbot\Telegram\Query as QueryUpdate;

class SimulcastController extends QueryController
{

    private MovieRepository $movieRepo;
    private CacheService $cacheService;

    public function __construct(
        QueryUpdate $query,
        UserController $user,
        MovieRepository $movieRepo
    )
    {
        $this->query = $query;
        $this->user = $user;
        $this->movieRepo = $movieRepo;
    }


    public function home($offset = 0)
    {
        $max_simulcasts = 9;
        $simulcast = $this->movieRepo->getSimulcastByOffset($offset);
        $bubbles = str_repeat("⚪️", $offset);
        $bubbles .= "🔵";
        $bubbles .= str_repeat("⚪️", $max_simulcasts - $offset - 1);
        $offset_next = str_replace(8, -1, $offset) + 1;
        $offset_back = str_replace(0, 9, $offset) - 1;
        $text = get_string('it', 'simulcast_template', $simulcast->getName(), $bubbles);
        $menu[] = [["text" => get_button('it', 'watch_now'), "callback_data" => "Movie:view|{$simulcast->getId()}"]];
        $menu[] = [["text" => "«««", "callback_data" => "Simulcast:home|$offset_back"], ["text" => "»»»", "callback_data" => "Simulcast:home|$offset_next"]];
        $menu[] = [["text" => get_button('it', 'search'), "callback_data" => "Search:home|1"], ["text" => get_button('it', 'top'), "callback_data" => "Leadership:home|0|1"]];
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Home:start|1"]];
        $this->query->message->delete();
        return $this->query->message->reply_photo(GeneralConfigs::BANNER_PHOTO_URI . $simulcast->getPoster(), $text, $menu);
    }

    public function settup($id)
    {
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
        $this->user->page("Settings:simulcastBanner|$id|{$this->query->message->id}|1");
        return $this->query->message->edit("*Ok, invia il banner del simulcast:*", $menu);
    }

    public function title($id)
    {
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
        $this->user->page("Settings:simulcastName|$id|{$this->query->message->id}");
        return $this->query->message->edit("*Ok, invia il nome del simulcast:*", $menu);
    }

    public function poster($id)
    {
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
        $this->user->page("Settings:simulcastBanner|$id|{$this->query->message->id}");
        return $this->query->message->edit("*Ok, invia il banner del simulcast:*", $menu);
    }

    public function link($id)
    {
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
        $this->user->page("Settings:simulcastLink|$id|{$this->query->message->id}");
        return $this->query->message->edit("*Ok, invia il link del simulcast:*", $menu);
    }

    public function remove($id)
    {
        $this->movieRepo->removeSimulcast($id);
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
        return $this->query->message->edit("*SIMULCAST RIMOSSO*", $menu);
    }
}
