<?php

namespace superbot\App\Controllers\Query;

use superbot\App\Controllers\QueryController;

class PostController extends QueryController
{
    public function new()
    {
        $this->user->page("Post:poster");
        $menu[] = [["text" => "MOVIE", "callback_data" => "Post:film"], ["text" => "TVSERIES", "callback_data" => "Post:tvseries"]];
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Home:start"]];
        $this->query->message->edit("Ok, seleziona la categoria", $menu);
    }

    public function film()
    {
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Post:new"]];
        $this->query->message->edit("Ok invia il link tmdb:", $menu);
        $this->user->page("Post:url|FILM");
    }

    public function tvseries()
    {
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Post:new"]];
        $this->query->message->edit("Ok invia il numero della stagione:", $menu);
        $this->user->page("Post:season");
    }
}
