<?php

namespace superbot\App\Controllers\Query;

use superbot\App\Controllers\QueryController;
use superbot\App\Configs\GeneralConfigs as cfg;
use superbot\Telegram\Client;
use superbot\App\Controllers\UserController;
use superbot\App\Logger\Log;
use superbot\App\Storage\Repositories\GenreRepository;
use superbot\App\Storage\Repositories\MovieRepository;
use superbot\Telegram\Query as QueryUpdate;

class SettingsController extends QueryController
{

    private MovieRepository $movieRepo;
    private $cacheService;
    private GenreRepository $genreRepo;

    public function __construct(
        QueryUpdate $query,
        UserController $user,
        MovieRepository $movieRepo,
        GenreRepository $genreRepo
    )
    {
        $this->query = $query;
        $this->user = $user;
        $this->movieRepo = $movieRepo;
        $this->genreRepo = $genreRepo;
    }

    public function home($id, $delete = 0)
    {
        $menu[] = [["text" => "✏️ TITOLO", "callback_data" => "Settings:title|$id"], ["text" => "✏️ POSTER", "callback_data" => "Settings:poster|$id"]];
        $menu[] = [["text" => "✏️ NR. STAGIONE", "callback_data" => "Settings:season|$id"], ["text" => "✏️ GRUPPO", "callback_data" => "Settings:group|$id"]];
        $menu[] = [["text" => "✏️ DURATA EP", "callback_data" => "Settings:duration|$id"], ["text" => "✏️ GENERI", "callback_data" => "Settings:genres|$id"]];
        $menu[] = [["text" => "✏️ NR.EP", "callback_data" => "Settings:episodes|$id"], ["text" => "✏️ DATA", "callback_data" => "Settings:aired_on|$id"]];
        $menu[] = [["text" => "✏️ TRAMA", "callback_data" => "Settings:synopsis|$id"], ["text" => "✏️ TRAILER", "callback_data" => "Settings:trailer|$id"]];
        $menu[] = [["text" => "✏️ CATEGORIA", "callback_data" => "Settings:category|$id"], ["text" => "EP BACKUP", "callback_data" => "Settings:epBackup|$id"]];
        $menu[] = [["text" => "🔁 REIMPOSTA", "callback_data" => "Settings:reloadInfo|$id"]];
        $isSimulcast = $this->movieRepo->isSimulcastByMovieId($id);
        if ($isSimulcast) {
            $menu[] = [["text" => "🖌 TITOLO ON-GOING", "callback_data" => "Simulcast:title|$id"]];
            $menu[] = [["text" => "🖌 IMMAGINE ON-GOING", "callback_data" => "Simulcast:poster|$id"]];
            $menu[] = [["text" => "❌ RIMUOVI ON-GOING", "callback_data" => "Simulcast:remove|$id"]];
        } else {
            $menu[] = [["text" => "✳️ IMPOSTA ON-GOING", "callback_data" => "Simulcast:settup|$id"]];
        }
        $menu[] = [["text" => "✏️ AGGIUNGI EPISODI", "callback_data" => "Settings:uploadEpisodes|$id"], ["text" => "ELIMINA EPSIODI", "callback_data" => "Settings:deleteEpisodes|$id|0"]];
        $menu[] = [["text" => "📤 INVIA", "callback_data" => "Settings:sendMovie|$id"], ["text" => "🗑 ELIMINA", "callback_data" => "Settings:removeMovie|$id|0"]];
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Movie:view|$id|1"]];
        $this->user->page();
        if ($delete) {
            $this->query->message->delete();
            return $this->query->message->reply("*Seleziona un'opzione qua sotto:*", $menu);
        } else
            return $this->query->message->edit("*Seleziona un'opzione qua sotto:*", $menu);
    }

    public function deleteEpisodes($movie, $confirm = 0)
    {
        if ($confirm) {
            $this->movieRepo->deleteAllEpisodesFromMovieId($movie);
            $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$movie"]];
            $this->query->message->edit("Episodi rimossi", $menu);
        } else {
            $menu[] = [["text" => "SI", "callback_data" => "Settings:deleteEpisodes|$movie|1"]];
            $menu[] = [["text" => "NO SONO UN RAGAZZO INSICURO", "callback_data" => "Settings:home|$movie"]];
            $this->query->message->edit("Sei sicuro?", $menu);
        }
    }

    public function removeMovie($id, $yes = false)
    {
        if ($yes) {
            $this->movieRepo->deleteMovieById($id);
            $this->query->message->edit("Questo movie è stato eliminato!");
        } else {
            $menu[] = [["text" => "SI", "callback_data" => "Settings:removeMovie|$id|1"]];
            $menu[] = [["text" => "NO SONO UN RAGAZZO INSICURO", "callback_data" => "Settings:home|$id"]];
            $this->query->message->edit("Sei sicuro?", $menu);
        }
    }

    public function uploadEpisodes($id)
    {
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
        $this->user->page("Settings:uploadEpisodes|$id|{$this->query->message->id}");
        return $this->query->message->edit("*Ok, invia l'episodio:*", $menu);
    }

    public function reloadInfo($id)
    {
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
        $this->user->page("Settings:reloadInfo|$id|{$this->query->message->id}");
        return $this->query->message->edit("*Ok, invia il link di Movieworld per resettare le informazioni dell'Movie:*", $menu);
    }

    public function title($id)
    {
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
        $a = $this->movieRepo->getMovieSimpleById($id);
        $this->user->page("Settings:title|$id|{$this->query->message->id}");
        return $this->query->message->edit("Ok, invia il nuovo titolo del Movie:\nTitolo attuale: <code>{$a->getName()}</code>\nAlternativi attuali: <code>{$a->getSynonyms()}</code>\n\n<b>N.B.</b> <i>Per aggiungere titoli alternativi usa questa sintassi \"TITOLO_PRINCIPALE + NOME_ALT1, NOME_ALT2\"</i>", $menu, 'HTML');
    }

    public function poster($id)
    {
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
        $this->user->page("Settings:poster|$id|{$this->query->message->id}");
        return $this->query->message->edit("Ok, invia il nuovo poster del Movie:", $menu, 'HTML');
    }

    public function season($id)
    {
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
        $season = $this->movieRepo->getMovieSimpleById($id)->getSeason();
        $this->user->page("Settings:season|$id|{$this->query->message->id}");
        return $this->query->message->edit("Ok, invia il numero della stagione:\nNr.Stagione attuale: <b>$season</b>\n\n<b>N.B</b> <i>Inviare 0 se l'Movie è singolo (Senza altre stagioni)</i>", $menu, 'HTML');
    }

    public function group($id, $confirm = 0)
    {
        $group = $this->movieRepo->getGroupMembersByMovieId($id);
        if (count($group)) {
            $text = "";
            foreach ($group as $movie) {
                $name = $movie->getName() . " " . $movie->getParsedSeason();
                if ($movie->getId() == $id)
                    $name = "<b>$name</b>";
                $text = $text . "<a href='t.me/myMovietvbetabot?start=Movie_" . $movie->getId() . "'>$name</a> <i>[" . $movie->getViewOrder() . "]</i>\n";
            }
            $menu[] = [["text" => "✏️ ORDINE DI VIEW", "callback_data" => "Settings:orderView|$id"]];
            $menu[] = [["text" => "❌ RIMUOVI DAL GRUPPO", "callback_data" => "Settings:deleteFromGroup|$id|$confirm"]];
            $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
            return $this->query->message->edit($text, $menu, "html");
        } else {
            $this->user->page("Search:groupForMovie|$id|{$this->query->message->id}");
            $menu[] = [["text" => "➕ NUOVO GRUPPO", "callback_data" => "Settings:newGroup|$id"]];
            $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
            return $this->query->message->edit("*Invia il nome del gruppo a cui vuoi aggiungerlo, oppure crearne uno nuovo:*", $menu);
        }
    }

    public function newGroup($id)
    {
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:group|$id"]];
        $this->user->page("Settings:newGroup|$id|{$this->query->message->id}");
        return $this->query->message->edit("Ok, invia il nome del nuovo gruppo", $menu, 'HTML');
    }

    public function addInGroup($id, $group)
    {
        $this->movieRepo->addInGroup($id, $group);
        $this->user->page();
        return $this->group($id);
    }

    public function orderView($id)
    {
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:group|$id"]];
        $this->user->page("Settings:orderView|$id|{$this->query->message->id}");
        return $this->query->message->edit("<b>Ok, invia l'ordine di visualizzazione del movie</b>", $menu, 'HTML');
    }

    public function deleteFromGroup($id, $confirm)
    {
        if ($confirm) {
            $this->movieRepo->removeFromGroupByMovieId($id);
            $this->home($id, 1);
        } else {
            $this->query->alert("Clicca un'altra volta per confermare");
            return $this->group($id, 1);
        }
    }

    public function duration($id)
    {
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
        $duration = $this->movieRepo->getMovieSimpleById($id)->getDuration();
        $this->user->page("Settings:duration|$id|{$this->query->message->id}");
        return $this->query->message->edit("Ok, invia la nuova durata media degli episodi:\nDurata attuale: <code>$duration min/ep</code>", $menu, 'HTML');
    }

    public function episodes($id)
    {
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
        $episodes = $this->movieRepo->getMovieSimpleById($id)->getEpisodesNumber();
        $this->user->page("Settings:episodes|$id|{$this->query->message->id}");
        return $this->query->message->edit("Ok, invia il nuovo numero di episodi:\nEpisodi attuali: <b>$episodes</b>\n\n<b>N.B.</b> <i>quando il numero di episodi è indeterminato invia 0</i>", $menu, 'HTML');
    }

    public function aired_on($id)
    {
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
        $aired = $this->movieRepo->getMovieSimpleById($id)->getAiredOn();
        //$data = $aired[2] . " " . ["", "Gennaio", "Febbraio", "Marzo", "Maggio", "Aprile", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"][(int)$aired[1]] . " " . $aired[0];
        $this->user->page("Settings:aired|$id|{$this->query->message->id}");
        return $this->query->message->edit("Ok, invia la nuova data di uscita dell'Movie:\nData attuale: <code>$aired</code>\n\n<b>N.B.</b> <i>il formato è \"giorno mese anno\"</i>", $menu, 'HTML');
    }

    public function synopsis($id)
    {
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
        $synopsis = $this->movieRepo->getMovieSimpleById($id)->getSynopsisUrl();
        $this->user->page("Settings:synopsis|$id|{$this->query->message->id}");
        return $this->query->message->edit("Ok, invia la nuova trama:\nTrama attuale: $synopsis", $menu, 'HTML');
    }

    public function epBackup($id)
    {
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
        $this->user->page("Settings:epBackup|$id|{$this->query->message->id}");
        return $this->query->message->edit("Ok, invia l'id del vecchio movie:", $menu, 'HTML');
    }

    public function trailer($id)
    {
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
        $trailer = $this->movieRepo->getMovieSimpleById($id)->getTrailer();
        $this->user->page("Settings:trailer|$id|{$this->query->message->id}");
        return $this->query->message->edit("Ok, invia il nuovo trailer:\nTrailerattuale: $trailer", $menu, 'HTML');
    }


    public function category($id, $category = null)
    {
        if (!$category) {
            $menu[] = [["text" => "FILM", "callback_data" => "Settings:category|$id|FILM"], ["text" => "TVSERIES", "callback_data" => "Settings:category|$id|TVSERIES"]];
            $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
            return $this->query->message->edit("Seleziona la categoria", $menu, 'HTML');
        } else {
            $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
            $movie = $this->movieRepo->getMovieSimpleById($id);
            $movie->setCategory($category);
            $this->movieRepo->Update($movie);

            return $this->query->message->edit("Modifica effettuata con successo!", $menu);
        }
    }

    public function genres($id, $genre = null)
    {
        if ($genre != null) {
            $this->query->alert();
            if ($this->genreRepo->checkIfMovieHasGenre($id, $genre)) {
                $this->genreRepo->removeGenreFromMovieId($genre, $id);
            } else {
                $this->genreRepo->addGenreToMovie($genre, $id);
            }
        }
        $q = $this->genreRepo->getAll();
        $x = $y = 0;
        foreach ($q as $g) {
            $check = $this->genreRepo->checkIfMovieHasGenre($id, $g->getId());
            if ($x < 2) {
                $x++;
            } else {
                $x = 1;
                $y++;
            }
            $menu[$y][] = ["text" => $g->getName() . " " . (($check !== false) ? '🔵' : '🔴'), "callback_data" => "Settings:genres|$id|{$g->getId()}"];
        }
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
        return $this->query->message->edit("Seleziona i generi:", $menu);
    }

    public function sendMovie($id)
    {
        $menu[] = [["text" => "NETFLUZ", "callaback_data" => "Settings:selectChannelToSend|$id|-1001115765309"]];
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
        $this->user->page();
        return $this->query->message->edit("Seleziona il canale:", $menu);
    }

    public function selectChannelToSend($id, $channel_id)
    {
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:sendMovie|$id"]];
        $this->user->page("Settings:sendPosterAndSend|$id|$channel_id");
        return $this->query->message->edit("Invia il poster:", $menu);
    }


    public function close()
    {
        $this->query->message->delete();
    }
}
