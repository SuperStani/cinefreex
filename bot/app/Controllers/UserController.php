<?php

namespace superbot\App\Controllers;

use superbot\App\Configs\Interfaces\GeneralConfigs;
use superbot\Telegram\Client;
use superbot\App\Storage\Repositories\UserRepository;
use superbot\Telegram\Update;
use superbot\App\Storage\Entities\Search;
use superbot\App\Storage\Repositories\MovieRepository;

class UserController extends Controller
{
    public $id;
    public $name;
    public $lastname;
    public $mention;
    public $page;
    private $userRepo;
    private $movieRepository;

    public function __construct(
        Update $user,
        UserRepository $userRepo,
        MovieRepository $movieRepository
    ) {
        $user = $user->getUpdate();
        $this->id = $user->from->id;
        $this->name = $user->from->first_name;
        $this->mention = "[" . $user->from->first_name . "](tg://user?id=" . $user->from->id . ")";
        $this->userRepo = $userRepo;
        $this->movieRepository = $movieRepository;
    }

    public function getMe()
    {
        return Client::getChat($this->id)->result;
    }

    public function save()
    {
        $this->userRepo->save($this->id);
    }

    public function update()
    {
        $this->userRepo->updateLastAction($this->id);
    }

    public function page($text = null)
    {
        $this->userRepo->page($this->id, $text);
    }

    public function getPage()
    {
        return $this->userRepo->getpage($this->id);
    }

    public function isAdmin()
    {
        return in_array($this->id, GeneralConfigs::ADMINS);
    }

    public function getMovieListByListType($type): ?array
    {
        return $this->userRepo->getMovieListByListType($this->id, $type);
    }

    public function getPreferredMovies(): ?array
    {
        return $this->userRepo->getPreferredMovies($this->id);
    }

    public function getTotalWatchingTimeOnMovies(): int
    {
        return $this->userRepo->getTotalWatchingTimeOnMovies($this->id);
    }

    public function getMoviesHistory()
    {
        return $this->userRepo->getMoviesHistory($this->id);
    }

    public function saveSearch($category, $text = null): ?Search
    {
        return $this->userRepo->saveNewSearch($this->id, $category, $text);
    }

    public function getSearchById($s_id): ?Search
    {
        return $this->userRepo->getSearchById($s_id);
    }

    public function isPreferredMovieById($id): bool
    {
        return $this->userRepo->isPreferredMovieById($this->id, $id);
    }

    public function voteMovie($id, $vote)
    {
        $this->userRepo->voteMovie($id, $vote, $this->id);
    }

    public function savePreferredByMovieId($id)
    {
        $this->userRepo->savePreferredByMovieId($id, $this->id);
    }

    public function removePreferredByMovieId($id)
    {
        $this->userRepo->removePreferredByMovieId($id, $this->id);
    }

    public function haveViewInHistoryByMovieId($movie_id): bool
    {
        return $this->userRepo->haveViewInHistoryByMovieId($movie_id, $this->id);
    }

    public function addMovieToHistory($movie_id)
    {
        $this->movieRepository->addMovieToHistory($movie_id, $this->id);
    }

    public function checkMovieInWatchList($movie_id)
    {
        return $this->movieRepository->checkMovieInWatchList($movie_id, $this->id);
    }

    public function removeMovieFromWatchList($movie_id)
    {
        $this->movieRepository->deleteMovieFromWatchList($movie_id, $this->id);
    }

    public function updateMovieOnWatchList($movie_id, $list_id)
    {
        $this->movieRepository->updateMovieOnWatchList($movie_id, $list_id, $this->id);
    }

    public function addMovieToWatchList($movie_id, $list_id)
    {
        $this->movieRepository->addMovieToWatchList($movie_id, $list_id, $this->id);
    }

    public function getTotalMoviesWatched() {
        return $this->movieRepository->getTotalMoviesWatchedByUserId($this->id);
    }
    
    public function getTotalTvSeriesWatched() {
        return $this->movieRepository->getTotalTvSeriesWatchedByUserId($this->id);
    }
    
    public function getTotalEpisodesWatched() {
        return $this->movieRepository->getTotalEpisodesWatchedByUserId($this->id);
    }
}
