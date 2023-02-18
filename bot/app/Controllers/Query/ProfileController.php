<?php

namespace superbot\App\Controllers\Query;

use superbot\App\Controllers\QueryController;
use superbot\App\Configs\GeneralConfigs as cfg;
use superbot\Telegram\Client;
use superbot\App\Controllers\UserController;
use superbot\App\Storage\Repositories\MovieRepository;
use superbot\Telegram\Query as QueryUpdate;
use DateTime;

class ProfileController extends QueryController
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

    public function me($delete_message)
    {
        $webapp = cfg::$webapp . "/watchlist";
        $total_films = $this->user->getTotalMoviesWatched(); //$this->conn->rquery("SELECT COUNT(*) AS tot FROM movie a INNER JOIN movie_watchlists aw ON a.id = aw.movie WHERE aw.user = ? AND aw.list = 1  AND a.season < 2 AND a.category <> 'Movie'", $this->user->id)->tot;
        $total_tvseries =  $this->user->getTotalTvSeriesWatched(); //$this->conn->rquery("SELECT COUNT(*) AS tot FROM movie a INNER JOIN movie_watchlists aw ON a.id = aw.movie WHERE aw.user = ? AND aw.list = 1  AND a.season < 2 AND a.category = 'Movie'", $this->user->id)->tot;
        $episodes = $this->user->getTotalEpisodesWatched(); //$this->conn->rquery("SELECT COUNT(*) AS tot, SUM(e.duration) as tot_duration FROM episodes e INNER JOIN movie_watchlists aw ON e.movie = aw.movie WHERE aw.user = ? AND aw.list = 1", $this->user->id);
        $tot_duration = $episodes * 45;
        $dtF = new DateTime('@0');
        $dtT = new DateTime("@$tot_duration");
        $ore = $dtF->diff($dtT)->format('%a giorni | %h h | %i min');
        $text = get_string('it', 'profile', $this->user->mention, $total_films, $total_tvseries, $episodes, $ore);
        $menu[] = [["text" => "❤️ PREFERITI", "web_app"  => ["url" => "$webapp/preferreds/{$this->user->id}"]], ["text" => "🔵 COMPLETED", "web_app"  => ["url" => "$webapp/completed/{$this->user->id}"]]];
        $menu[] = [["text" => "🟢 WATCHING", "web_app"  => ["url" => "$webapp/watching/{$this->user->id}"]], ["text" => "⚪️ PLAN TO WATCH", "web_app"  => ["url" => "$webapp/plantowatch/{$this->user->id}"]]];
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Home:start|1"]];
        if ($delete_message) {
            $this->query->message->delete();
            return $this->query->message->reply($text, $menu);
        } else {
            $this->query->alert();
            return $this->query->message->edit($text, $menu);
        }
    }
}
