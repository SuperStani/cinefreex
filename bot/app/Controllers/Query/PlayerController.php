<?php

namespace superbot\App\Controllers\Query;

use superbot\App\Controllers\QueryController;
use superbot\App\Configs\GeneralConfigs as cfg;
use superbot\Telegram\Client;
use superbot\App\Controllers\UserController;
use superbot\App\Logger\Log;
use superbot\App\Services\CacheService;
use superbot\App\Storage\Repositories\ChannelsRepository;
use superbot\App\Storage\Repositories\CustomizedContentRepository;
use superbot\App\Storage\Repositories\GeneralRepository;
use superbot\App\Storage\Repositories\MovieRepository;
use superbot\Telegram\Query as QueryUpdate;

class PlayerController extends QueryController
{

    private $movieRepo;
    private $cacheService;
    private $generalRepo;
    private $channelsRepo;
    private $customizedContentRepo;
    public function __construct(
        QueryUpdate $query,
        UserController $user,
        MovieRepository $movieRepo,
        GeneralRepository $generalRepo,
        CacheService $cacheService,
        ChannelsRepository $channelsRepo,
        CustomizedContentRepository $customizedContentRepo,
        Log $logger
    ) {
        $this->query = $query;
        $this->user = $user;
        $this->logger = $logger;
        $this->movieRepo = $movieRepo;
        $this->cacheService = $cacheService;
        $this->generalRepo = $generalRepo;
        $this->channelsRepo = $channelsRepo;
        $this->customizedContentRepo = $customizedContentRepo;
    }

    public function play($movie, $episode, $delete)
    {
        $channels = !$this->user->isAdmin() ? $this->channelsRepo->getAll() : [];
        $isFollower = true;
        $x = $y = 0;
        $channels_menu = [];
        foreach ($channels as $key => $channel) {
            $cont = $key + 1;
            if (!Client::isFollower($channel->getId(), $this->user->id)) {
                $isFollower = false;
                $text = "❌ CANALE $cont ❌";
            } else
                $text = "✅ CANALE $cont ✅";

            if ($x < 1) {
                $x++;
            } else {
                $y++;
                $x = 1;
            }
            $channels_menu[$y][] = ["text" => $text, "url" => $channel->getInviteUrl()];
        }
        if ($isFollower) {
            //Save view
            $this->movieRepo->saveView($movie, $this->user->id, $episode);

            $info = $this->generalRepo->getEpisodeWithMovieInfoByMovieId($movie, $episode);
            $movieI = $info["movie"];
            $episodeI = $info["episode"];
            //if ($this->user->isAdmin())
            //$menu[] = [["text" => "🔧 MODIFICA", "callback_data" => "Episode:edit|" . $movieI->getid], ["text" => "🖊 TITOLO", "callback_data" => "episodes:title_" . $movieI->id], ["text" => "❌ ELIMINA EP", "callback_data" => "episodes:delete_" . $movieI->id]];
            if ($episodeI->getUrl() !== null)
                $menu[] = [["text" => "GUARDA ORA", "url" => $episodeI->getUrl()]];

            if ($movieI->getCategory() == 'TVSERIES') {
                if ($episodeI->hasNext()) //There is a next episode
                {
                    $next_episode = $episode + 1;
                    if ($episode == 1) {
                        $menu[] = [["text" => "⏭", "callback_data" => "Player:play|$movie|$next_episode|1"]];
                    } else {
                        $prev_episode = $episode - 1;
                        $menu[] = [["text" => "⏮", "callback_data" => "Player:play|$movie|$prev_episode|1"], ["text" => "⏭", "callback_data" => "Player:play|$movie|$next_episode|1"]];
                    }
                } else {
                    $prev_episode = $episode - 1;
                    $menu[] = [["text" => "⏮", "callback_data" => "Player:play|$movie|$prev_episode|1"]];
                }
                $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Movie:showEpisodesList|$movie|1"]];

                if ($episode < 10)
                    $episode = "0$episode";
                $caption = get_string(
                    'it',
                    'tvseries_episode_template',
                    $episodeI->getPoster(),
                    $movieI->getName(),
                    $movieI->getParsedSeason() . " EP" . $episode,
                    $episodeI->getName(),
                    $episodeI->getSynopsis()
                );
            } else {
                $caption = get_string(
                    'it',
                    'film_episode_template',
                    $movieI->getName()
                );
                $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Movie:view|$movie|1"]];
            }
            //Client::debug($caption);
            $caption = strlen($caption) > 500 ? substr($caption, 0, 500) . "[...]_" : $caption;
            $caption .= "\n\n" . $this->customizedContentRepo->getContentByName("EPISODE_CAPTION");
            if ($delete) {
                $this->query->alert();
                $this->query->message->delete();
                if ($episodeI->getFileId() === 0) {
                    return $this->query->message->reply($caption, $menu);
                } {
                    $res = Client::copyMessage($this->user->id, cfg::$episodes_channel, $episodeI->getFileId(), $caption, $menu, 'Markdown');
                    if ($this->user->isAdmin() && !$res->ok) {
                        Client::debug($res);
                    }
                }
            }
            return $this->query->message->edit($caption, $menu);
        } else {
            if ($delete) {
                $this->query->message->delete();
            }
            $text = get_string('it', 'sponsor');
            $channels_menu[] = [["text" => "🔓 SBLOCCA", "callback_data" => "Player:play|$movie|$episode|1"]];
            return $this->query->message->reply($text, $channels_menu);
        }
    }
}
