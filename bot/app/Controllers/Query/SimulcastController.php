<?php

namespace superbot\App\Controllers\Query;

use superbot\App\Controllers\QueryController;
use superbot\App\Configs\GeneralConfigs as cfg;
use superbot\Telegram\Client;
use superbot\App\Controllers\UserController;
use superbot\App\Logger\Log;

use superbot\App\Storage\Repositories\MovieRepository;
use superbot\Telegram\Query as QueryUpdate;

class SimulcastController extends QueryController
{

    private $movieRepo;
    private $cacheService;

    public function __construct(
        QueryUpdate $query,
        UserController $user,
        MovieRepository $movieRepo
    ) {
        $this->query = $query;
        $this->user = $user;
        $this->movieRepo = $movieRepo;
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
