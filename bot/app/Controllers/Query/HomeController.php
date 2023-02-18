<?php

namespace superbot\App\Controllers\Query;

use superbot\App\Controllers\QueryController;
use superbot\App\Configs\GeneralConfigs as cfg;
use superbot\Telegram\Query as QueryUpdate;
use superbot\App\Controllers\UserController;
use superbot\App\Logger\Log;
use superbot\App\Services\CacheService;
use superbot\App\Storage\Repositories\MovieRepository;
use superbot\App\Storage\Repositories\UserRepository;

class HomeController extends QueryController
{

    public function __construct(
        QueryUpdate $query,
        UserController $user,
        MovieRepository $movieRepo,
        UserRepository $userRepo,
        CacheService $cacheService,
        Log $logger
    ) {
        $this->query = $query;
        $this->user = $user;
        $this->logger = $logger;
        $this->movieRepo = $movieRepo;
        $this->userRepo = $userRepo;
        $this->cacheService = $cacheService;
    }

    public function start()
    {
        $this->user->page();
        if ($this->user->isAdmin()) {
            $menu[] = [["text" => "➕ ADD NEW MOVIE", "callback_data" => "Post:new"]];
            $menu[] = [["text" => "📊 STATISTICHE", "web_app" => ["url" => cfg::$webapp . "/stats"]], ["text" => get_button('it', 'broadcast'), "callback_data" => "Home:broadcast"]];
        }
        $menu[] = [["text" => get_button('it', 'watch_movie'), "web_app" => ["url" => cfg::$webapp . "/home"]]];
        $menu[] = [["text" => get_button('it', 'search'), "callback_data" => "Search:home|0"], ["text" => get_button('it', 'top'), "web_app" => ["url" => cfg::$webapp . "/leadership"]]];
        $menu[] = [["text" => "➖➖➖➖➖➖➖➖", "callback_data" => "Home:null"]];
        $menu[] = [["text" => get_button('it', 'requests'), "callback_data" => 'Home:request'], ["text" => get_button('it', 'profile'), "callback_data" => "Profile:me|0"]];
        $menu[] = [["text" => get_button('it', 'tutorial'), "url" => "https://t.me/+FjXzQx6eStFhMDI8"], ["text" => get_button('it', 'feedbacks'), "url" => "t.me/NetfluzSegnalazioniBOT"]];
        if (($text = $this->cacheService->getStartMessage()) === false) {
            $text = get_string(
                'it',
                'home',
                '{MENTION}',
                $this->userRepo->getTotalUsers(),
                $this->movieRepo->getTotalTvSeries(),
                $this->movieRepo->getTotalFilms(),
                $this->movieRepo->getTotalEpisodes()
            );
            $this->cacheService->setStartMessage($text);
        }
        $text = str_replace("{MENTION}", $this->user->mention, $text);
        return $this->query->message->edit($text, $menu);
    }

    public function request()
    {
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => 'Home:start']];
        $this->query->message->edit("Ok, invia il nome del contenuto che desideri:", $menu);
        $this->user->page("Home:request|{$this->query->message->id}");
    }

    public function broadcast()
    {
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => 'Home:start']];
        $this->query->message->edit("Ok, invia il messaggio da inviare:", $menu);
        $this->user->page("Post:broadcast|{$this->query->message->id}");
    }

    public function null()
    {
        return $this->query->alert();
    }
}
