<?php

namespace superbot\App\Controllers\Messages;

use superbot\App\Controllers\MessageController;
use superbot\App\Controllers\Query\MovieController;
use superbot\App\Controllers\Query\PlayerController;
use superbot\Telegram\Client;
use superbot\App\Configs\Interfaces\GeneralConfigs;
use superbot\App\Controllers\UserController;
use superbot\App\Services\CacheService;
use superbot\App\Storage\Repositories\CustomizedContentRepository;
use superbot\App\Storage\Repositories\MovieRepository;
use superbot\App\Storage\Repositories\UserRepository;
use superbot\Telegram\Message;


class CommandController extends MessageController
{
    private $movieRepo;
    private $userRepo;
    private $cacheService;
    private $movieController;
    private $customizedRepo;
    public function __construct(
        Message $message,
        UserController $user,
        MovieRepository $movieRepo,
        UserRepository $userRepo,
        CacheService $cacheService,
        MovieController $movieController,
        CustomizedContentRepository $customizedRepo
    ) {
        $this->message = $message;
        $this->user = $user;
        $this->movieRepo = $movieRepo;
        $this->userRepo = $userRepo;
        $this->cacheService = $cacheService;
        $this->movieController = $movieController;
        $this->customizedRepo = $customizedRepo;
    }

    public function start($param = null)
    {
        $this->user->save();
        if (!$param) {
            $this->user->page();
            if ($this->user->isAdmin()) {
                $menu[] = [["text" => "➕ ADD NEW MOVIE", "callback_data" => "Post:new"]];
                $menu[] = [["text" => "📊 STATISTICHE", "callback_data" => "Home:stats"], ["text" => get_button('it', 'broadcast'), "callback_data" => "Home:broadcast"]];
            }
            $menu[] = [["text" => get_button('it', 'watch_movie'), "callback_data" => "Simulcast:home"]];
            $menu[] = [["text" => "➖➖➖➖➖➖", "callback_data" => "Home:null"]];
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
            return $this->message->reply($text, $menu);
        } else {
            $param = explode("_", $param);
            switch ($param[0]) {
                case 'movieID':
                    return $this->movieController->view($param[1]);
                case 'settings':
                    return $this->sendSettings($param[1], $param[2]);
                case 'listaserie':
                    return $this->listaserie();
                case 'listafilm':
                    return $this->listafilm();
            }
        }
    }

    public function listaserie()
    {
        $webapp =  GeneralConfigs::WEBAPP_URI . "/search/{$this->user->id}/index/TVSERIES";
        $menu[] = [["text" => "A", "web_app" => ["url" => "$webapp/a"]], ["text" => "B", "web_app" => ["url" => "$webapp/b"]], ["text" => "C", "web_app" => ["url" => "$webapp/c"]], ["text" => "D", "web_app" => ["url" => "$webapp/d"]]];
        $menu[] = [["text" => "E", "web_app" => ["url" => "$webapp/e"]], ["text" => "F", "web_app" => ["url" => "$webapp/f"]], ["text" => "G", "web_app" => ["url" => "$webapp/g"]], ["text" => "H", "web_app" => ["url" => "$webapp/h"]]];
        $menu[] = [["text" => "I", "web_app" => ["url" => "$webapp/i"]], ["text" => "J", "web_app" => ["url" => "$webapp/j"]], ["text" => "K", "web_app" => ["url" => "$webapp/k"]], ["text" => "L", "web_app" => ["url" => "$webapp/l"]]];
        $menu[] = [["text" => "M", "web_app" => ["url" => "$webapp/m"]], ["text" => "N", "web_app" => ["url" => "$webapp/n"]], ["text" => "O", "web_app" => ["url" => "$webapp/o"]], ["text" => "P", "web_app" => ["url" => "$webapp/p"]]];
        $menu[] = [["text" => "Q", "web_app" => ["url" => "$webapp/q"]], ["text" => "R", "web_app" => ["url" => "$webapp/r"]], ["text" => "S", "web_app" => ["url" => "$webapp/s"]], ["text" => "T", "web_app" => ["url" => "$webapp/t"]]];
        $menu[] = [["text" => "U", "web_app" => ["url" => "$webapp/u"]], ["text" => "V", "web_app" => ["url" => "$webapp/v"]], ["text" => "W", "web_app" => ["url" => "$webapp/w"]], ["text" => "X", "web_app" => ["url" => "$webapp/x"]]];
        $menu[] = [["text" => "Y", "web_app" => ["url" => "$webapp/y"]], ["text" => "Z", "web_app" => ["url" => "$webapp/z"]], ["text" => "#", "web_app" => ["url" => "$webapp/special"]]];
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Search:selectType|byList"]];
        return $this->message->reply("[⤵️](#) *Seleziona un indice qua sotto ⤵️*", $menu);
    }

    public function listafilm()
    {
        $webapp = GeneralConfigs::WEBAPP_URI . "/search/{$this->user->id}/index/FILM";
        $menu[] = [["text" => "A", "web_app" => ["url" => "$webapp/a"]], ["text" => "B", "web_app" => ["url" => "$webapp/b"]], ["text" => "C", "web_app" => ["url" => "$webapp/c"]], ["text" => "D", "web_app" => ["url" => "$webapp/d"]]];
        $menu[] = [["text" => "E", "web_app" => ["url" => "$webapp/e"]], ["text" => "F", "web_app" => ["url" => "$webapp/f"]], ["text" => "G", "web_app" => ["url" => "$webapp/g"]], ["text" => "H", "web_app" => ["url" => "$webapp/h"]]];
        $menu[] = [["text" => "I", "web_app" => ["url" => "$webapp/i"]], ["text" => "J", "web_app" => ["url" => "$webapp/j"]], ["text" => "K", "web_app" => ["url" => "$webapp/k"]], ["text" => "L", "web_app" => ["url" => "$webapp/l"]]];
        $menu[] = [["text" => "M", "web_app" => ["url" => "$webapp/m"]], ["text" => "N", "web_app" => ["url" => "$webapp/n"]], ["text" => "O", "web_app" => ["url" => "$webapp/o"]], ["text" => "P", "web_app" => ["url" => "$webapp/p"]]];
        $menu[] = [["text" => "Q", "web_app" => ["url" => "$webapp/q"]], ["text" => "R", "web_app" => ["url" => "$webapp/r"]], ["text" => "S", "web_app" => ["url" => "$webapp/s"]], ["text" => "T", "web_app" => ["url" => "$webapp/t"]]];
        $menu[] = [["text" => "U", "web_app" => ["url" => "$webapp/u"]], ["text" => "V", "web_app" => ["url" => "$webapp/v"]], ["text" => "W", "web_app" => ["url" => "$webapp/w"]], ["text" => "X", "web_app" => ["url" => "$webapp/x"]]];
        $menu[] = [["text" => "Y", "web_app" => ["url" => "$webapp/y"]], ["text" => "Z", "web_app" => ["url" => "$webapp/z"]], ["text" => "#", "web_app" => ["url" => "$webapp/special"]]];
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Search:selectType|byList"]];
        return $this->message->reply("[⤵️](#) *Seleziona un indice qua sotto ⤵️*", $menu);
    }



    public function episodecaption()
    {
        if ($this->user->isAdmin()) {
            $e = explode(" ", $this->message->text, 2);
            $content = $e[1] ?? '';
            $this->customizedRepo->updateContentByName('EPISODE_CAPTION', $content);
            $this->message->reply("Testo aggiuntivo geli episodi aggiornato con successo!");
        }
    }

    /*public function sendmovie($id)
    {
        $update = Update::getFakeUpdate($this->user->id, "movie:view|$id|-1");
        $movie = new MovieController($update->callback_query, $this->conn, $this->user, $this->logger);
        return $movie->view($id, -1);
    }*/


    public function sendSettings($id, $message_id)
    {
        $this->message->delete();
        $menu[] = [["text" => "✏️ TITOLO", "callback_data" => "Settings:title|$id"], ["text" => "✏️ POSTER", "callback_data" => "Settings:poster|$id"]];
        $menu[] = [["text" => "✏️ NR. STAGIONE", "callback_data" => "Settings:season|$id"], ["text" => "✏️ GRUPPO", "callback_data" => "Settings:group|$id"]];
        $menu[] = [["text" => "✏️ DURATA EP", "callback_data" => "Settings:duration|$id"], ["text" => "✏️ GENERI", "callback_data" => "Settings:genres|$id"]];
        $menu[] = [["text" => "✏️ NR.EP", "callback_data" => "Settings:episodes|$id"], ["text" => "✏️ DATA", "callback_data" => "Settings:aired_on|$id"]];
        $menu[] = [["text" => "✏️ TRAMA", "callback_data" => "Settings:|$id|synopsis"], ["text" => "✏️ TRAILER", "callback_data" => "Settings:trailer|$id"]];
        $menu[] = [["text" => "✏️ CATEGORIA", "callback_data" => "Settings:category|$id"], ["text" => "✏️ STUDIO", "callback_data" => "Settings:studio|$id"]];
        $menu[] = [["text" => "🔁 REIMPOSTA", "callback_data" => "Settings:reloadInfo|$id"], ["text" => "🗑 ELIMINA EP", "callback_data" => "Settings:deleteEpisodes|$id|0"]];
        $issimulcast = isset($this->conn->rquery("SELECT movie FROM movie_simulcasts WHERE movie = ?", $id)->movie);
        if ($issimulcast) {
            $menu[] = [["text" => "🖌 TITOLO ON-GOING", "callback_data" => "Simulcast:title|$id"]];
            $menu[] = [["text" => "🖌 IMMAGINE ON-GOING", "callback_data" => "Simulcast:poster|$id"]];
            $menu[] = [["text" => "❌ RIMUOVI ON-GOING", "callback_data" => "Simulcast:remove|$id"]];
        } else {
            $menu[] = [["text" => "✳️ IMPOSTA ON-GOING", "callback_data" => "Simulcast:settup|$id"]];
        }
        $menu[] = [["text" => "➕ AGGIUNGI EPISODIO", "callback_data" => "Settings:uploadEpisode|$id"]];
        $menu[] = [["text" => "📤 INVIA", "callback_data" => "Settings:sendmovie|$id"], ["text" => "🗑 ELIMINA", "callback_data" => "Settings:removemovie|$id"]];
        $menu[] = [["text" => "✖️ CHIUDI IMPOSTAZIONI ✖️", "callback_data" => "Settings:close"]];
        return $this->message->reply("*Seleziona un'opzione qua sotto:*", $menu, 'Markdown', false);
    }

    public function check()
    {
        $e = explode(" ", $this->message->text);
        $method = str_replace("/", "", $e[0]);
        unset($e[0]);
        return $this->callAction($method, $e);
    }
}
