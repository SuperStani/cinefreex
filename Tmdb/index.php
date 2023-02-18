<?php
require "conf.php";
require "tmdb.php";
	#https://www.themoviedb.org/tv/https://www.themoviedb.org/tv/120494-lol-chi-ride-e-fuori-lol-chi-ride-e-fuori

$tmdb = new TMDB($cnf); 

//Insert your API Key of TMDB
//Necessary if you use default conf
$tmdb->setAPIKey('aab1d5463b33cd6c961cae40eb2086f6');
if($_GET["type"] == "TVSERIES") {
    $movie_id = $_GET["movie_id"];
    $season = $_GET["season"];
    if(isset($_GET["episode"])) {
        $episode = $tmdb->getEpisode($movie_id, $season, $_GET["episode"], $cnf);
        echo json_encode([
            "name" => $episode->getName(),
            "synopsis" => $episode->getOverview(),
            "poster" => $episode->getStill()
        ]);
        die;
    }
    $movie = $tmdb->getTVShow($movie_id);
    //var_dump($movie);
    $s = $movie->getSeason($season); 
    $air_date = $s->get("air_date");
    $episodes = $s->get("episode_count");
    $poster = $s->get("poster_path");
    if($poster == ''){
        $poster = $movie->getSeason(1)->get('poster_path');
        if($poster == ''){
            $poster = $movie->getPosterPath();
        }
    }
    $name = $movie->getName();
    $duration = $movie->getEpisodeRunTime()[0];
    $trama = "TRAMA DELLA STAGIONE:\n".$s->get("overview")."\n\nTRAMA DELLA SERIE:\n".$movie->getOverview();
    $nodes = [[
        "tag" => "p",
        "children" => [
            str_replace(["&quot;", "&#039;"], ["\"", "'"], $trama)
        ]
    ]];
    $token = "6e6bb3d16c6201fe33efdebb37bf7b912a334303d900825f0411a2f41912";
    $synopsis = json_decode(file_get_contents("https://api.telegra.ph/createPage?access_token=$token&title=" . strtoupper(urlencode($name)) . "&author_name=NETFLUZMAX&content=".urlencode(json_encode($nodes))."&return_content=true"), true)["result"]["url"];
    $genres = $movie->getGenres();
    echo json_encode([
        "id" => $movie_id,
        "name" => $name,
        "episodes" => $episodes,
        "air_date" => $air_date,
        "poster" => "https://image.tmdb.org/t/p/w500/" . $poster,
        "duration" => $duration,
        "synopsis" => $trama,
        "synopsis_url" => $synopsis,
        "genres" => $genres
    ]);

} elseif($_GET["type"] == "FILM") {
    $movie_id = $_GET["movie_id"];
    $movie = $tmdb->getMovie($movie_id);
    $air_date = $movie->getReleaseDate();
    $poster = $movie->getPosterPath();
    $name = $movie->getTitle();
    $duration = $movie->getRuntime();
    $trama = $movie->getOverview();
    $nodes = [[
        "tag" => "p",
        "children" => [
            str_replace(["&quot;", "&#039;"], ["\"", "'"], $trama)
        ]
    ]];
    $token = "6e6bb3d16c6201fe33efdebb37bf7b912a334303d900825f0411a2f41912";
    $synopsis = json_decode(file_get_contents("https://api.telegra.ph/createPage?access_token=$token&title=" . strtoupper(urlencode($name)) . "&author_name=NETFLUZMAX&content=".urlencode(json_encode($nodes))."&return_content=true"), true)["result"]["url"];

    $genres = $movie->getGenres();
    echo json_encode([
        "id" => $movie_id,
        "name" => $name,
        "episodes" => 1,
        "poster" => "https://image.tmdb.org/t/p/w500/" . $poster,
        "air_date" => $air_date,
        "duration" => $duration,
        "synopsis" => $trama,
        "synopsis_url" => $synopsis,
        "genres" => $genres
    ]);
}